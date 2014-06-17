<?php
include_once './funciones.general.php';
//session_start();
//$campos = array("fechafin","horafin");
//$fecha = date("Y-m-d");
//$hora = date("H:i:s");
//$datos = array($fecha,$hora);

//bd_actualizar_registro("registroconexion",$campos,$datos, "idregistroconexion", $_SESSION['idconexion']);
$actuliza_regcon = "UPDATE registroconexion SET fechafin ='". date("Y-m-d") . "',horafin ='" . date("H:i:s") . "' WHERE idregcon=". $_SESSION['idregcon'];
bd_ejecutar_sql($actuliza_regcon);

$unique_id = session_id();
$elimina_sesion = "DELETE FROM session WHERE session_id='$unique_id'";
bd_ejecutar_sql($elimina_sesion);
session_destroy();

echo '<script language = javascript>	
	self.location = "index.php"
	</script>';
