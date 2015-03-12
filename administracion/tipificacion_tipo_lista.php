<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_tipificaciontipo = "SELECT tipificaciontipo, idtipificaciontipo FROM tipificaciontipo where activo=0";
$lista_tipificaciontipo = bd_ejecutar_sql($consulta_tipificaciontipo);
while ($fila_tipificaciontipo = bd_obtener_fila($lista_tipificaciontipo)) {
    $tipificaciontipo[] = $fila_tipificaciontipo;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Tipo Tipificación</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <!--<link href="Admin/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">-->
        <!--<link href="Admin/assets/styles.css" rel="stylesheet" media="screen">-->
        <!--<script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
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
                <div class="span12 well" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left" align="center"></div>
                                    <a href="tipificacion_tipo_crear.php" class="btn btn-small btn-success">Nuevo Tipo de Tipificación</a>
                                    <a href="tipificacion_tipo_inactivo.php" class="btn btn-small btn-success">Tipos Tipificación Inactivos</a>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($tipificaciontipo)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tipo Tipificación</th>
                                                <th>Acción</th>       
                                            </tr>
                                            <?php
                                            $i = 1;
                                            foreach ($tipificaciontipo as $tt) {
                                                $ids = $tt['idtipificaciontipo'];
                                                echo"
                                                    <tr>
                                                    <td><b>" . $i . "</b></td>
                                                    <td>" . $tt['tipificaciontipo'] . "</td>
                                                    <td>" . '<a href="tipificacion_tipo_editar.php?idtipificaciontipo=' . $ids . '">Editar'
                                                        . '</a> ---  <a href="tipificacion_tipo_inactivar.php?idtipificaciontipo=' . $ids . '">Inactivar</a>' . "</td>
                                                    </tr>";
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ac">
            <?php
            include './pie.php';
            ?>
        </div>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
<!--        <script src="Admin/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="Admin/assets/scripts.js"></script>-->
    </body>
</html>