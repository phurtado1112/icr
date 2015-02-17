<?php
//Iniciar Sesión
include_once './funciones.general.php';
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$tipificaciontipo = filter_input(INPUT_POST, 'tipificaciontipo');

error_reporting(0);

if (isset($tipificaciontipo)) {    

    $inserta_tipificaciontipo = "INSERT INTO tipificaciontipo (tipificaciontipo)
			VALUES(
			'" . $tipificaciontipo . "'
			)";
    bd_ejecutar_sql($inserta_tipificaciontipo);
    
    header("Location: tipificacion_tipo_lista.php");
}

