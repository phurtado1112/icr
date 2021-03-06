<?php
include_once './funciones.general.php';
	
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_tipificacion = "SELECT tipificacion, idtipificacion, tipificaciontipo FROM tipificacion_view where activo=0 order by tipificacion";
    $lista_tipificacion = bd_ejecutar_sql($consulta_tipificacion);
    while ($fila_tipificacion = bd_obtener_fila($lista_tipificacion)) {
        $tipificacion[] = $fila_tipificacion;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tipificación</title>
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
                                    <a href="tipificacion_crear.php" class="btn btn-small btn-success">Nueva Tipificación</a>
                                    <div class="muted pull-left" align="center"></div>
                                    <a href="tipificacion_inactivo.php" class="btn btn-small btn-success">Tipificación Inactivas</a>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($tipificacion)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>No.</th>
                                                <th>Tipificación</th>
                                                <th>Tipo</th>
                                                <th>Acción</th>       
                                            </tr>
                                            <?php
                                            $i = 1;
                                            foreach ($tipificacion as $t) {
                                                $ids = $t['idtipificacion'];
                                                echo"
                                                    <tr>
                                                    <td><b>" . $i . "</b></td>
                                                    <td>" . $t['tipificacion'] . "</td>
                                                    <td>" . $t['tipificaciontipo'] . "</td>    
                                                    <td>" . '<a href="tipificacion_editar.php?idtipificacion=' . $ids . '">Editar</a> ---  <a href="tipificacion_inactivar.php?idtipificacion=' . $ids . '">Inactivar</a>' . "</td>
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
        <script src="Admin/assets/scripts.js"></script>
    </body>
</html>