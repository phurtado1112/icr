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
$id = filter_input(INPUT_POST, 'idcampania');
//if ($fechainicio == '0000-00-00'){
//    $fechainicio = null;
//}
if ($terminada == 'NO') {
    $terminada = 's';
} else {
    $terminada = 'n';
}

error_reporting(0);

if (isset($campania)) {

    $actualiza_campania = "UPDATE  campanias set campania='" . $campania . "', terminada='" . $terminada . "', fechainicio='" . $fechainicio . "', fechafin='" . $fechafin . "' where idcampania='" . $id . "'";
    bd_ejecutar_sql($actualiza_campania);
    
    header("Location: campania_lista.php");
}


