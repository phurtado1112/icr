<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idlead');

error_reporting(0);

if (isset($id)) {
    $activa_lead = "update leads set activo=0 WHERE idlead='" . $id . "'";
    bd_ejecutar_sql($activa_lead);
    
    header("Location: lead_lista.php");
}			
	


