<?php
//Iniciar Sesión
include_once './funciones.general.php';
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$campania = filter_input(INPUT_POST, 'campania');
$terminada = filter_input(INPUT_POST, 'terminada');
$fechainicio = filter_input(INPUT_POST, 'fechainicio');
$fechafin = filter_input(INPUT_POST, 'fechafin');

error_reporting(0);

if (isset($campania)) {    

    $inserta_camapania = "INSERT INTO campanias (campania,terminada,fechainicio,fechafin)
			VALUES(
			'" . $campania . "',
			'" . $terminada . "',
			'" . $fechainicio . "',
                        '" . $fechafin . "'
			)";
    bd_ejecutar_sql($inserta_camapania);
    
    header("Location: campania_lista.php");
}

