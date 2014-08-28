<?php //
include_once './funciones.general.php';
//session_start();
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_estado_campanias = "select * from estado_campania_view where terminada='n'";
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
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="Admin/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">        
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <div>
            <?php 
            include './menu_superior.php';
            ?>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Avance de contacto de campañas</div>
                                </div>
                                <div class="block-content collapse in" align="center">
                                    <table >
                                        <tr>
                                            <td>
                                                <?php
                                                    foreach ($camp as $c) {
                                                        graficar($c['campania'], $c['idcampania']);
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
        <hr>
        <div>
            <?php 
            include './pie.php';
            ?>
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