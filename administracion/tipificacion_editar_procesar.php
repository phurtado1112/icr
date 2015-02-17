<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$tipificacion = filter_input(INPUT_POST, 'tipificacion');
$id = filter_input(INPUT_POST, 'idtipificacion');
$idtipificaciontipo = filter_input(INPUT_POST, 'idtipificaciontipo');

error_reporting(0);

if (isset($tipificacion)) {
    $actualiza_tipificacion = "UPDATE  tipificacion set tipificacion='" .$tipificacion. "', idtipificaciontipo='" .$idtipificaciontipo. "' where idtipificacion='" . $id."'" ;
    bd_ejecutar_sql($actualiza_tipificacion);
    
    header("Location: tipificacion_lista.php");
}


