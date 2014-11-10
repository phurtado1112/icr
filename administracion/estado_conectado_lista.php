<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_estado_conectado = "SELECT * FROM estados where activo=0";
$lista_estado_conectado = bd_ejecutar_sql($consulta_estado_conectado);
while ($fila_estado_conectado = bd_obtener_fila($lista_estado_conectado)) {
    $estado_conectado[] = $fila_estado_conectado;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Estados Agentes</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="Admin/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
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
                                    <a href="estado_conectado_crear.php" class="btn btn-small btn-success">Nuevo Estado</a>
                                    <div class="muted pull-left" align="center"></div>
                                    <a href="estado_conectado_inactivo.php" class="btn btn-small btn-success">Estados Inactivos</a>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($estado_conectado)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>ID</th>
                                                <th>Estado</th>
                                                <th>Acción</th>       
                                            </tr>
                                            <?php
                                            foreach ($estado_conectado as $ec) {
                                                $ids = $ec['idestado'];
                                                echo"
                                                    <tr>
                                                    <td>" . $ec['idestado'] . "</td>
                                                    <td>" . $ec['estado'] . "</td>
                                                    <td>" . '<a href="estado_conectado_editar.php?idestado=' . $ids . '">Editar</a> ---  <a href="estado_conectado_inactivar.php?idestado=' . $ids . '">Inactivar</a>' . "</td>
                                                    </tr>";
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
        <script src="Admin/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="Admin/assets/scripts.js"></script>
        <script>
            $(function() {
                // Easy pie charts
                $('.chart').easyPieChart({animate: 1000});
            });
        </script>
    </body>
</html>