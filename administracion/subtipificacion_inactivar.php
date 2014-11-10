<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idsubtipificacion');

error_reporting(0);

if (isset($id)) {
    $inactiva_subtipificacion = "update subtipificacion set activo=1 WHERE idsubtipificacion='" . $id . "'";
    bd_ejecutar_sql($inactiva_subtipificacion);
    
    header("Location: subtipificacion_lista.php");
}			
	


