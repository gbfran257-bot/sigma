<?php
date_default_timezone_set('Mexico/General');
# FileName="Connection_php_mysql.htm" # Type="MYSQL" # HTTP="true"
$hostname_ipacs = "localhost";
$database_ipacs = "pacsdb";
$username_ipacs = "root";
$password_ipacs = "Garbage1.0";
$ipacs = mysql_pconnect($hostname_ipacs, $username_ipacs, $password_ipacs) or trigger_error(mysql_error(),E_USER_ERROR); 
?>