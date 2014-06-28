<?php

//Iniciar Sesión
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$estado = filter_input(INPUT_POST, 'estado');
$id = filter_input(INPUT_POST, 'idestado');

error_reporting(0);

if (isset($estado)) {

    $actualiza_estado_conectado = "UPDATE  estados set estado='" . $estado. "'where idestado='" . $id . "'";
    bd_ejecutar_sql($actualiza_estado_conectado);
    
    header("Location: estado_conectado_lista.php");
}


