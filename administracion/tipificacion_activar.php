<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idtipificacion');

error_reporting(0);

if (isset($id)) {
    $activa_tipificacion = "update tipificacion set activo=0 WHERE idtipificacion='" . $id . "'";
    bd_ejecutar_sql($activa_tipificacion);
    
    header("Location: tipificacion_lista.php");
}			
	


