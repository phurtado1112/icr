<?php

//Iniciar Sesión
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$pais = filter_input(INPUT_POST, 'pais');
$id = filter_input(INPUT_POST, 'idpais');

error_reporting(0);

if (isset($pais)) {

    $actualiza_pais = "UPDATE  pais set pais='" . $pais. "'where idpais='" . $id . "'";
    bd_ejecutar_sql($actualiza_pais);
    
    header("Location: pais_lista.php");
}


