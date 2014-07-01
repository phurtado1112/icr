<?php

//Iniciar Sesión
include_once './funciones.general.php';
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idcampania');

error_reporting(0);

if (isset($id)) {
    $elimina_campania = "DELETE FROM campanias WHERE idcampania='" . $id . "'";
    bd_ejecutar_sql($elimina_campania);
    
    header("Location: campania_lista.php");
}			
	


