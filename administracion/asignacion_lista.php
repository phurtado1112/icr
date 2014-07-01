<?php
include_once './funciones.general.php';
	
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_asignacion = "SELECT * FROM asignacion_view";
    $lista_asignacion = bd_ejecutar_sql($consulta_asignacion);
    while ($fila_asignacion = bd_obtener_fila($lista_asignacion)) {
        $asignacion[] = $fila_asignacion;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Asignación</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
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
                                    <a href="asignacion_crear.php" class="btn btn-small btn-success">Nueva Asignación</a>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($asignacion)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>ID</th>
                                                <th>Usuario</th>
                                                <th>Campaña Asignada</th>
                                                <th>Fecha Asignación</th>
                                                <th>Acción</th>
                                            </tr>
                                            <?php
                                            foreach ($asignacion as $a) {
                                                $ids = $a['idasignar'];
                                                echo"
                                                    <tr>
                                                    <td>" . $a['idasignar'] . "</td>
                                                    <td>" . $a['nombre'] . "</td>
                                                    <td>" . $a['campania'] . "</td>
                                                    <td>" . $a['fecha'] . "</td>
                                                    <td>" . '<a href="asignacion_editar.php?idasignar=' . $ids . '">Editar</a> ---  <a href="asignacion_eliminar.php?idasignar=' . $ids . '">Eliminar</a>' . "</td>
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
        <script src="Admin/assets/scripts.js"></script>
    </body>
</html>