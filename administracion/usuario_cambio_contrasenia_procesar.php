<?php

include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$contrasena = filter_input(INPUT_POST, 'contrasenia');
$contrasenac = filter_input(INPUT_POST, 'contraseniac');
$tipo = filter_input(INPUT_POST, 'tipo');
$id = filter_input(INPUT_POST, 'idusuario');

error_reporting(0);
if ($contrasena == $contrasenac) {
    if ($tipo == 2) {
        $contrasenia = md5($contrasena);
    } else {
        $contrasenia = $contrasena;
    }
}

    $actualiza_usuario = "UPDATE  usuarios set contrasena='" . $contrasenia . "' where idusuario='" . $id . "'";
    bd_ejecutar_sql($actualiza_usuario);

    header("Location: usuario_lista.php");



    