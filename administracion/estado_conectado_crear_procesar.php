<?php
//Iniciar Sesión
include_once './funciones.general.php';
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$estado = filter_input(INPUT_POST, 'estado');

error_reporting(0);

if (isset($estado)) {    

    $inserta_estado_agente = "INSERT INTO estados (estado)
			VALUES(
			'" . $estado . "'
			)";
    bd_ejecutar_sql($inserta_estado_agente);
    
    header("Location: estado_conectado_lista.php");
}

