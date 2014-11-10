<?php
include_once './funciones.general.php';
	
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_subtipificacion = "SELECT * FROM subtipificacion_view order by tipificacion, subtipificacion";
    $lista_subtipificacion = bd_ejecutar_sql($consulta_subtipificacion);
    while ($fila_subtipificacion = bd_obtener_fila($lista_subtipificacion)) {
        $subtipificacion[] = $fila_subtipificacion;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Subtipificación</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
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
                <div class="span12 well" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left" align="center"></div>
                                    <a href="subtipificacion_crear.php" class="btn btn-small btn-success">Nueva Subtipificación</a>
                                    <div class="muted pull-left" align="center"></div>
                                    <a href="subtipificacion_inactivo.php" class="btn btn-small btn-success">Subtipificaciones Inactivas</a>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($subtipificacion)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>ID</th>
                                                <th>Subtipificación</th>
                                                <th>Tipificación</th>
                                                <th>Acción</th>       
                                            </tr>
                                            <?php
                                            foreach ($subtipificacion as $t) {
                                                $ids = $t['idsubtipificacion'];
                                                echo"
                                                    <tr>
                                                    <td>" . $t['idsubtipificacion'] . "</td>
                                                    <td>" . $t['subtipificacion'] . "</td>
                                                    <td>" . $t['tipificacion'] . "</td>
                                                    <td>" . '<a href="subtipificacion_editar.php?idsubtipificacion=' . $ids . '">Editar</a> ---  <a href="subtipificacion_inactivar.php?idsubtipificacion=' . $ids . '">Inactivar</a>' . "</td>
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
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="Admin/assets/scripts.js"></script>
    </body>
</html>