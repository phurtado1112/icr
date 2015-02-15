<?php

include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

$cte = filter_input(INPUT_POST, 'ajxcliente');
$usua = filter_input(INPUT_POST, 'ajxuser');
$fin = filter_input(INPUT_POST, 'ajxfinales');
$sub = filter_input(INPUT_POST, 'ajxsubfinal');
$obs = filter_input(INPUT_POST, 'ajxobservacion');
$age = filter_input(INPUT_POST, 'ajxagendar');

if (isset($cte)) {

    $consulta_actualizacion_clientes = "update clientes set idestado=1, agendado=0 where idcliente='" . $cte . "'";
    bd_ejecutar_sql($consulta_actualizacion_clientes);

    $consulta_actualizacion_agenda = "update agenda SET gestionado=1 WHERE idcliente='" . $cte . "'";
    bd_ejecutar_sql($consulta_actualizacion_agenda);

    $consulta_agregar_transaccion = "INSERT INTO transaccion (idcliente,idusuario,idtipificacion,idsubtipificacion,fecha,hora,observaciones,idcampania,idasignar)
			VALUES(
                            '" . $cte . "',
                            '" . $usua . "',
                            '" . $fin . "',
                            '" . $sub . "',
                            '" . date("Y-m-d") . "',
                            '" . date('H:i:s') . "',
                            '" . $obs . "',
                            '" . $_SESSION['idcampania'] . "',
                            '" . $_SESSION['idasignar'] . "'
			)";
    bd_ejecutar_sql($consulta_agregar_transaccion);

    $consulta_idtransaccion = "select max(idtrasaccion) as idtransaccion from transaccion where idcliente = '" . $cte . "'";
    $lista_idtransaccion = bd_ejecutar_sql($consulta_idtransaccion);
    $fila_idtransaccion = bd_obtener_fila($lista_idtransaccion);
    $idtransaccion = $fila_idtransaccion['idtransaccion'];

    $consulta_actualiza_cliente_transaccion = "update cliente_transaccion set idtransaccion = '" . $idtransaccion . "' where idcliente = '" . $cte . "'";
    bd_ejecutar_sql($consulta_actualiza_cliente_transaccion);


    if ($age == '0000-00-00') {
        
    } else {
        $consulta_agregar_agenda = "INSERT INTO agenda (idcliente,fecha,observacion)
				VALUES(
				'" . $cte . "',			
				'" . $age . "',
                                '" . $obs . "'
				)";
        bd_ejecutar_sql($consulta_agregar_agenda);
    }
}

$consulta_existe_otro_cliente = "select count(*) idtrasaccion from transaccion where idcliente=' " . $cte . "'";
$lista_cantidad_cliente = bd_ejecutar_sql($consulta_existe_otro_cliente);
$fila_cantidad_cliente = bd_obtener_fila($lista_cantidad_cliente);
$cantidad_cliente = $fila_cantidad_cliente['idtrasaccion'];

if ($cantidad_cliente > 1) {
    $consulta_cliente_anterior = "select min(idtrasaccion) as idtransaccion from transaccion where idcliente=' " . $cte . "' limit 1";
    $lista_transaccion_anterior = bd_ejecutar_sql($consulta_cliente_anterior);
    $fila_transaccion_anterior = bd_obtener_fila($lista_transaccion_anterior);
    $transaccion_anterior = $fila_transaccion_anterior['idtransaccion'];

    $consulta_actualiza_ultimo = "UPDATE transaccion SET ultimo = '0' WHERE idtrasaccion = '" . $transaccion_anterior . "'";
    bd_ejecutar_sql($consulta_actualiza_ultimo);
}

header("Location: cliente_contacto_agendado.php");


