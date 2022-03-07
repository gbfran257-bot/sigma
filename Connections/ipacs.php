<?php
date_default_timezone_set('Mexico/General');
# FileName="Connection_php_mysql.htm" # Type="MYSQL" # HTTP="true"
$hostname_ipacs = "localhost";
$database_ipacs = "pacsdb";
$username_ipacs = "root";
$password_ipacs = "Garbage1.0";
try{
	$ipacs = pg_connect("host=127.0.0.1 port=5432 dbname=pacsdb user=pacs password=pacs");
}catch (Exception $e) {
	echo "Error: ";
	var_dump($e);
}
//$ipacs = mysql_pconnect($hostname_ipacs, $username_ipacs, $password_ipacs) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
