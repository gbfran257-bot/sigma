<?php
require("../../Connections/horizonte.php");
require("../../funciones/php/values.php");

 $id_u = sqlValue($_POST["id_u"], "int"); $contra_actual = sqlValue($_POST["contra_actual"], "text");
 $contra_new = sqlValue($_POST["contra_new"], "text");$re_contra_new = sqlValue($_POST["re_contra_new"], "text");
 
 mysql_select_db($database_horizonte, $horizonte);
 $resultS=mysql_query("SELECT contrasena_u from usuarios where id_u = $id_u",$horizonte) or die (mysql_error());
 $rowS = mysql_fetch_row($resultS); $contrasena_hashed = $rowS[0]; $password = $_POST["contra_actual"];
 if($_POST["contra_actual"]==NULL){ echo 2; }elseif($_POST["contra_new"]==NULL){echo 3;}elseif($_POST["re_contra_new"]==NULL){ echo 4;}
 else{
	 if($_POST["contra_new"]==$_POST["re_contra_new"]){
		 if(strlen($_POST["contra_new"])>5){
			if(password_verify($password, $contrasena_hashed)){
				$hashed_password = sqlValue(password_hash($_POST["contra_new"], PASSWORD_DEFAULT), "text");
				mysql_select_db($database_horizonte, $horizonte); 
				$sql = "UPDATE usuarios set contrasena_u = $hashed_password where id_u = $id_u limit 1";
				$update = mysql_query($sql, $horizonte) or die (mysql_error());
				if(!$update){echo $sql; }else{ echo 1; }
			 }else{echo 0;}	
		 }else{ echo 6; }	 
	 }else{ echo 5; }
 }
 //Cerrar conexión a la Base de Datos
 mysql_close($horizonte);
?>