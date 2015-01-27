<?php

/**
 * Componente de librería con funciones para
 * acceso a datos de base de datos mysql
 */
/**
 * =====================================================
 *          Funciones para acceso a mysql
 * =====================================================
 */

/**
 * Función de base de datos 
 * para establecer una conexión con servidor MySQL 
 */
function bd_conectar() {
	// paso 1.0
	$enlace = mysqli_connect(SERVIDOR_BD ,USUARIO_BD,CONTRASENA_BD);
	// paso 1.1
	if($enlace == false)
	{
            if(MODO_DESARROLLO)
                {echo "Error conectando con el servidor de base de datos: " . SERVIDOR_BD;}
            else
                {echo "Error conectando con el servidor de base de datos.";}
            exit(1);
	}
	//paso 2.0
	$res_seleccion = mysqli_select_db($enlace, NOMBRE_BD);
	// paso 2.1
	if($res_seleccion==false)
	{
            if(MODO_DESARROLLO)
                {echo "Error seleccionando base de datos: " . NOMBRE_BD;
		 echo "<br />";
		 echo mysqli_errno($enlace) . ": " . mysqli_error($enlace);}
            else { echo "Error seleccionando base de datos.";}
		exit(1);
	}
    // retornar enlace para ser utilizado
    return $enlace;
}

// FIN función de base de datos mysql bd_conectar

/**
 * Función de base de datos 
 * para ejecutar una consulta SQL en el servidor de MySQL 
 */
function bd_ejecutar_sql($sql) {
    $enlace = bd_conectar();

    // paso 3
    $resultado = mysqli_query($enlace, $sql);

    // paso 3.1
    if ($resultado == false) {

        if (MODO_DESARROLLO) {
            echo "Error ejecutando consulta: " . $sql;
            echo "<br />";
            echo mysqli_errno($enlace) . ": " . mysqli_error($enlace);
        } else {
            echo "Error ejecutando consulta";
        }

        exit(1);
    }

    return $resultado;
}

// FIN función de base de datos mysql bd_ejecutar_sql

/**
 * Función de base de datos 
 * para obtener la primera fila de una consulta 
 */
function bd_obtener_fila($resultado) {
    return mysqli_fetch_array($resultado, MYSQLI_BOTH);
}

// FIN función de base de datos mysql bd_obtener_fila

/**
 * Función de base de datos 
 * para obtener arreglo de valores que representa
 * la primera fila
 * resultante de una consulta SQL
 */
function bd_obtener_primera_fila($sql) {
    $resultado = bd_ejecutar_sql($sql);

    return bd_obtener_fila($resultado);
}

// FIN función de base de datos mysql bd_obtener_primera_fila

/**
 * Función de base de datos
 * para obtener el valor de la primera columna
 * de la primera fila
 * resultante de una consulta SQL
 */
function bd_obtener_valor($sql) {
    $resultado = bd_obtener_primera_fila($sql);
    return $resultado[0];
}

// FIN función de base de datos mysql bd_obtener_valor

/**
 * Función de base de datos
 * para obtener un único registro
 * a partir de id (llave) de una tabla
 */
function bd_obtener_registro($tabla, $nombre_llave, $id) {
    $id = strval(intval($id));

    $sql = "SELECT * FROM $tabla WHERE $nombre_llave = '$id'";
//debug($sql);
    return bd_obtener_primera_fila($sql);
}

// FIN función de base de datos mysql bd_obtener_registro

/**
 * Función de base de datos
 * para insertar de forma genérica
 * un registro en una tabla
 * en la base de datos
 */
function bd_insertar_registro($tabla, $campos, &$valores, $no_escapar = array()) {
    $conexion = bd_conectar();

    $arr_valores = array();

    foreach ($campos as $campo) {
        $tmp = "";
        if (isset($valores[$campo])) {$tmp = $valores[$campo];}
        if (empty($tmp)) {$tmp = "NULL";
        } else {
            if (!in_array($campo, $no_escapar)) {
                $tmp1 = mysql_real_escape_string($tmp, $conexion);
                $tmp = "'$tmp1'";
            }
        }
        $arr_valores[] = $tmp;
    }

    $lista_campos = implode(",", $campos);
    $lista_valores = implode(",", $arr_valores);

    $sql = "INSERT INTO $tabla ( $lista_campos ) VALUES ($lista_valores)";

    bd_ejecutar_sql($sql);
}

// FIN función de base de datos mysql bd_insertar_registro

/**
 * Función de base de datos
 * para actualizar de forma genérica
 * un registro de una tabla
 * de la base de datos
 */
function bd_actualizar_registro($tabla, $campos, &$valores, $campoid, $id) {
//    $conexion = bd_conectar();

    $lista_actualizacion = array();

    foreach ($campos as $campo) {
        $tmp = "";

        if (isset($valores[$campo])) {
            $tmp = $valores[$campo];
        }

        if (empty($tmp)) {
            $tmp = "NULL";
        } else {
            $tmp1 = mysqli_real_escape_string($tmp);
            $tmp = "'$tmp1'";
        }

        $lista_actualizacion[] = "$campo = $tmp ";
    }

    $sql = "UPDATE $tabla SET ";
    $sql .= implode(",", $lista_actualizacion);
    $sql .= sprintf(" WHERE %s = '%s' LIMIT 1", $campoid, mysqli_real_escape_string($id));

    bd_ejecutar_sql($sql);
}

// FIN función de base de datos mysql bd_actualizar_registro

/**
 * Función de base de datos
 * para borrar de forma genérica 
 * un registro de una tabla en la 
 * base de datos
 */
function bd_borrar_registro($tabla, $campoid, $id) {
    $id = strval(intval($id));

    $sql = "DELETE FROM $tabla WHERE $campoid = $id LIMIT 1;";

    bd_ejecutar_sql($sql);
}

// FIN función de base de datos mysql bd_borrar_registro

/**
 * Función de base de datos
 * para obtener un único registro
 * filtrado por un campo distinto al campo llave
 */
function bd_buscar_registro($select, $tabla, $campo_filtro, $valor_filtro) {
    $conexion = bd_conectar();

    $valor_filtro = mysqli_real_escape_string($valor_filtro, $conexion);

    $sql = "SELECT $select FROM $tabla WHERE $campo_filtro = '$valor_filtro' LIMIT 1";

    return bd_obtener_primera_fila($sql);
}

// FIN función de base de datos mysql bd_borrar_registro

function bd_limpiar_cadena($cadena) {
    $conexion = bd_conectar();

    $cadena_limpia = mysqli_real_escape_string($cadena, $conexion);

    return $cadena_limpia;
}

function contar_registros($lista){
    
    $numero_registros = mysqli_num_rows($lista) ;
    
    return $numero_registros;
}