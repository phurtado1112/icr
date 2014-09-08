<?php

//Iniciar Sesión
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$programa = filter_input(INPUT_POST, 'programa');
$id = filter_input(INPUT_POST, 'idprograma');

error_reporting(0);

if (isset($programa)) {

    $actualiza_programa = "UPDATE programas set programa='" . $programa. "'where idprograma='" . $id . "'";
    bd_ejecutar_sql($actualiza_programa);
    
    header("Location: programa_lista.php");
}