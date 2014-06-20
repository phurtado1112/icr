<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_campa = "SELECT * FROM campanias where idcampania='" . $_SESSION['idcampania'] . "' ";
$lista_campa = bd_ejecutar_sql($consulta_campa);
$filacamp = bd_obtener_fila($lista_campa);
$var_camp_nombre = $filacamp['campania'];

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>INCAE | CRM</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/reveal.css" rel="stylesheet">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="#"><?php echo $var_camp_nombre; ?></a>
                    <div class="nav-collapse collapse">
                        <p class="navbar-text pull-right">
                            <a href="salir.php" class="navbar-link">Salir</a>
                        </p>
                        <ul class="nav">
                            <li><a href="noticias.php">Noticias</a></li>
                            <li><a href="cambio_estado.php">Estado</a></li>
                            <li class="active"><a href="cliente_nuevo.php">Nuevo Contacto</a></li>
                            <li><a href="contactos.php">Contactos</a></li>
                            <li><a href="cliente_atendido.php">Atendidos</a></li>                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list nav-collapse collapse">
                    </ul>                    
                </div>
            </div>
            <div class="block center login small">
                <div class="block_head">
                    <div class="bheadl"></div>
                    <div class="bheadr"></div>
                    <h2>Agregar Nuevo Contacto</h2>
                </div>
                <div class="block_content" align="center">
                    <form method="POST" action="cliente_nuevo_procesar.php" name="formnewclient">                         
                        <input type="text" name="Nombre" id="nombreCompleto" placeholder="Nombres y Apellidos">
                        <input type="text" name="Telefono" id="telefono" placeholder="Teléfono" >
                        <input type="text" name="Correo" id="mail" placeholder="Email">
                        <input type="text" name="Celular" id="celular" placeholder="Celular">
                        <input type="text" name="TelTrabajo" id="telTrabajo" placeholder="Teléfono Oficina">
                        <input type="text" name="Cargo" id="cargo" placeholder="Cargo">
                        <input type="text" name="Empresa" id="empresa" placeholder="Empresa">
                        <select name="finales" id="finales" >
                            <option value="0">Prioridad Baja</option>
                            <option value="1">Prioridad Media</option>
                            <option value="2">Prioridad Alta</option>
                        </select>
                        <div>
                            <div align="center">
                                <input type="button" class="btn btn-success" value="Guardar" onclick="Enviar()">
                            </div>                   
                        </div>
                    </form>
                    <div class="bendl"></div>
                    <div class="bendr"></div>
                </div>
            </div>
        </div>
        <div class="ac">
            <?php include ("pie.php"); ?>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/obj_ajax.js"></script>
        <script src="js/jquery.reveal.js"></script>

        <script type="text/javascript">
            //VALIDACION PARA FORMULARIO DE NUEVO CONTACTO
            function Enviar() {
                if (document.getElementById('nombreCompleto').value === '') {
                    alert('Datos Incompletos');
                } else {
                    if (document.getElementById('mail').value === '') {
                        alert('Datos Incompletos');
                    } else {
                        document.formnewclient.submit();
                    }
                }
            }
        </script>
    </body>
</html>
