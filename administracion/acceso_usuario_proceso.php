<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}

//Recibir los datos ingresados en el formulario
$usuario = filter_input(INPUT_POST, 'usuario');
$contrase = filter_input(INPUT_POST, 'pass');
$contrasena = md5($contrase);

//Consultar si los datos son est�n guardados en la base de datos
$consulta_usuario = "SELECT * FROM usuarios WHERE usuario='" . $usuario . "' AND contrasena='" . $contrasena . "' AND tipo='2'";
$lista_usuario = bd_ejecutar_sql($consulta_usuario);
$fila = bd_obtener_fila($lista_usuario);

if (!$fila[0]) { //opcion1: Si el usuario NO existe o los datos son INCORRRECTOS
    echo '<script language = "javascript">
          alert("Usuario o Contraseña errados o no tiene privilegios");
          </script>';
    header("Location: index.php");
} else { //opcion2: Usuario logueado correctamente
    //Definimos las variables de sesión y redirigimos a la p�gina de usuario
    $_SESSION['nombre_usuario'] = $fila['nombre'];
    $_SESSION['idusuario'] = $fila['idusuario'];

    // Se busca y elimina cualquier sesión anterior hecha por el usuario
    $consulta_sesion_anterior = "select * from session where idusuario= '" . $_SESSION['idusuario'] . "'";
    $lista_sesion_anterior = bd_ejecutar_sql($consulta_sesion_anterior);
    $fila_sesion_anterior = bd_obtener_fila($lista_sesion_anterior);
    $sesion_anterior = $fila_sesion_anterior['idusuario'];

    if (isset($sesion_anterior)) {
        $consulta_eliminar_sesion_anterior = "delete from session where idusuario = '" . $sesion_anterior . "'";
        bd_ejecutar_sql($consulta_eliminar_sesion_anterior);
    }

    $consulta_sesion = "INSERT INTO session (session_id,idusuario,usuario)
			VALUES(
			'" . session_id() . "',
			'" . $_SESSION['idusuario'] . "',			
			'" . $usuario . "'
			)";
    bd_ejecutar_sql($consulta_sesion);

    $insert_regcon = "INSERT INTO registroconexion (idusuario,idcampania,fechainicio,horainicio)
			VALUES(
			" . $_SESSION['idusuario'] . ",
                        " . 1 . ",    
			'" . date("Y-m-d") . "',
			'" . date("H:i:s") . "'
			)";
    bd_ejecutar_sql($insert_regcon);

    $consulta_regcon = "SELECT MAX(idregcon) AS id FROM registroconexion";
    $lista_regcon = bd_ejecutar_sql($consulta_regcon);
    $filaregcon = bd_obtener_fila($lista_regcon);
    $_SESSION['idregcon'] = $filaregcon['id'];

    header("Location: main.php");
}