<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$idasignar = $_SESSION['idasignar'];
$Post1 = filter_input(INPUT_POST, 'Nombre');
$Post2 = filter_input(INPUT_POST, 'Telefono');
$Post3 = filter_input(INPUT_POST, 'Correo');
$Post4 = filter_input(INPUT_POST, 'Celular');
$Post5 = filter_input(INPUT_POST, 'TelTrabajo');
$Post6 = filter_input(INPUT_POST, 'Cargo');
$Post7 = filter_input(INPUT_POST, 'Empresa');
$Post8 = filter_input(INPUT_POST, 'prioridad');
$Post9 = filter_input(INPUT_POST, 'idpais');

$consulta_agregar_cliente="insert into clientes (idasignar,nombre,telfijo,email,telmovil,teltrabajo,cargo,empresa,prioridad,idpais,idestado) "
        . "values(".$idasignar.",'".$Post1."','".$Post2."','".$Post3."','".$Post4."','".$Post5."','".$Post6."','".$Post7."','".$Post8."','".$Post9."','0')";

error_reporting(0);
if (isset($Post1)) {
    bd_ejecutar_sql($consulta_agregar_cliente);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <META HTTP-EQUIV="Refresh" CONTENT="1; URL=cliente_nuevo.php">
    </head>
    <body id="pcenter">
        <img src="images/loading_gif.gif" alt="" width="508" height="381">
    </body>
</html>

