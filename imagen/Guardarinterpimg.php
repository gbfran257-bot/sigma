cat > imagen/files-serverside/guardarInterpImg.php <<'EOF'
<?php
include_once '../../recursos/session.php';
include_once '../../Connections/database.php';

$idE = isset($_POST['idE']) ? (int)$_POST['idE'] : 0;
$idU = isset($_POST['idU']) ? (int)$_POST['idU'] : 0;
$dx  = isset($_POST['dx'])  ? $_POST['dx'] : '';
if($idE <= 0){ echo 'ID de estudio inválido'; exit; }

$st = $mysqli->prepare("INSERT INTO usg_interpretacion_imagen (id_vc, contenido, id_usuario, fecha_mod)
                        VALUES (?,?,?,NOW())
                        ON DUPLICATE KEY UPDATE contenido=VALUES(contenido), id_usuario=VALUES(id_usuario), fecha_mod=NOW()");
$st->bind_param('isi', $idE, $dx, $idU);
echo $st->execute() ? 1 : $mysqli->error;
EOF

cat > imagen/files-serverside/datosInterpImg.php <<'EOF'
<?php
include_once '../../recursos/session.php';
include_once '../../Connections/database.php';

$idE = isset($_POST['idE']) ? (int)$_POST['idE'] : 0;
$st = $mysqli->prepare("SELECT contenido FROM usg_interpretacion_imagen WHERE id_vc=?");
$st->bind_param('i', $idE);
$st->execute();
$st->bind_result($contenido);
if($st->fetch()){ echo $contenido; }
EOF
