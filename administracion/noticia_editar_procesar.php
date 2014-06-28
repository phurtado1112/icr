<?php

//Iniciar Sesión
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$titulo = filter_input(INPUT_POST, 'titulo');
$contenido = filter_input(INPUT_POST, 'contenido');
$id = filter_input(INPUT_POST, 'idnoticias');

error_reporting(0);

if (isset($titulo) && isset($contenido)) {

    $actualiza_noticia = "UPDATE  noticias set titulo='" . $titulo. "', contenido='" . $contenido . "' where idnoticias='" . $id . "'";
    bd_ejecutar_sql($actualiza_noticia);
    
    header("Location: noticias_lista.php");
}


