<!DOCTYPE html>
<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_estados = "SELECT * FROM estados";
$lista_estados = bd_ejecutar_sql($consulta_estados);

$consulta_campa = "SELECT * FROM campanias where idcampania='" . $_SESSION['idcampania'] . "' ";
$lista_campa = bd_ejecutar_sql($consulta_campa);
$filacamp = bd_obtener_fila($lista_campa);
$var_camp_nombre = $filacamp['campania'];

$consulta_asesor = "SELECT nombre FROM usuarios WHERE idusuario='" . $_SESSION['idusuario'] . "'";
$lista_asesor = bd_ejecutar_sql($consulta_asesor);
$fila_asesor = bd_obtener_fila($lista_asesor);
$nombre_asesor = $fila_asesor['nombre'];
?>   
<html lang="en">
    <head>
        <meta charset="UTF-8">        
        <title>INCAE | CRM</title>

        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
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
                        <ul class="nav">
                            <li><a href="noticias.php">Noticias</a></li>
                            <li class="active"><a href="cambio_estado.php">Estado</a></li>
                            <li><a href="contacto_nuevo_agregar.php">Nuevo Contacto</a></li>
                            <li><a href="contacto_agendado.php">Agendados</a></li>
                            <li><a href="contacto_nuevo.php">Contactos</a></li>
                            <li><a href="contacto_atendido.php">Atendidos</a></li>
                            <li><a></a></li>
                            <li><a></a></li>
                            <li><a></a></li>
                            <li><a></a></li>
                            <li><a></a></li>
                            <li><a></a></li>
                            <li><a></a></li>
                            <li><a></a></li>
                            <li><a></a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong><?php echo $nombre_asesor; ?></strong><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="salir.php">Salir</a></li>
                                </ul>
                            </li>
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
                    <center><h2>Cambio de Estado</h2></center> 
                </div>
                <div>
                    <div class="block_content" align="center">
                        <form>
                            <select onChange="estado()" id="idestados">            
                                <option value="0">-------</option>
                                <?php
                                    while ($filaestado = bd_obtener_fila($lista_estados)) {
                                ?>
                                    <option  value="<?php echo $filaestado['idestado']; ?>"><?php echo ($filaestado['estado']); ?></option>
                                <?php } ?>
                            </select>
                        </form>

                        <p>&nbsp; </p>
                        <div id="divhora" align="center"></div>             
                        <p>&nbsp; </p>

                        <div id="divbtn" align="center" style="display:none">
                            <input type="button" class="btn btn-primary btn-large" value="desbloquear" onClick="saveajx()">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ac">
            <?php include ("pie.php"); ?>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/obj_ajax.js"></script>
        <script type="text/javascript" src="js/cronos.js"></script>  
    </body>
</html>
