<?php

/**
 * Componente de librería con funciones genéricas 
 */
// iniciar sesion de usuario
session_start();

// incluir archivo que contiene la configuracion
include_once("config.php");

// si el sitio esta configurado en modo de desarrollo
// entonces configurar php para que muestre todos los
// errores al programador
// si el sitio se pone en produccion, se recomienda
// NO mostrar ningún error
if (MODO_DESARROLLO) {
    ini_set('display_errors', 1); // Mostrar TODOS los errores
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0); // NO mostrar los errores
    error_reporting(0);
}

// seleccionar el tipo de base de datos a usar
if (TIPO_BD == 'mysql') {
    // incluir componente de funciones de base de datos para mysql
    include_once("funciones.mysql.php");
}

// incluir componente de funciones para manejar fechas
include_once("funciones.fecha.php");

// incluir componente de funciones para manejar autenticación
//include_once("funciones.autenticacion.php");
// incluir componente de funciones para manejar autorización
//include_once("funciones.autorizacion.php");

/**
 * =====================================================
 *          Funciones genéricas de la aplicación
 * =====================================================
 */

/**
 * Función genérica 
 * para formatear un texto de 
 * forma segura en una página web
 */
function gen_obtener_html($texto) {
    return htmlentities($texto, ENT_QUOTES, 'utf-8');
}

// FIN función genérica gen_obtener_html

/**
 * Función genérica
 * para imprimir un texto de 
 * forma segura en una página web
 */
function gen_imprimir_html($texto) {
    echo gen_obtener_html($texto);
}

// FIN función genérica gen_imprimir_html

/**
 * Función genérica
 * para obtener un parámetro Web
 * de forma segura
 * validando si de verdad existe
 */
function gen_obtener_parametro_web(&$arreglo, $nombre, $predefinido = null) {
    $retornar = null;

    // verificar si el parámetro existe
    if (!isset($arreglo[$nombre])) {
        return $predefinido;
    }

    // Si se espera un número, se debe
    // filtrar antes de aceptarlo
    if ($predefinido === 0) {
        // si se espera un número entero
        // convertir parámetro en un número entero
        $retornar = strval(intval($arreglo[$nombre]));
    } else {
        // si se espera una cadena de texto
        // quitar los espacios vacíos a la cadena
        $retornar = trim($arreglo[$nombre]);
    }

    // retorna parámetro ya limpio
    return ($retornar);
}

// FIN función genérica gen_obtener_parametro_web

/**
 * Función genérica
 * para llena un combo HTML 
 * en base a una consulta a la base de datos
 */
function gen_llenar_combo($tabla, $campo_valor, $campo_opcion, $seleccionado = null, $filtro = null) {
    $sql = "SELECT $campo_valor,$campo_opcion FROM $tabla ";
    if (!empty($filtro)) {
        $sql = $sql . " where " . $filtro;
    }
    $resultado = bd_ejecutar_sql($sql);

    while ($fila = bd_obtener_fila($resultado)) {
        if ($seleccionado == $fila[0]) {
            $html = sprintf("<option selected value='%s'>%s</option>", gen_obtener_html($fila[0]), gen_obtener_html($fila[1])
            );
            echo $html;
        } else {
            $html = sprintf("<option value='%s'>%s</option>", gen_obtener_html($fila[0]), gen_obtener_html($fila[1])
            );
            echo $html;
        }
    }
}

// FIN función genérica gen_llenar_combo

/**
 * Función genérica
 * para llena un combo HTML 
 * en base a un arreglo de php
 */
function gen_llenar_combo_arreglo($arreglo, $seleccionado = null) {
    foreach ($arreglo as $k => $v) {
        if ($seleccionado == $k) {
            $html = sprintf(
                    "<option selected value='%s'>%s</option>", gen_obtener_html($k), gen_obtener_html($v)
            );
            echo $html;
        } else {
            $html = sprintf(
                    "<option value='%s'>%s</option>", gen_obtener_html($k), gen_obtener_html($v)
            );
            echo $html;
        }
    }
}

// FIN función genérica gen_llenar_combo_arreglo

/**
 * Función genérica
 * para guardar en la sesion el estado actual
 * de un formulario Web y los mensajes de error
 * para que al mostrar de nuevo el formulario Web
 * todos los campos recuperen su estado original
 */
function gen_guardar_registro_errado_en_sesion($mensajes, $campos, $campoid = null) {
    unset($_SESSION['mensajes']);
    unset($_SESSION['registro_errado']);

    $_SESSION['mensajes'] = $mensajes;
    $_SESSION['registro_errado'] = array();

    foreach ($campos as $campo) {
        $_SESSION['registro_errado'][$campo] = $_POST[$campo];
    }

    if (!empty($campoid)) {
        $_SESSION['registro_errado'][$campoid] = $_POST["id"];
    }
}

// FIN función genérica gen_recibir_fecha

/**
 * Función genérica
 * para obtener el estado almacenado en sesion
 * de un formulario Web
 */
function gen_obtener_registro_errado_en_sesion() {
    if (isset($_SESSION['registro_errado'])) {
        $registro = $_SESSION['registro_errado'];
    } else {
        $registro = false;
    }

    unset($_SESSION['registro_errado']);

    return $registro;
}

// FIN función genérica gen_obtener_registro_errado_en_sesion

/**
 * Función genérica
 * para obtener los mensajes de error almacenados en sesion
 * de un formulario Web
 */
function gen_obtener_mensajes_registro_errado_en_sesion() {
    if (isset($_SESSION['mensajes'])) {
        $mensajes = $_SESSION['mensajes'];
    } else {
        $mensajes = false;
    }

    unset($_SESSION['mensajes']);

    return $mensajes;
}

// FIN función genérica gen_obtener_mensajes_registro_errado_en_sesion

/**
 * Función genérica
 * para mostrar los errores encontrados
 * en un formualario web
 */
function gen_imprimir_mensajes_error() {
    $mensajes = gen_obtener_mensajes_registro_errado_en_sesion();

    if ($mensajes) {
        echo "<ul id='mensajes_error'>";
        foreach ($mensajes as $mensaje) {
            echo "<li>";
            gen_imprimir_html($mensaje);
            echo "</li>";
        }
        echo "</ul>";
    }
}

// FIN función genérica gen_imprimir_mensajes_error

/**
 * Función genérica
 * para redireccionar al usuario hacia
 * una determinada URL
 */
function gen_ir_a($url) {
    header("Location: $url");
    exit(0);
}

// FIN función genérica gen_ir_a

/**
 * Función genérica
 * para ver el contenido de una variable 
 * y terminar la ejecución
 */
function debug($var, $seguir = false) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    if (!$seguir){
        die();
    }
}

// FIN función genérica debug

include_once("funcion.util.php");
