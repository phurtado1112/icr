<?php
include_once './funciones.general.php';

if (!isset($_SESSION)) {
    session_start();
}

//Recibir los datos ingresados en el formulario
$usuario = filter_input(INPUT_POST, 'usuario');
$contrasena = filter_input(INPUT_POST, 'contrasena');

//Consultar si los datos son estos guardados en la base de datos
$consulta = "SELECT * FROM usuarios WHERE usuario='" . $usuario . "' AND contrasena='" . $contrasena . "'";
$lista_usuarios= bd_ejecutar_sql($consulta);
$fila = bd_obtener_fila($lista_usuarios);

if (!$fila[0]) { //opcion1: Si el usuario NO existe o los datos son INCORRRECTOS
    echo '<script language = javascript>
	alert("Usuario o Password errados, por favor verifique.")
	self.location = "index.php"
	</script>';
} else { //opcion2: Usuario logueado correctamente
    //Definimos las variables de sesi�n y redirigimos a la p�gina de usuario

    $_SESSION['idusuario'] = $fila['idusuario'];
    $_SESSION['usuario'] = $fila['usuario'];

    // Se busca y elimina cualquier sesión anterior hecha por el usuario
    $consulta_sesion_anterior="select * from session where idusuario= '".$_SESSION['idusuario']."'";
    $lista_sesion_anterior = bd_ejecutar_sql($consulta_sesion_anterior);
    $fila_sesion_anterior = bd_obtener_fila($lista_sesion_anterior);
    $sesion_anterior = $fila_sesion_anterior['idusuario'];
    
    if(isset($sesion_anterior)){
        $consulta_eliminar_sesion_anterior = "delete from session where idusuario = '".$sesion_anterior."'";
        bd_ejecutar_sql($consulta_eliminar_sesion_anterior);
    }
    
    header("Location: camp.php");
    // Comentado PHD 26 Enero 2015 se decidió no dar entrada al admin
    // //    $admin = $fila['tipo'];
//    //Agregado por PHD 19 de marzo 2014
//    if ($admin == 2) {
//        header("Location: main.php");
//    } else {
//        header("Location: camp.php");
//    }
//    //Comentariado por PHD 19 de marzo 2014 sustituido por el if anterior
//    //header("Location: camp.php");
}



