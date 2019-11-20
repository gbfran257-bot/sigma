<?php require_once('../Connections/ppcd.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO area (nombre) VALUES (%s)",
                       GetSQLValueString($_POST['x'], "text"));

  mysql_select_db($database_ppcd, $ppcd);
  $Result1 = mysql_query($insertSQL, $ppcd) or die(mysql_error());
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<script src="../jquery1-7-2/jquery-1.7.2.js"></script>
<script src="jquery.validate.js"></script>
<script>
$(document).ready(function() {
	$('#form1').validate();    
});
</script>
</head>

<body>
<form name="form1" method="POST" action="<?php echo $editFormAction; ?>" id="form1">
  <p>
    <label for="x"></label>
    <input type="text" name="x" id="x" class="required">
  </p>
  <p>
    <input type="submit" name="l" id="l" value="Enviar">
  </p>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>