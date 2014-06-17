<?php
include_once './funciones.general.php';
//session_start();

//$actulizar = "UPDATE registroconexion SET fechafin ='". date("Y-m-d") . "',horafin ='" . date("H:i:s") . "' WHERE idregistroconexion='" . $_SESSION['idconncect'] . "'";
//bd_ejecutar_sql($actulizar);

$unique_id = session_id();
$eliminar = "DELETE FROM session WHERE session_id='$unique_id'";
bd_ejecutar_sql($eliminar);
session_destroy();

echo '<script language = javascript>	
	self.location = "acceso_camp.php"
	</script>';
