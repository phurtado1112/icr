<?php

/**
 * Función de autenticacion
 * para determinar si un usuario - contraseña
 * ya ha sido autenticado previamente
 */
function per_es_usuario_autenticado()
{
	if(!isset($_SESSION['usuario']))
	{
		return false;
	}
	
	if(!isset($_SESSION['contrasena']))
	{
		return false;
	}
	
	if(per_es_usuario_valido($_SESSION['usuario'],$_SESSION['contrasena']))
	{
		return true;
	}
	
	return false;
} // FIN función de autenticacion per_es_usuario_autenticado

/**
 * Función de autenticacion
 * para determinar si un usuario - contraseña
 * es válido
 */
function per_es_usuario_valido($usuario, $conrtasena)
{
	
	$usuario = trim($usuario);
	$conrtasena = trim($conrtasena);
	
	if(empty($conrtasena))
	{
		return false;
	}
	
	if(empty($usuario))
	{
		return false;
	}
	
	$registro_usuario = bd_buscar_registro("contrasena","usuario","usuario",$usuario);
	
	if(empty($registro_usuario))
	{
		return false;
	}
	else if($registro_usuario['contrasena'] == md5($conrtasena))
	{
		return true;
	}
	
	return false;	  
} // FIN función de autenticacion per_es_usuario_valido


?>
