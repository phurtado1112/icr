<?php
//Iniciar Sesión
include_once './funciones.general.php';
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$idprograma = filter_input(INPUT_POST, 'idprograma');
$idcampania = filter_input(INPUT_POST, 'idcampania');

error_reporting(0);

$inserta_asignacion_prog = "update campanias set idprograma='".$idprograma."' where idcampania='".$idcampania."'";
bd_ejecutar_sql($inserta_asignacion_prog);

header("Location: asignacion_programa_lista.php");

