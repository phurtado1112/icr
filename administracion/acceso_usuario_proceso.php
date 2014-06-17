<?php 
////Proceso de conexi�n con la base de datos
//$conex = mysql_connect("localhost", "root", "1a2b3c")
//		or die("No se pudo realizar la conexion");
//	mysql_select_db("incae",$conex)
//		or die("ERROR con la base de datos");
//
////Inicio de variables de sesi�n
//if (!isset($_SESSION)) {
//  session_start();
//}
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}
//error_reporting(0);

//Recibir los datos ingresados en el formulario
$usuario = filter_input(INPUT_POST, 'usuario');
$contrasena = filter_input(INPUT_POST, 'pass');
//$usuario= $_POST['Usuario'];
//$contrasena= $_POST['pass'];

//Consultar si los datos son est�n guardados en la base de datos
$consulta_usuario = "SELECT * FROM usuarios WHERE usuario='".$usuario."' AND contrasena='".$contrasena."' AND tipo='2'"; 
$lista_usuario = bd_ejecutar_sql($consulta_usuario);
$fila = bd_obtener_fila($lista_usuario);
 
//$resultado= mysql_query($consulta,$conex) or die (mysql_error());
//$fila=mysql_fetch_array($resultado);

if (!$fila[0]) //opcion1: Si el usuario NO existe o los datos son INCORRRECTOS
{
	echo '<script language = javascript>
	alert("Usuario o Password errados, por favor verifique O Notiene Privilegios de Administrador")
	self.location = "index.php"
	</script>';
}
else //opcion2: Usuario logueado correctamente
{
	//Definimos las variables de sesión y redirigimos a la p�gina de usuario
	$_SESSION['nombre'] = $fila['nombre'];
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