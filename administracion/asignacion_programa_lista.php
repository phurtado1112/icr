<?php
include_once './funciones.general.php';
	
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_asignacion_prog = "SELECT * FROM campanias_view where idcampania > 1 and terminada='no' order by idcampania desc";
$lista_asignacion_prog = bd_ejecutar_sql($consulta_asignacion_prog);
while ($fila_asignacion_prog = bd_obtener_fila($lista_asignacion_prog)) {
    $asignacion_prog[] = $fila_asignacion_prog;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>Asignación Programa</title>
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
                                    <a href="asignacion_programa_crear.php" class="btn btn-small btn-success">Nueva Asignación de Programa</a>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">
                                        <?php
                                        if (!isset($asignacion_prog)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>No.</th>
                                                <th>Campaña</th>
                                                <th>Programa</th>
                                                <th>Acción</th>
                                            </tr>
                                            <?php
                                            $i=1;
                                            foreach ($asignacion_prog as $ap) {
                                                $ids = $ap['idcampania'];
                                                echo"
                                                    <tr>
                                                    <td><b>" . $i . "</b></td>
                                                    <td>" . $ap['campania'] . "</td>
                                                    <td>" . $ap['programa'] . "</td>
                                                    <td>" . '<a href="asignacion_programa_editar.php?idcampania=' . $ids . '">Editar</a>' ."</td>
                                                    </tr>";
                                                $i = $i + 1;
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