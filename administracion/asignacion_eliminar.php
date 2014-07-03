<?php

//Iniciar Sesión
include_once './funciones.general.php';
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idasignar');

error_reporting(0);

if (isset($id)) {
    $elimina_asignacion = "DELETE FROM asignar WHERE idasignar='" . $id . "'";
    bd_ejecutar_sql($elimina_asignacion);
    
    header("Location: asignacion_lista.php");
}			
	


