<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}
//error_reporting(0);
//include "conexion.php";
$cte = filter_input(INPUT_POST, 'ajxcliente');
$usua = filter_input(INPUT_POST, 'ajxuser');
$fin = filter_input(INPUT_POST, 'ajxfinales');
$sub = filter_input(INPUT_POST, 'ajxsubfinal');
$obs = filter_input(INPUT_POST, 'ajxobservacion');
$age = filter_input(INPUT_POST, 'ajxagendar');

if (isset($cte)) {

    $consulta_actualizacion_clientes= "update clientes set idestado=1 where idcliente='" . $cte . "'";
    bd_ejecutar_sql($consulta_actualizacion_clientes);

    $consulta_actualizacion_agenda = "update agenda SET gestionado=1 WHERE idcliente='" . $cte . "'";
    bd_ejecutar_sql($consulta_actualizacion_agenda);

    $consulta_agregar_transaccion = "INSERT INTO transaccion (idcliente,idusuario,idtipificacion,idsubtipificacion,fecha,hora,observaciones,idcampania)
			VALUES(
                            '" . $cte . "',
                            '" . $usua . "',
                            '" . $fin . "',
                            '" . $sub . "',
                            '" . date("Y-m-d") . "',
                            '" . date('H:i:s') . "',
                            '" . $obs . "',
                            '" . $_SESSION['idcampania'] . "'
			)";
    bd_ejecutar_sql($consulta_agregar_transaccion);

    if ($age == '0000-00-00') {
        
    } else {
        $consulta_agregar_agenda = "INSERT INTO agenda (idcliente,fecha)
				VALUES(
				'" . $cte . "',			
				'" . $age . "'
				)";
        bd_ejecutar_sql($consulta_agregar_agenda);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registro Guardado...</title>
</head>
<body>
        <center><h3>Registro Guardado...<a href="contactos.php">Nuevo</a></h3></center>
</body>
</html>

