<?php
include_once './funciones.general.php';
//session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_estado_campanias = "select * from estado_campania_view";
$lista_camp = bd_ejecutar_sql($consulta_estado_campanias);
while ($fila_camp = bd_obtener_fila($lista_camp)) {
    $camp[] = $fila_camp;
}
//function graficar($titulo, $porcent, $idcampania) {
function graficar($titulo, $idcampania) {
    $consulta_ctes_ctos = " select * from clientes_contactados_view WHERE idcampania =" . $idcampania;
    $lista_ctes_ctos = bd_ejecutar_sql($consulta_ctes_ctos);
    $fila_ctes_ctos = bd_obtener_fila($lista_ctes_ctos);

    echo "
        <div class='span3'>
            <div class='chart' data-percent='" . $fila_ctes_ctos['PROCENT'] . "'>" . $fila_ctes_ctos['PROCENT'] . "%</div>
		<div class='chart-bottom-heading'><span class='label label-info'>" . $titulo . "</span>
                </div>
            </div>
        </div>
        ";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Admin Inicio</title>
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="Admin/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">        
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="main.php">Panel de Administración</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i><?php echo $_SESSION['nombre_usuario'] ?><i class="caret"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="salir.php">Salir</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <li class="active">
                                <a href="main.php">Inicio</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Contenido <b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="noticias.php">Noticia</a>
                                    </li>
                                    <li>
                                        <a href="new_usuaro.php">Nuevo Agente</a>
                                    </li>                                    
                                </ul>
                            </li>                            
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Consultas <b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu2">
                                    <li>
                                        <a href="campania.php">Campaña</a>
                                    </li>
                                    <li>
                                        <a href="estados.php">Conectados</a>
                                    </li>
                                    <li>
                                        <a href="reporte_estados.php">Por estados</a>
                                    </li>
                                    <li>
                                        <a href="reporte_usuarios.php">Usuarios</a>
                                    </li>                                    
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Reportes <b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu3">
                                    <li>
                                        <a href="gestionxprograma.php">Gestión por Programa</a>
                                    </li>
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
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li class="active">
                            <a href="main.php">Inicio</a>
                        </li>
                        <li>
                            <a href="campania.php">Compaña</a>
                        </li>
                        <li >
                            <a href="estados.php">Conectados</a>
                        </li>
                        <li>
                            <a href="reporte_usuarios.php">Usuarios</a>
                        </li>
                    </ul>
                </div>
                <div class="span9" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Estadisticas</div>
                                </div>
                                <div class="block-content collapse in" align="center">
                                    <table >
                                        <tr>
                                            <td>
                                                <?php
                                                    foreach ($camp as $c) {
                                                        graficar($c['campania'], '25', $c['idcampania']);
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="block">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left">Usuarios conectados</div>
                                    </div>
                                    <div class="block-content collapse in">
                                        <?php include 'useronline.php' ?>	
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="block">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left">Tipificaciones</div>
                                        <div class="pull-right"></div>                                   
                                    </div>
                                    <div class="block-content collapse in">
                                        <?php include 'finales_encaliente.php' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="Admin/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="Admin/assets/scripts.js"></script>
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script>
            $(function() {
                // Easy pie charts
                $('.chart').easyPieChart({animate: 1000});
            });
        </script>
    </body>
</html>