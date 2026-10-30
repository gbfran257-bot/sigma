<?php
// Compatible con PHP 5.4 o superior (sin ?? ni <=>)
$debug = !empty($_REQUEST['debug']);
if ($debug) { ini_set('display_errors', 1); error_reporting(E_ALL); }

include_once '../../recursos/session.php';   // igual que en insertarIMGsUSG.php (ajusta si es distinto)

function req($k, $d = '') { return isset($_REQUEST[$k]) ? $_REQUEST[$k] : $d; }
function tag($o, $t, $d = '') { return isset($o[$t]['Value'][0]) ? $o[$t]['Value'][0] : $d; }
function cmpn($a, $b) { return ($a < $b) ? -1 : (($a > $b) ? 1 : 0); }

/* ===== Parámetros (POST desde el botón "IMGS PACS"; también acepta GET para depurar) ===== */
$idVC  = (int)req('idVC', 0);
$fmt   = (req('fmt', 'jpg') === 'png') ? 'png' : 'jpg';
$mime  = ($fmt === 'png') ? 'image/png' : 'image/jpeg';
$cols  = max(1, min(6, (int)req('cols', 3)));   // imágenes por fila (1 a 6)
$serie = req('serie', 0) ? 1 : 0;
$solo  = (int)req('solo', 0);                    // 0 = todas las series; N = solo la serie N
$altoU = (int)req('alto', 0);                    // alto máx. por imagen en px; 0 = automático
$max   = (int)req('max', 12); if ($max < 1) { $max = 12; } if ($max > 100) { $max = 100; }

// UIDs candidatos (separados por |) y referencias candidatas (separadas por |)
$uids = array();
foreach (explode('|', req('uids', req('studyUID', ''))) as $u) {
    $u = trim($u); if (preg_match('/^[0-9.]{5,64}$/', $u)) { $uids[] = $u; }
}
$refs = array();
foreach (explode('|', req('refs', req('ref', ''))) as $r) {
    $r = preg_replace('/[^A-Za-z0-9._-]/', '', trim($r)); if ($r !== '') { $refs[] = $r; }
}

/* ===== Configuración del PACS: se prueba cada URL en orden y se usa la primera que responda ===== */
$BASES = array(
    'http://localhost:81/dcm4chee-arc/aets/DCM4CHEE/rs',      // el que pasa por tu nginx (OHIF en localhost:81)
    'http://localhost:8080/dcm4chee-arc/aets/DCM4CHEE/rs',    // dcm4chee directo
    'http://csantonio.ddns.net:8887/dcm4chee-arc/aets/DCM4CHEE/rs',
);
$USERPWD = '';   // 'usuario:clave' solo si /dcm4chee-arc pide htpasswd (error HTTP 401)
$alturas = array(1 => 480, 2 => 300, 3 => 220, 4 => 170, 5 => 140, 6 => 115);
$alto    = ($altoU >= 50 && $altoU <= 900) ? $altoU : $alturas[$cols];

$log = array();
function fallar($m) {
    global $debug, $log;
    if ($debug) { header('Content-Type: text/plain; charset=utf-8'); echo "ERROR: $m\n\n" . implode("\n", $log); }
    else { echo "ERROR: $m"; }
    exit;
}
if (!function_exists('curl_init')) { fallar('PHP no tiene la extension curl activa (en php.ini activa extension=curl y reinicia Apache).'); }
if (!$idVC) { fallar('Falta el id del estudio.'); }

function pacs_get($url, $accept) {
    global $USERPWD;
    $ch = curl_init($url);
    $op = array(CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 30, CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_HTTPHEADER => array("Accept: $accept"));
    if ($USERPWD !== '') { $op[CURLOPT_USERPWD] = $USERPWD; }
    curl_setopt_array($ch, $op);
    $body = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);
    return array($code, $body, $err);
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
        $mods = isset($s['00080061']['Value']) ? $s['00080061']['Value'] : array();
        if (in_array('US', $mods)) { return tag($s, '0020000D', null); }
    }
    return tag($a[0], '0020000D', null);
}
$studyUID = null;
foreach ($uids as $u) {
    $studyUID = buscar_estudio($PACS, 'StudyInstanceUID=' . $u);
    if ($studyUID) { break; }
}
if (!$studyUID) {
    foreach ($refs as $r) {
        $sg = str_replace(array('-', '.'), '', $r);          // 20260115-21  ->  2026011521
        foreach (array_unique(array($sg, $r)) as $v) {
            foreach (array('PatientID', 'AccessionNumber') as $campo) {
                $studyUID = buscar_estudio($PACS, "$campo=" . urlencode($v));
                if ($studyUID) { break 3; }
            }
        }
    }
}
if (!$studyUID || !preg_match('/^[0-9.]{5,64}$/', $studyUID)) {
    fallar('No se encontro el estudio en el PACS (UIDs probados: ' . implode(', ', $uids) . ' | referencias: ' . implode(', ', $refs) . ').');
}
$log[] = "Estudio localizado: $studyUID";

/* ===== 2) Instancias del estudio (QIDO-RS) ===== */
$r = pacs_get("$PACS/studies/$studyUID/instances?includefield=00200011&includefield=00200013&includefield=00280008&includefield=00080060&limit=300",
              'application/dicom+json');
$log[] = "QIDO instances -> HTTP {$r[0]}";
$inst = ($r[0] == 200) ? json_decode($r[1], true) : null;
if (!is_array($inst) || !$inst) { fallar('El estudio existe pero no devolvio instancias.'); }

$lista = array(); $ordenSerie = array();
foreach ($inst as $o) {
    $mod = tag($o, '00080060', '');
    if (in_array($mod, array('SR', 'PR', 'KO'))) { continue; }
    $ser = tag($o, '0020000E', '');
    if (!isset($ordenSerie[$ser])) { $ordenSerie[$ser] = count($ordenSerie) + 1; }
    $lista[] = array(
        'ser'  => $ser,
        'sop'  => tag($o, '00080018', ''),
        'snum' => (int)tag($o, '00200011', 0),
        'num'  => (int)tag($o, '00200013', 0),
        'frm'  => (int)tag($o, '00280008', 1),
    );
}
foreach ($lista as $k => $o) { if ($o['snum'] == 0) { $lista[$k]['snum'] = $ordenSerie[$o['ser']]; } }
if ($solo > 0) {
    $f = array();
    foreach ($lista as $o) { if ($o['snum'] == $solo) { $f[] = $o; } }
    $lista = $f;
    if (!$lista) { fallar("El estudio no tiene la serie $solo."); }
}
function ordenar($a, $b) {
    $c = cmpn($a['snum'], $b['snum']); if ($c != 0) { return $c; }
    $c = strcmp($a['ser'], $b['ser']);  if ($c != 0) { return $c; }
    return cmpn($a['num'], $b['num']);
}
usort($lista, 'ordenar');
$lista = array_slice($lista, 0, $max);

/* ===== 3) Descargar cada imagen renderizada ===== */
$dir = dirname(__FILE__) . "/../img_usg/pacs/$idVC";
if (!is_dir($dir) && !@mkdir($dir, 0775, true)) { fallar("No se pudo crear la carpeta $dir (permisos de escritura)."); }
$viejos = glob("$dir/*");
if ($viejos) { foreach ($viejos as $f) { @unlink($f); } }

$imgs = array();
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
    $imgs[] = array('src' => "imagen/img_usg/pacs/$idVC/$nombre",
                    'txt' => 'Serie ' . $o['snum'] . ' &middot; Img ' . ($o['num'] ? $o['num'] : ($k + 1)));
}
if (!$imgs) { fallar('Se encontro el estudio pero no se pudo descargar ninguna imagen.'); }

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