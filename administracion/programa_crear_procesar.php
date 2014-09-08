<?php
//Iniciar Sesión
include_once './funciones.general.php';
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$programa = filter_input(INPUT_POST, 'programa');

error_reporting(0);

if (isset($programa)) {    

    $inserta_programa = "INSERT INTO programas (programa)
			VALUES(
			'" . $programa . "'
			)";
    bd_ejecutar_sql($inserta_programa);
    
    header("Location: programa_lista.php");
}

