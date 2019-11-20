<?php
class myDBC {
 
    public $mysqli = null;
 
    public function __construct() {
 
        include_once 'dbconfig.php';
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
 
        if ($this->mysqli->connect_errno) {
            echo "Error MySQLi: ("&nbsp. $this->mysqli->connect_errno.") " . $this->mysqli->connect_error;
            exit();
        }
        $this->mysqli->set_charset("utf8");
    }
 
    public function __destruct() {
        $this->CloseDB();
    }
 
    public function runQuery($qry) {
        $result = $this->mysqli->query($qry);
        return $result;
    }
 
    public function CloseDB() {
        $this->mysqli->close();
    }
 
    public function clearText($text) {
        $text = trim($text);
        return $this->mysqli->real_escape_string($text);
    }
 
    public function obtenerPersona($matricula)
    {
		//Obtener todos los campos de la tabla
        $q = "select * FROM persona WHERE matricula = '$matricula'";
        
        //$result = $this->mysqli->query($q);
        $result = $this->runQuery($q);
        //Array asociativo que contendrá los datos
        $valores = array();
                //Si no hay resultados
                //Se avisa al usuario y se redirige al index de la aplicación
        if( $result->num_rows == 0)
        {
            return $valores;
        }
          //En otro caso, se recibe la información y se
          //se regresa un array con los datos de la consulta
		else{
			//while($row = mysqli_fetch_object($result))
			while($row = $result->fetch_assoc())
			{
				//Se agrega cada valor en el array
				array_push($valores, $row);
			}
		}
			//Regresa array asociativo
			return $valores;
	}//Fin obtenerPersona
	
}//Fin clase
?>
