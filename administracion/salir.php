<?php
include_once './funciones.general.php';

$actuliza_regcon = "UPDATE registroconexion SET fechafin ='". date("Y-m-d") . "',horafin ='" . date("H:i:s") . "' WHERE idregcon=". $_SESSION['idregcon'];
bd_ejecutar_sql($actuliza_regcon);

$unique_id = session_id();
$elimina_sesion = "DELETE FROM session WHERE session_id='$unique_id'";
bd_ejecutar_sql($elimina_sesion);
session_destroy();

echo '<script language = javascript>	
	self.location = "index.php"
	</script>';

