<?php
//Iniciar Sesión
include_once './funciones.general.php';
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$idcampania = filter_input(INPUT_POST, 'idcampania');
$idprograma = filter_input(INPUT_POST, 'idprograma');

error_reporting(0);

$actualiza_asignacion_prog = "UPDATE  campanias set idprograma='". $idprograma . "'where idcampania='" . $idcampania . "'";
bd_ejecutar_sql($actualiza_asignacion_prog);

header("Location: asignacion_programa_lista.php");


