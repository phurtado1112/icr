<?php
/**
 * Componente de librería con funciones genéricas para control de fechas
 */

/**
 * Función genérica
 * para determinar si una fecha es mayor que otra
 */
function gen_es_fecha_mayor($f1,$f2)
{
	$f1 = strtotime($f1);
	$f2 = strtotime($f2);
	
	if($f1>$f2)
	{
		return true;
	}
	else
	{
		return false;
	}  
} // FIN función genérica gen_es_fecha_mayor

/**
 * Función genérica
 * para imprimir en un formulario un control Web
 * para selección de fecha
 */
function gen_control_fecha($nombre, $fecha_inicial = null)
{
	$html = "";
	
	if($fecha_inicial==null)
	{
		$fecha_inicial = date("Y-m-d");
	}
	
	$fecha = date_parse($fecha_inicial);
	
	$html .= sprintf("<select name='d_%s' id='d_%s'>",$nombre,$nombre);
	$html .= gen_poblar_combo_dias($fecha["day"]);
	$html .= "</select>";

	$html .= sprintf("<select name='m_%s' id='m_%s'>",$nombre,$nombre);
	$html .= gen_poblar_combo_meses($fecha["month"]);
	$html .= "</select>";
	
	$html .= sprintf("<input name='a_%s' id='a_%s' 
							value='%s' type='text' 
							size='6' maxlength='4'>",
									$nombre, $nombre, gen_obtener_html($fecha["year"]));
									
	echo $html;
} // FIN función genérica gen_control_fecha

/**
 * Función genérica
 * para llenar el combo de dias en el
 * control Web para selección de fecha
 */
function gen_poblar_combo_dias($seleccionado = null)
{
	$html = "";

	for($i=1;$i<=31;$i++)
	{
		if($i==$seleccionado)
		{
			$html .= sprintf("<option selected value='%s'>%s</option>",$i,$i);
		}
		else
		{
			$html .= sprintf("<option value='%s'>%s</option>",$i,$i);
		}
	}
	
	return $html;
} // FIN función genérica gen_poblar_combo_dias

/**
 * Función genérica
 * para llenar el combo de meses en el
 * control Web para selección de fecha
 */
function gen_poblar_combo_meses($seleccionado = null)
{
	$meses = array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$html = "";

	foreach($meses as $numero=>$mes)
	{
		if($numero==$seleccionado)
		{
			$html .= sprintf("<option selected value='%s'>%s</option>",$numero,$mes);
		}
		else
		{
			$html .= sprintf("<option value='%s'>%s</option>",$numero,$mes);
		}
	}
	
	return $html;
} // FIN función genérica gen_poblar_combo_meses

/**
 * Función genérica
 * para juntar los datos dias, mes, año
 * de un control Web para selección de fecha
 * y verlo con un solo dato compuesto de año-mes-dia
 * en formato de base de datos
 */
function gen_recibir_fecha($nombre)
{
	$_POST[$nombre] = sprintf("%s-%s-%s",$_POST["a_".$nombre],$_POST["m_".$nombre],$_POST["d_".$nombre]);
} // FIN función genérica gen_llenar_combo


?>