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

error_reporting(0);

if (isset($pais)) {    

    $inserta_pais = "INSERT INTO pais (pais)
			VALUES(
			'" . $pais . "'
			)";
    bd_ejecutar_sql($inserta_pais);
    
    header("Location: pais_lista.php");
}

