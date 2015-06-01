<?php
include_once './funciones.general.php';
include_once './constantes.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

include_once '../menu_superior.php';
include_once INICIO.'/reportes/index.php';
include_once './pie.php';



