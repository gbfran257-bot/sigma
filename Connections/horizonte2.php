<?php

date_default_timezone_set('Mexico/General');

$hostname = "localhost";
$database = "sigma";
$username = "sigmauser";
$password = "root";
$horizonte = mysqli_connect($hostname, $username, $password, $database) or trigger_error(mysqli_error($horizonte), E_USER_ERROR);

mysqli_query($horizonte, "SET NAMES 'utf8'");
