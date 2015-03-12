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
$id = filter_input(INPUT_POST, 'idusuario');

error_reporting(0);

if($tipo==2){
    $tipo = md5($tipo);
}

if (isset($nombre) && isset($usuario) && isset($contrasena)) {
    
    if ($tipo == 2) {
        $contrasenia = md5($contrasena);
    } else {
        $contrasenia = $contrasena;
    }

    $actualiza_usuario = "UPDATE  usuarios set nombre='" . $nombre. "', usuario='" . $usuario . "', contrasena='" . $contrasenia . "', tipo='" . $tipo . "' where idusuario='" . $id . "'";
    bd_ejecutar_sql($actualiza_usuario);
    
    header("Location: usuario_lista.php");
}


