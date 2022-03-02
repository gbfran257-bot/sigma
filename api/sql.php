<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {      
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, HEAD, PUT, DELETE");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}
header('Content-Type: application/json');

$host_db = "127.0.0.1";
$user_db = "preunisa_fredd";
$pass_db = "frederic13FER";
$db_name = "preunisa_sigma_cruzroja_test";

$con = mysqli_connect($host_db,$user_db,$pass_db);
mysqli_select_db($con,$db_name);

if (isset($_GET["tabla"])) $tabla = filter_var($_GET["tabla"], FILTER_SANITIZE_STRING); else $tabla="";
if (isset($_GET["campos"])) $campos = filter_var($_GET["campos"], FILTER_SANITIZE_STRING); else $campos="";
if (isset($_GET["condicion"])) $condicion = compose($_GET["condicion"],3); else $condicion="";
if (isset($_GET["valores"])) $valores = compose($_GET["valores"],1); else $valores="";
if (isset($_GET["comando"])) $comando =  filter_var($_GET["comando"], FILTER_SANITIZE_STRING); else $comando="";
if (isset($_GET["campos_valores"])) $campos_valores = compose($_GET["campos_valores"],2); else $campos_valores="";
if (isset($_GET["limitador"])) $limitador =  $_GET["limitador"]; else $limitador="";
if (isset($_GET["token"])) $token_id = filter_var($_GET["token"], FILTER_SANITIZE_STRING); else $token_id="";

/* check token */
$sql = "SELECT * FROM usuarios WHERE token='" . $token_id . "' AND (fecha_token  + INTERVAL 7 DAY) > NOW()";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($result);
if( mysqli_num_rows($result) == 0 ) {
    $emparray = array('Error'=>"token",'token'=>$token_id,'SQL'=>$sql);

    echo json_encode($emparray);
    $sql1 = "SELECT * FROM usuarios where id_u = 3";
    $fredd = mysqli_query($con,$sql1);
    while( $row1 = mysqli_fetch_assoc($fredd) )
    {
        echo $row1['id_u'] ."\n ";
        echo $row1['nombre_u'] ."\n ";
        echo $row1['apaterno_u'] ."\n ";
        echo $row1['amaterno_u'] ."\n ";
        echo $row1['email_u'] ."\n ";
        echo $row1['token'] ."\n ";
        echo $row1['fecha_token'] ."\n ";
        echo "----------------------DATOS RECIBIDOS-----------------\n";
        echo "token: " . $token_id ."\n ";
        echo "tabla: " . $tabla ."\n ";
        echo "campos: " . $campos ."\n ";
        echo "condicion: " .$condicion ."\n ";
        echo "valores: " . $valores ."\n ";
        echo "comando:" . $comando ."\n ";
        echo "campos_valores: " . $campos_valores ."\n ";
        echo "limitador: " . $limitador ."\n ";    
    }
    mysqli_close($con);
    die;
}
/* token */

if ($comando=="INSERT") {
    $sql = 'INSERT INTO ' . $tabla . ' (' . $campos . ') VALUES(' . $valores . ') ';
}

if ($comando=="UPDATE") {
    $sql = 'UPDATE ' . $tabla . ' SET ' . $campos_valores . ' WHERE ' . $condicion ;
}

if ($comando=="SELECT") {
    $sql = 'SELECT ' . $limitador . ' FROM ' . $tabla;
    if($condicion!="") $sql .' WHERE ' . $condicion ;
}

if ($comando=="DELETE") {
    $sql = 'DELETE FROM ' . $tabla . ' WHERE ' . $condicion ;
}

$result = mysqli_query($con,$sql);
$emparray = array('sql'=> $sql,'Error'=>mysql_error($con));
while( $row = mysqli_fetch_assoc($result) )
{
    $emparray[] = $row;
}
echo json_encode($emparray);
mysqli_close($con);

function compose($svalue,$opcion) {
    if($opcion==1) {
        $valor = explode(",", $svalue);
        $elementos = count($valor);
        $i = 0;
        $nvalue = "";
        while ($i<$elementos) {
            if(es_numerico($valor[$i])) $parte = $valor[$i] ;
            else $parte = '"' . $valor[$i] . '"';
            if(strlen($nvalue)>0) $nvalue = $nvalue . "," . $parte;
            else $nvalue = $parte;
            $i++;
        }
    }
    if($opcion==2) {
        $valor = explode(",", $svalue);
        $elementos = count($valor);
        $i = 0;
        $nvalue = "";
        while ($i<$elementos) {
            $parte = $valor[$i];
            $camp = substr($parte,0,strpos($parte,"="));
            $xvalue = substr($parte,strpos($parte,"=")+1);
            if(es_numerico($xvalue)) $parte = $camp . "=" . $xvalue ;
            else $parte = '"' . $xvalue . '"';
            if(strlen($nvalue)>0) $nvalue = $nvalue . "," . $parte;
            else $nvalue = $parte;
            $i++;
        }        
    }
    if($opcion==3) {
        $svalue = trim($svalue);
        $posicoma=posicoma($svalue);
        if (strpos($svalue,"AND")+strpos($svalue,"OR")>0) {
            $parte = $svalue;
            $ands = substr_count($parte,"AND");
            $ors =  substr_count($parte,"OR");
            $parte = str_replace(str_replace($parte,"AND",","),"OR",",");
            $valor = explode(",", $svalue);
            $elementos = count($valor);
            $i = 0;
            $nvalue = "";
            while ($i<$elementos) {
                $parte = $valor[$i];
                $camp="";
                $xvalue="";
                $signo = "";
                if(strpos($parte,"=")>-1) {
                    $signo = "=";
                    $camp = substr($parte,0,strpos($parte,"="));
                    $xvalue = substr($parte,strpos($parte,"=")+1);                    
                    if(es_numerico($xvalue)) $parte = $camp . "=" . $xvalue ;
                    else $parte = '"' . $xvalue . '"';
                }
                if(strpos($parte,"|")>-1) {
                    $signo = "|";
                    $camp = substr($parte,0,strpos($parte,"|"));
                    $xvalue = substr($parte,strpos($parte,"|")+1);
                    if(es_numerico($xvalue)) $parte = $camp . "|" . $xvalue ;
                    else $parte = '"' . $xvalue . '"';
                }
                if(strpos($parte,"{")>-1) {
                    $signo = "{";
                    $camp = substr($parte,0,strpos($parte,"{"));
                    $xvalue = substr($parte,strpos($parte,"{")+1);
                    if(es_numerico($xvalue)) $parte = $camp . "{" . $xvalue ;
                    else $parte = '"' . $xvalue . '"';
                }
                $i++;
                if(strlen($nvalue)>-1) $nvalue = $nvalue . "," . $camp . $signo . $xvalue;
                else $nvalue = $parte;
            }
            if( strpos(",",$nvalue) == 0 ) $nvalue = substr($nvalue,1);
            $nvalue = rebuild($posicoma,$nvalue);
        } else {
            $parte = $svalue;
            if(strpos($svalue,"=")>-1) {
                $camp = substr($parte,0,strpos($parte,"="));
                $xvalue = substr($parte,strpos($parte,"=")+1);
                if(es_numerico($xvalue)) $parte = $camp . "=" . $xvalue ;
                else $parte = '"' . $xvalue . '"';
            }
            if(strpos($svalue,"|")>-1) {
                $camp = substr($parte,0,strpos($parte,"|"));
                $xvalue = substr($parte,strpos($parte,"|")+1);
                if(es_numerico($xvalue)) $parte = $camp . "|" . $xvalue ;
                else $parte = '"' . $xvalue . '"';
            }
            if(strpos($svalue,"{")>-1) {
                $camp = substr($parte,0,strpos($parte,"{"));
                $xvalue = substr($parte,strpos($parte,"{")+1);
                if(es_numerico($xvalue)) $parte = $camp . "{" . $xvalue ;
                else $parte = '"' . $xvalue . '"';
            }            
            $nvalue = $parte;
        }
    }

    $nvalue=str_replace("}",">",$nvalue);
    $nvalue=str_replace("{","<",$nvalue);
    $nvalue=str_replace("|","=",$nvalue);
    return $nvalue;
}

function es_numerico($s)
{
    return filter_var($s, FILTER_VALIDATE_FLOAT) !== false;
}

function posicoma($string) {
    $palabra=0;
    $exp=explode(" ", $string);
    $emparray=array();
    while (strpos($string,"AND")>-1 || strpos($string,"OR")>-1){
        $palabra = $palabra + 1;        
        if ( strpos($string," OR ")>-1 && strpos($string," AND ")>-1 ) {
            if (  strpos($string, " AND " ) < strpos($string," OR ") ) $arr = array('AND' => $palabra);
            else $arr = array('OR' => $palabra);
            $emparray[] = $arr;
            if (  strpos($string," AND ") < strpos($string," OR ") ) $string = substr( $string, strpos($string," AND ") + 5 );
            else $string = substr( $string, strpos($string," OR ") + 4 );
        } else {
            if ( strpos($string," OR ")>-1 ) {
                $arr = array('OR' => $palabra);
                $emparray[] = $arr;
                $string = substr( $string, strpos($string," OR ") + 4 );
            } else {
                $arr = array('AND' => $palabra);                
                $emparray[] = $arr;
                $string = substr( $string, strpos($string," AND ") + 5 );
            }
        }
        $exp = explode(" ", $string);
    }
    return $emparray;
}

function rebuild($xarray,$svalue) {
    $var = 1;
    foreach ($xarray as $i) {
        if ( $xarray[$i] == ['AND'] ) $svalue = str_replace(","," AND ",$svalue,$var);
        else $svalue = str_replace(","," OR ",$svalue,$var);
    }
    return $svalue;
}
?>