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

error_reporting(0);

if (isset($titulo) && isset($contenido)) {    

    $inserta_noticia = "INSERT INTO noticias (titulo,contenido,fechacreado)
			VALUES(
			'" . $titulo . "',
			'" . $contenido . "',
			'" . date("Y-m-d") . "'
			)";
    bd_ejecutar_sql($inserta_noticia);
    
    header("Location: noticias_lista.php");
}

