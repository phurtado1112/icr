<?php
include_once './funciones.general.php';
	
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_campanias = "SELECT * FROM campanias_view where idcampania>1 and terminada='No' order by campania";
    $lista_campanias = bd_ejecutar_sql($consulta_campanias);
    while ($fila_campanias = bd_obtener_fila($lista_campanias)) {
        $campanias[] = $fila_campanias;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Campañas</title>
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
                                    <a href="campania_crear.php" class="btn btn-small btn-success">Nueva Campaña</a>
                                    <a href="campania_inactivo.php" class="btn btn-small btn-success">Campañas Inactivas</a>
                                    <a href="campania_estado.php" class="btn btn-small btn-success">Estado de Campañas</a>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($campanias)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>No.</th>
                                                <th>ID</th>
                                                <th>Campañas</th>
                                                <th>Programa</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Fin</th>
                                                <th>Acción</th>
                                            </tr>
                                            <?php
                                            $i=1;
                                            foreach ($campanias as $c) {
                                                $ids = $c['idcampania'];
                                                echo"
                                                    <tr>
                                                    <td><b>" . $i . "</b></td>
                                                    <td>" . $c['idcampania'] . "</td>
                                                    <td>" . $c['campania'] . "</td>
                                                    <td>" . $c['programa'] . "</td>
                                                    <td>" . $c['fechainicio'] . "</td>
                                                    <td>" . $c['fechafin'] . "</td>
                                                    <td>" . '<a href="campania_editar.php?idcampania=' . $ids . '">Editar</a> ---  <a href="campania_inactivar.php?idcampania=' . $ids . '">Inactivar</a>' . "</td>
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