<?php

//Iniciar Sesión
include_once './funciones.general.php';
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idnoticias');

error_reporting(0);

if (isset($id)) {
    $elimina_noticia = "DELETE FROM noticias WHERE idnoticias='" . $id . "'";
    bd_ejecutar_sql($elimina_noticia);
    
    header("Location: noticias_lista.php");
}			
	


