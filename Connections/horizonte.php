<?php
date_default_timezone_set('Mexico/General');
# FileName="Connection_php_mysql.htm" # Type="MYSQL" # HTTP="true"
$hostname_horizonte = "localhost";
$database_horizonte = "sigma";
$username_horizonte = "root";
$password_horizonte = "";
$horizonte = mysql_pconnect($hostname_horizonte, $username_horizonte,$password_horizonte) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_query("SET NAMES 'utf8'");
?>