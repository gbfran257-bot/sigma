<?php
require("../Connections/horizonte.php");
require("../funciones/php/values.php");

  session_start();

  if (isset($_SESSION['MM_Username'])) { //if you have more session-vars that are needed for login, also check if they are set and refresh them as well
    $_SESSION['MM_Username'] = $_SESSION['MM_Username'];
	$_SESSION['MM_UserGroup'] = $_SESSION['MM_UserGroup'];
	$_SESSION['PrevUrl'] = $_SESSION['PrevUrl'];
  }
  
mysql_close($horizonte);
?>