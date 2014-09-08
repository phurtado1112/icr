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
    $elimina_lead = "DELETE FROM leads WHERE idlead='" . $id . "'";
    bd_ejecutar_sql($elimina_lead);
    
    header("Location: lead_lista.php");
}			
	


