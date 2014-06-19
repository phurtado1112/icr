<?php
//Proceso de conexión con la base de datos
include_once './funciones.general.php';

//Inicio de variables de sesión
if (!isset($_SESSION)) {
    session_start();    
}

//Recibir los datos ingresados en el formulario
$campania = filter_input(INPUT_POST, 'Camp');

if ($campania == '0') { //opcion1: Si el usuario NO existe o los datos son INCORRRECTOS
    echo '<script language = javascript>
	alert("Seleccione una Campaña")
	self.location = "camp.php"
	</script>';
} else { //opcion2: Usuario logueado correctamente
    //Definimos las variables de sesi�n y redirigimos a la p�gina de usuario
    $_SESSION['idcampania'] = $campania;

    $insert_sesion = "INSERT INTO session (session_id,idusuario,usuario) "
            . "VALUES("
            . "'".session_id()."',".$_SESSION['idusuario'].",'".$_SESSION['usuario']."')";
    bd_ejecutar_sql($insert_sesion);

    $insert_regcon = "INSERT INTO registroconexion (idusuario,idcampania,fechainicio,horainicio)
			VALUES(
			" . $_SESSION['idusuario'] . ",
                        " . $_SESSION['idcampania'] . ",    
			'" . date("Y-m-d") . "',
			'" . date("H:i:s") . "'
			)";
    bd_ejecutar_sql($insert_regcon);
    echo '$insert_regcon';

    $consulta_regcon = "SELECT MAX(idregcon) AS id FROM registroconexion";
    $lista_regcon = bd_ejecutar_sql($consulta_regcon);
    $filaregcon = bd_obtener_fila($lista_regcon);
    $_SESSION['idregcon'] = $filaregcon['id'];    
    
    header("Location: progres.html");
}
