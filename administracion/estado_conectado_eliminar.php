<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idestado');

error_reporting(0);

if (isset($id)) {
    $elimina_estado = "DELETE FROM estados WHERE idestado='" . $id . "'";
    bd_ejecutar_sql($elimina_estado);
    
    header("Location: estado_conectado_lista.php");
}			
	


