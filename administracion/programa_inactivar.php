<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idprograma');

error_reporting(0);

if (isset($id)) {
    $inactiva_programa = "update programas set activo=1 WHERE idprograma='" . $id . "'";
    bd_ejecutar_sql($inactiva_programa);
    
    header("Location: programa_lista.php");
}