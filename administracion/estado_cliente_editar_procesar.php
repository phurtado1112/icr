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

    $actualiza_estado_cliente = "UPDATE  estadoscliente set estadocliente='" . $estado. "'where idestadoscliente='" . $id . "'";
    bd_ejecutar_sql($actualiza_estado_cliente);
    
    header("Location: estado_cliente_lista.php");
}


