<?php 
include("../../admin/clases/Alumno.class.php");
$miAlumno=new Alumno("select2/alumno.json.php");
headerJson();
$datos=$miAlumno->select2alumno(filter_var($_POST['search'], FILTER_SANITIZE_STRING),
	filter_var($_POST['page'], FILTER_SANITIZE_STRING));
echo json_encode($datos);

