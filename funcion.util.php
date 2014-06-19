<?php
function obtener_respuesta($idpregunta, $idboleta)
{
	$sql = sprintf( "SELECT respuesta, idrespuesta_cerrada FROM respuesta_view WHERE idpregunta = %d and idboleta = %d", $idpregunta, $idboleta);
	
	$respuesta = bd_obtener_primera_fila($sql);
	if (empty($respuesta)) {
        return NULL;
    }
    if (empty($respuesta["respuesta"])) {
        return $respuesta["idrespuesta_cerrada"];
    }

    return $respuesta["respuesta"];
}

