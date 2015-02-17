<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$tipificacion = filter_input(INPUT_POST, 'tipificacion');
$idtipificaciontipo = filter_input(INPUT_POST, 'idtipificaciontipo');

error_reporting(0);

if (isset($tipificacion)) {    

    $inserta_tipificacion = "INSERT INTO tipificacion (tipificacion,idtipificaciontipo)
			VALUES(
			'" . $tipificacion . "',
                        '" . $idtipificaciontipo . "'
			)";
    bd_ejecutar_sql($inserta_tipificacion);
    
    header("Location: tipificacion_lista.php");
}

