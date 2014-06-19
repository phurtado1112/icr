<?php
include_once './funciones.general.php';

$unique_id = session_id();
$eliminar = "DELETE FROM session WHERE session_id='$unique_id'";
bd_ejecutar_sql($eliminar);
session_destroy();

echo '<script language = javascript>	
	self.location = "acceso_camp.php"
	</script>';
