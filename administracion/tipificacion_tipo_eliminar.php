<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$id = filter_input(INPUT_GET, 'idtipificaciontipo');

error_reporting(0);

if (isset($id)) {
    $elimina_tipificaciontipo = "DELETE FROM tipificaciontipo WHERE idtipificaciontipo='" . $id . "'";
    bd_ejecutar_sql($elimina_tipificaciontipo);
    
    header("Location: tipificacion_tipo_lista.php");
}