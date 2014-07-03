<?php

//Iniciar Sesión
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$idusuario= filter_input(INPUT_POST, 'idusuario');
$idcampania = filter_input(INPUT_POST, 'idcampania');
$id = filter_input(INPUT_POST, 'idasignar');

error_reporting(0);

$actualiza_asignacion = "UPDATE  asignar set idusuario='". $idusuario . "', idcampania='" . $idcampania . "' where idasignar='" . $id . "'";
bd_ejecutar_sql($actualiza_asignacion);

header("Location: asignacion_lista.php");


