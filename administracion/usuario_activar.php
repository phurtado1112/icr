<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idusuario');

error_reporting(0);

if (isset($id)) {
    $activa_usuario = "update usuarios set activo=0 WHERE idusuario='" . $id . "'";
    bd_ejecutar_sql($activa_usuario);
    
    header("Location: usuario_lista.php");
}			
	


