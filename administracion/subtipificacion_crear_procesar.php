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

error_reporting(0);

if (isset($subtipificacion)) {    

    $inserta_subtipificacion = "INSERT INTO subtipificacion (subtipificacion, idtipificacion)
			VALUES(
                        '" . $subtipificacion . "',
			'" . $idtipificacion . "'
			)";
    bd_ejecutar_sql($inserta_subtipificacion);
    
    header("Location: subtipificacion_lista.php");
}

