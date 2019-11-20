<?php
	require_once('horizonte.php');
	//initialize variables to hold connection parameters
	$username = $username_horizonte;
	$dsn = 'mysql:host='.$hostname_horizonte.'; dbname='.$database_horizonte;
	$password = $password_horizonte;
	
	try{
		//create an instance of the PDO class with the required parameters
		$db = new PDO($dsn, $username, $password);
	
		//set pdo error mode to exception
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		//display success message
		//echo "Connected to the register database";
	
	}catch (PDOException $ex){
		//display error message
		echo "Connection failed ".$ex->getMessage();
	}
