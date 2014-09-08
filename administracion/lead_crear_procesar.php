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

error_reporting(0);

if (isset($lead)) {    

    $inserta_elead = "INSERT INTO leads (lead)
			VALUES(
			'" . $lead . "'
			)";
    bd_ejecutar_sql($inserta_lead);
    
    header("Location: lead_lista.php");
}

