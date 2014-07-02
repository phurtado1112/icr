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

error_reporting(0);

$inserta_asignacion = "INSERT INTO asignar (idusuario,idcampania,fecha)
                    VALUES(
                    '" . $idusuario . "',
                    '" . $idcampania . "',
                    '" . date('Y-m-d') . "'
                    )";
bd_ejecutar_sql($inserta_asignacion);

header("Location: asignacion_lista.php");

