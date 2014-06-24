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
$contrasena = filter_input(INPUT_POST, 'pass');

//Consultar si los datos son est�n guardados en la base de datos
$consulta_usuario = "SELECT * FROM usuarios WHERE usuario='".$usuario."' AND contrasena='".$contrasena."' AND tipo='2'"; 
$lista_usuario = bd_ejecutar_sql($consulta_usuario);
$fila = bd_obtener_fila($lista_usuario);

if (!$fila[0]) //opcion1: Si el usuario NO existe o los datos son INCORRRECTOS
{
	echo '<script language = javascript>
	alert("Usuario o Contraseña errados o no tiene privilegios, por favor verifique")
	self.location = "index.php"
	</script>';
}
else //opcion2: Usuario logueado correctamente
{
	//Definimos las variables de sesión y redirigimos a la p�gina de usuario
	$_SESSION['nombre_usuario'] = $fila['nombre'];
        
        echo $_SESSION['nombre'];
        
	$_SESSION['idusuario'] = $fila['idusuario'];

	$consulta_sesion = "INSERT INTO session (session_id,idusuario,usuario)
			VALUES(
			'".session_id()."',
			'".$_SESSION['idusuario']."',			
			'".$usuario."'
			)";			
        bd_ejecutar_sql($consulta_sesion);
//mysql_query($insert);
	header("Location: main.php");
}