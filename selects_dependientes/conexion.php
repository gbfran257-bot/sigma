<?php
function conectar()
{
	mysql_connect("localhost", "koby", "prodets123");
	mysql_select_db("prodets");
}

function desconectar()
{
	mysql_close();
}
?>