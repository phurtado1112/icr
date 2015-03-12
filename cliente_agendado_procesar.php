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
    $consulta_idpais = "SELECT idpais from clientes where idcliente='" . $cte . "'";
    $lista_pais = bd_ejecutar_sql($consulta_idpais);
    $fila_idpais = bd_obtener_fila($lista_pais);
    $idpais = $fila_idpais['idpais'];

    $consulta_agregar_transaccion = "INSERT INTO transaccion (idcliente,idusuario, 
            idtipificacion,idsubtipificacion,fecha,hora,observaciones,idcampania,
            idpais,idasignar)
			VALUES(
                            '" . $cte . "',
                            '" . $usua . "',
                            '" . $fin . "',
                            '" . $sub . "',
                            '" . date("Y-m-d") . "',
                            '" . date('H:i:s') . "',
                            '" . $obs . "',
                            '" . $_SESSION['idcampania'] . "',
                            '" . $idpais . "',
                            '" . $_SESSION['idasignar'] . "'
			)";
    bd_ejecutar_sql($consulta_agregar_transaccion);

    $consulta_idtransaccion = "select max(idtrasaccion) as idtransaccion from transaccion where idcliente = '" . $cte . "'";
    $lista_idtransaccion = bd_ejecutar_sql($consulta_idtransaccion);
    $fila_idtransaccion = bd_obtener_fila($lista_idtransaccion);
    $idtransaccion = $fila_idtransaccion['idtransaccion'];

    if ($fin <> 5) {

        $consulta_actualizacion_clientes = "update clientes set idestado=1, "
                . "agendado=0 where idcliente='" . $cte . "'";
        bd_ejecutar_sql($consulta_actualizacion_clientes);

        $consulta_actualizacion_agenda = "update agenda SET gestionado=1 WHERE idcliente='" . $cte . "'";
        bd_ejecutar_sql($consulta_actualizacion_agenda);
    } else {
        $consulta_agendado_recurrente = "INSERT INTO agenda (idcliente, idtransaccion,"
                . "fecha,observacion,gestionado) VALUES($cte,$idtransaccion,'$age','$obs',0)";
        bd_ejecutar_sql($consulta_agendado_recurrente);

        $consulta_existe_otro_cliente_agendado = "select count(*) idtrasaccion from agenda where idcliente=' " . $cte . "'";
        $lista_cantidad_cliente_agendado = bd_ejecutar_sql($consulta_existe_otro_cliente_agendado);
        $fila_cantidad_cliente_agendado = bd_obtener_fila($lista_cantidad_cliente_agendado);
        $cantidad_cliente_agendado = $fila_cantidad_cliente_agendado['idtrasaccion'];
        
        if ($cantidad_cliente_agendado > 1) {
            $consulta_cliente_anterior = "select idtransaccion from agenda where idcliente=' " . $cte . "'";
            $lista_transaccion_anterior = bd_ejecutar_sql($consulta_cliente_anterior);
            while ($fila_transaccion_anterior = bd_obtener_fila($lista_transaccion_anterior)) {
                $repetido[] = $fila_transaccion_anterior;
            }
            
            switch ($cantidad_cliente_agendado) {
                case 2:
                    $transaccion_anterior = $repetido[0];
                    break;
                case 3:
                    $transaccion_anterior = $repetido[1];
                    break;
                case 4:
                    $transaccion_anterior = $repetido[2];
                    break;
                case 5:
                    $transaccion_anterior = $repetido[3];
                    break;
                case 6:
                    $transaccion_anterior = $repetido[4];
                    break;
                case 7:
                    $transaccion_anterior = $repetido[5];
                    break;
                case 8:
                    $transaccion_anterior = $repetido[6];
                    break;
                case 9:
                    $transaccion_anterior = $repetido[7];
                    break;
                case 10:
                    $transaccion_anterior = $repetido[8];
                    break;
            }
            
            $consulta_actualiza_ultimo = "UPDATE agenda SET gestionado = '1' WHERE idtransaccion = '"
                    . $transaccion_anterior['idtransaccion'] . "'";
            bd_ejecutar_sql($consulta_actualiza_ultimo);          
        }
    }

    $consulta_actualiza_cliente_transaccion = "update cliente_transaccion set idtransaccion = '" . $idtransaccion . "' where idcliente = '" . $cte . "'";
    bd_ejecutar_sql($consulta_actualiza_cliente_transaccion);

    $consulta_existe_otro_cliente = "select count(*) idtrasaccion from transaccion where idcliente=' " . $cte . "'";
    $lista_cantidad_cliente = bd_ejecutar_sql($consulta_existe_otro_cliente);
    $fila_cantidad_cliente = bd_obtener_fila($lista_cantidad_cliente);
    $cantidad_cliente = $fila_cantidad_cliente['idtrasaccion'];

    if ($cantidad_cliente > 1) {
        $consulta_cliente_anterior = "select idtrasaccion as idtransaccion from transaccion where idcliente=' " . $cte . "'";
        $lista_transaccion_anterior = bd_ejecutar_sql($consulta_cliente_anterior);
        while ($fila_transaccion_anterior = bd_obtener_fila($lista_transaccion_anterior)) {
            $repetido[] = $fila_transaccion_anterior;
        }

        switch ($cantidad_cliente) {
            case 2:
                $transaccion_anterior = $repetido[0];
                break;
            case 3:
                $transaccion_anterior = $repetido[1];
                break;
            case 4:
                $transaccion_anterior = $repetido[2];
                break;
            case 5:
                $transaccion_anterior = $repetido[3];
                break;
            case 6:
                $transaccion_anterior = $repetido[4];
                break;
            case 7:
                $transaccion_anterior = $repetido[5];
                break;
            case 8:
                $transaccion_anterior = $repetido[6];
                break;
            case 9:
                $transaccion_anterior = $repetido[7];
                break;
            case 10:
                $transaccion_anterior = $repetido[8];
                break;
        }

        $consulta_actualiza_ultimo = "UPDATE transaccion SET ultimo = '0' WHERE idtrasaccion = '"
                . $transaccion_anterior['idtransaccion'] . "'";
        bd_ejecutar_sql($consulta_actualiza_ultimo);
    }

    header("Location: cliente_contacto_agendado.php");
}    