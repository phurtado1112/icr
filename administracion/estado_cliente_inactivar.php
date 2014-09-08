<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idestadocliente');

error_reporting(0);

if (isset($id)) {
    $inactiva_lead = "update estadocliente set activo=1 WHERE idlead='" . $id . "'";
    bd_ejecutar_sql($inactiva_lead);
    
    header("Location: lead_lista.php");
}			
	


