<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idtipificacion');

error_reporting(0);

if (isset($id)) {
    $elimina_tipificacion = "DELETE FROM tipificacion WHERE idtipificacion='" . $id . "'";
    bd_ejecutar_sql($elimina_tipificacion);
    
    header("Location: tipificacion_lista.php");
}			
	


