<?php
include_once '../../recursos/session.php';   // igual que en insertarIMGsUSG.php (ajusta si es distinto)

/* ===== Parámetros (POST desde el botón "IMGS PACS"; también acepta GET para depurar) ===== */
$idVC  = (int)($_REQUEST['idVC'] ?? 0);
$fmt   = (($_REQUEST['fmt'] ?? 'jpg') === 'png') ? 'png' : 'jpg';
$mime  = ($fmt === 'png') ? 'image/png' : 'image/jpeg';
$cols  = max(1, min(4, (int)($_REQUEST['cols'] ?? 3)));
$serie = !empty($_REQUEST['serie']) ? 1 : 0;
$max   = (int)($_REQUEST['max'] ?? 12); if ($max < 1) { $max = 12; } if ($max > 100) { $max = 100; }
$debug = !empty($_REQUEST['debug']);

// UIDs candidatos (separados por |) y referencias candidatas (separadas por |)
$uids = [];
foreach (explode('|', $_REQUEST['uids'] ?? ($_REQUEST['studyUID'] ?? '')) as $u) {
    $u = trim($u); if (preg_match('/^[0-9.]{5,64}$/', $u)) { $uids[] = $u; }
}
$refs = [];
foreach (explode('|', $_REQUEST['refs'] ?? ($_REQUEST['ref'] ?? '')) as $r) {
    $r = preg_replace('/[^A-Za-z0-9._-]/', '', trim($r)); if ($r !== '') { $refs[] = $r; }
}

/* ===== Configuración del PACS: se prueba cada URL en orden y se usa la primera que responda ===== */
$BASES = [
    'http://localhost:81/dcm4chee-arc/aets/DCM4CHEE/rs',      // el que pasa por tu nginx (OHIF en localhost:81)
    'http://localhost:8080/dcm4chee-arc/aets/DCM4CHEE/rs',    // dcm4chee directo
    'http://csantonio.ddns.net:8887/dcm4chee-arc/aets/DCM4CHEE/rs',
];
$USERPWD = '';   // 'usuario:clave' solo si /dcm4chee-arc pide htpasswd (error HTTP 401)
$alturas = [1 => 480, 2 => 300, 3 => 220, 4 => 170];
$alto    = $alturas[$cols];

$log = [];
function fallar($m) {
    global $debug, $log;
    if ($debug) { header('Content-Type: text/plain; charset=utf-8'); echo "ERROR: $m\n\n" . implode("\n", $log); }
    else { echo "ERROR: $m"; }
    exit;
}
if (!function_exists('curl_init')) { fallar('PHP no tiene la extensión curl activa (en php.ini activa extension=curl y reinicia Apache).'); }
if (!$idVC) { fallar('Falta el id del estudio.'); }

function pacs_get($url, $accept) {
    global $USERPWD;
    $ch = curl_init($url);
    $op = [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 30, CURLOPT_CONNECTTIMEOUT => 5,
           CURLOPT_HTTPHEADER => ["Accept: $accept"]];
    if ($USERPWD !== '') { $op[CURLOPT_USERPWD] = $USERPWD; }
    curl_setopt_array($ch, $op);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);
    return [$code, $body, $err];
}

/* ===== 0) Elegir la URL del PACS que responde ===== */
$PACS = null;
foreach ($BASES as $b) {
    $r = pacs_get("$b/studies?limit=1", 'application/dicom+json');
    $log[] = "Probando $b -> HTTP {$r[0]} {$r[2]}";
    if ($r[0] == 200 || $r[0] == 204) { $PACS = $b; break; }
}
if (!$PACS) { fallar('No se pudo conectar con el PACS desde el servidor PHP. Revisa $BASES (y $USERPWD si hay HTTP 401).'); }

/* ===== 1) Localizar el estudio: por UID, y si no, por referencia (PatientID / AccessionNumber) ===== */
function buscar_estudio($PACS, $query) {
    global $log;
    $r = pacs_get("$PACS/studies?$query&includefield=00080061&limit=20", 'application/dicom+json');
    $log[] = "QIDO studies?$query -> HTTP {$r[0]}";
    if ($r[0] != 200) { return null; }
    $a = json_decode($r[1], true);
    if (!is_array($a) || !$a) { return null; }
    foreach ($a as $s) {                                   // preferir el estudio de ultrasonido
        if (in_array('US', $s['00080061']['Value'] ?? [])) { return $s['0020000D']['Value'][0] ?? null; }
    }
    return $a[0]['0020000D']['Value'][0] ?? null;
}
$studyUID = null;
foreach ($uids as $u) {
    $studyUID = buscar_estudio($PACS, 'StudyInstanceUID=' . $u);
    if ($studyUID) { break; }
}
if (!$studyUID) {
    foreach ($refs as $r) {
        $sg = str_replace(['-', '.'], '', $r);              // 20260115-21  ->  2026011521
        foreach (array_unique([$sg, $r]) as $v) {
            foreach (['PatientID', 'AccessionNumber'] as $campo) {
                $studyUID = buscar_estudio($PACS, "$campo=" . urlencode($v));
                if ($studyUID) { break 3; }
            }
        }
    }
}
if (!$studyUID || !preg_match('/^[0-9.]{5,64}$/', $studyUID)) {
    fallar('No se encontró el estudio en el PACS (UIDs probados: ' . implode(', ', $uids) . ' | referencias: ' . implode(', ', $refs) . ').');
}
$log[] = "Estudio localizado: $studyUID";

/* ===== 2) Instancias del estudio (QIDO-RS) ===== */
$r = pacs_get("$PACS/studies/$studyUID/instances?includefield=00200011&includefield=00200013&includefield=00280008&includefield=00080060&limit=300",
              'application/dicom+json');
$log[] = "QIDO instances -> HTTP {$r[0]}";
$inst = ($r[0] == 200) ? json_decode($r[1], true) : null;
if (!is_array($inst) || !$inst) { fallar('El estudio existe pero no devolvió instancias.'); }

$lista = []; $ordenSerie = [];
foreach ($inst as $o) {
    $mod = $o['00080060']['Value'][0] ?? '';
    if (in_array($mod, ['SR', 'PR', 'KO'])) { continue; }
    $ser = $o['0020000E']['Value'][0] ?? '';
    if (!isset($ordenSerie[$ser])) { $ordenSerie[$ser] = count($ordenSerie) + 1; }
    $lista[] = [
        'ser'  => $ser,
        'sop'  => $o['00080018']['Value'][0] ?? '',
        'snum' => (int)($o['00200011']['Value'][0] ?? 0),
        'num'  => (int)($o['00200013']['Value'][0] ?? 0),
        'frm'  => (int)($o['00280008']['Value'][0] ?? 1),
    ];
}
foreach ($lista as $k => $o) { if ($o['snum'] == 0) { $lista[$k]['snum'] = $ordenSerie[$o['ser']]; } }
usort($lista, function ($a, $b) {
    return ($a['snum'] <=> $b['snum']) ?: strcmp($a['ser'], $b['ser']) ?: ($a['num'] <=> $b['num']);
});
$lista = array_slice($lista, 0, $max);

/* ===== 3) Descargar cada imagen renderizada ===== */
$dir = __DIR__ . "/../img_usg/pacs/$idVC";
if (!is_dir($dir) && !@mkdir($dir, 0775, true)) { fallar("No se pudo crear la carpeta $dir (permisos de escritura)."); }
foreach (glob("$dir/*") as $f) { @unlink($f); }

$imgs = [];
foreach ($lista as $k => $o) {
    if (!preg_match('/^[0-9.]+$/', $o['ser']) || !preg_match('/^[0-9.]+$/', $o['sop'])) { continue; }
    $u = "$PACS/studies/$studyUID/series/{$o['ser']}/instances/{$o['sop']}";
    $u .= ($o['frm'] > 1) ? '/frames/' . (int)ceil($o['frm'] / 2) . '/rendered?viewport=900,700'
                          : '/rendered?viewport=900,700';
    $r = pacs_get($u, $mime);
    $log[] = "rendered instancia " . ($k + 1) . " -> HTTP {$r[0]} " . strlen((string)$r[1]) . " bytes";
    if ($r[0] != 200 || !$r[1]) { continue; }
    $nombre = sprintf('img_%02d.%s', $k + 1, $fmt);
    file_put_contents("$dir/$nombre", $r[1]);
    $imgs[] = ['src' => "imagen/img_usg/pacs/$idVC/$nombre",
               'txt' => 'Serie ' . $o['snum'] . ' &middot; Img ' . ($o['num'] ?: ($k + 1))];
}
if (!$imgs) { fallar('Se encontró el estudio pero no se pudo descargar ninguna imagen.'); }

/* ===== 4) HTML para el editor ===== */
$ancho = floor(100 / $cols);
$html  = '<table style="width:100%;table-layout:fixed;" border="0" cellspacing="4" cellpadding="2"><tbody>';
foreach (array_chunk($imgs, $cols) as $fila) {
    $html .= '<tr>';
    foreach ($fila as $im) {
        $html .= '<td style="width:' . $ancho . '%;text-align:center;vertical-align:top;">'
               . '<img src="' . $im['src'] . '" style="max-width:100%;max-height:' . $alto . 'px;">';
        if ($serie) { $html .= '<br><span style="font-size:10px;">' . $im['txt'] . '</span>'; }
        $html .= '</td>';
    }
    for ($j = count($fila); $j < $cols; $j++) { $html .= '<td style="width:' . $ancho . '%;"></td>'; }
    $html .= '</tr>';
}
$html .= '</tbody></table><br>';

if ($debug) { header('Content-Type: text/plain; charset=utf-8'); echo "OK\n\n" . implode("\n", $log) . "\n\n" . $html; exit; }
echo $html;
