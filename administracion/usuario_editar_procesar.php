<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$nombre = filter_input(INPUT_POST, 'nombre');
$usuario = filter_input(INPUT_POST, 'usuario');
$tipo = filter_input(INPUT_POST, 'tipo');
$id = filter_input(INPUT_POST, 'idusuario');

error_reporting(0);

if (isset($nombre) && isset($usuario)) {

    $actualiza_usuario = "UPDATE  usuarios SET nombre='" . $nombre. "', usuario='" . $usuario . "', tipo='" . $tipo . "' WHERE idusuario='" . $id . "'";
    bd_ejecutar_sql($actualiza_usuario);
    
    header("Location: usuario_lista.php");
}


