<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$subtipificacion = filter_input(INPUT_POST, 'subtipificacion');
$idtipificacion = filter_input(INPUT_POST, 'idtipificacion');
$id = filter_input(INPUT_POST, 'idsubtipificacion');

error_reporting(0);

if (isset($subtipificacion)) {
    $actualiza_subtipificacion = "UPDATE  subtipificacion set subtipificacion= '" . $subtipificacion."', idtipificacion= '". $idtipificacion."' where idsubtipificacion='" . $id."'" ;
    bd_ejecutar_sql($actualiza_subtipificacion);
    
    header("Location: subtipificacion_lista.php");
}


