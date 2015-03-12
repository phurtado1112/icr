<?php 
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_estado_campanias = "select campania, nombre, idasignar from estado_campania_view where terminada='n' order by idasignar";
$lista_camp = bd_ejecutar_sql($consulta_estado_campanias);
while ($fila_camp = bd_obtener_fila($lista_camp)) {
    $camp[] = $fila_camp;
}

function graficar($titulo, $idasignar) {
    $consulta_ctes_ctos = "select PROCENT from clientes_contactados_view WHERE idasignar =" . $idasignar;
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
        <meta charset="utf-8" />
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
                                                if(isset($camp)){
                                                    foreach ($camp as $c) {
                                                        graficar($c['campania'].' - '.$c['nombre'] , $c['idasignar']);
                                                        
                                                    }
                                                } else {
                                                    echo '<h2>Inicie cargando los Catálogos del sistema</h2>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="ac">
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
                $('.chart').easyPieChart({animate: 100});
            });
        </script>
    </body>
</html>