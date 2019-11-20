<?php require_once('../../../Connections/horizonte.php'); ?>
<?php if (!defined('DATATABLES')) exit(); // Ensure being used in DataTables env.

// Enable error reporting for debugging (remove for production)
error_reporting(E_ALL);
ini_set('display_errors', '1');


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Database user / pass
 */
$sql_details = array(
	"type" => "Mysql",  // Database type: "Mysql", "Postgres", "Sqlite" or "Sqlserver"
	"user" => $username_horizonte,//"root",       // Database user name
	"pass" => $password_horizonte,//"garbage20",       // Database password
	"host" => $hostname_horizonte,//"localhost",       // Database host
	"port" => "",       // Database connection port (can be left empty for default)
	"db"   => $database_horizonte,//"sigma",       // Database name
	"dsn"  => "charset=utf8"        // PHP DSN extra information. Set as `charset=utf8` if you are using MySQL
);


