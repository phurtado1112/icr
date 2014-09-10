<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idpais');

error_reporting(0);

if (isset($id)) {
    $inactiva_pais = "update pais set activo=1 WHERE idpais='" . $id . "'";
    bd_ejecutar_sql($inactiva_pais);
    
    header("Location: pais_lista.php");
}			
	


