<?php
include_once './funciones.general.php';
	
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$tipificaciontipo = "SELECT * FROM tipificaciontipo where activo=1";
    $lista_tipificaciontipos = bd_ejecutar_sql($tipificaciontipo);
    while ($fila_tipificaciontipo = bd_obtener_fila($lista_tipificaciontipos)) {
        $tipificaciontipos[] = $fila_tipificaciontipo;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Tipo Tipificación</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<!--        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
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
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($tipificaciontipos)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tipo Tipificación</th>
                                                <th>Acción</th>
                                            </tr>
                                            <?php
                                            foreach ($tipificaciontipos as $tt) {
                                                $ids = $tt['idtipificaciontipo'];
                                                echo"
                                                    <tr>
                                                    <td>" . $tt['idtipificaciontipo'] . "</td>
                                                    <td>" . $tt['tipificaciontipo'] . "</td>
                                                    <td>" . '<a href="tipificacion_tipo_activar.php?idtipificaciontipo=' . $ids . '">Activar</a> '
                                                        . '---  <a href="tipificacion_tipo_eliminar.php?idtipificaciontipo=' . $ids . '">Eliminar</a>'."</td>
                                                    </tr>";
                                            }
                                        }
                                        ?>
                                    </table>
                                    <div class="form-actions">
                                        <button type="reset" class="btn" onclick="location.href = 'tipificacion_tipo_lista.php'">Cancelar</button>
                                    </div>
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
        <!--<script src="Admin/assets/scripts.js"></script>-->
    </body>
</html>