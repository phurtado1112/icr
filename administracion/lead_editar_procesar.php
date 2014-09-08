<?php

//Iniciar Sesión
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$lead = filter_input(INPUT_POST, 'lead');
$id = filter_input(INPUT_POST, 'idlead');

error_reporting(0);

if (isset($lead)) {

    $actualiza_lead = "UPDATE leads set lead='" . $lead. "'where idlead='" . $id . "'";
    bd_ejecutar_sql($actualiza_lead);
    
    header("Location: lead_lista.php");
}


