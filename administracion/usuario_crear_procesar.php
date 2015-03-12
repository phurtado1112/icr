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
$contrasena = filter_input(INPUT_POST, 'contrasenia');
$tipo = filter_input(INPUT_POST, 'tipo');

error_reporting(0);

if (isset($nombre) && isset($usuario) && isset($contrasena)) {

    if ($tipo == 2) {
        $contrasenia = md5($contrasena);
    } else {
        $contrasenia = $contrasena;
    }
    
    $inserta_usuario = "INSERT INTO usuarios (nombre,usuario,contrasena,tipo)
			VALUES(
			'" . $nombre . "',
			'" . $usuario . "',
			'" . $contrasenia . "',
                        '" . $tipo . "'
			)";
    bd_ejecutar_sql($inserta_usuario);

    header("Location: usuario_lista.php");
}

