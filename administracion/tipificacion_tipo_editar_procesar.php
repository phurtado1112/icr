<?php

//Iniciar Sesión
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$tipificaciontipo = filter_input(INPUT_POST, 'tipificaciontipo');
$id = filter_input(INPUT_POST, 'idtipificaciontipo');

error_reporting(0);

if (isset($tipificaciontipo)) {

    $actualiza_tipificaciontipo = "UPDATE tipificaciontipo set tipificaciontipo='" . $tipificaciontipo. "'where idtipificaciontipo='" . $id . "'";
    bd_ejecutar_sql($actualiza_tipificaciontipo);
    
    header("Location: tipificacion_tipo_lista.php");
}


