<?php

define("PERMISO_CREAR","C");
define("PERMISO_LEER","R");
define("PERMISO_ACTUALIZAR","U");
define("PERMISO_BORRAR","D");

/**
 * Función de autenticacion
 * para determinar si un usuario - contraseña
 * ya ha sido autenticado previamente
 */
function per_es_permitido($permiso, $tipo)
{
	if(!per_es_usuario_autenticado())
	{
		return false;
	}
	
	$usuario = bd_limpiar_cadena($_SESSION['usuario']);
	$permiso = bd_limpiar_cadena($permiso);
	$tipo = bd_limpiar_cadena($tipo);
	
	$sql = sprintf("SELECT count(*) 
					FROM vw_usuarios_permisos 
					WHERE usuario = '%s' AND nombre = '%s' AND tipo = UPPER('%s')",
					$usuario,
					$permiso,
					$tipo
				);
	
	$contador = bd_obtener_valor($sql);
	
	// asegurar que sea un numero
	$contador = strval(intval($contador));
	
	if($contador>0)
	{
		return true;
	}
	else
	{
		return 	false;
	}
}

?>