<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_pais = "SELECT * FROM pais";
$lista_pais = bd_ejecutar_sql($consulta_pais);
while ($fila_pais = bd_obtener_fila($lista_pais)) {
    $pais[] = $fila_pais;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>País</title>
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
                                    <a href="pais_crear.php" class="btn btn-small btn-success">Nuevo País</a>
                                    <a href="pais_inactivo.php" class="btn btn-small btn-success">Países Inactivos</a>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($pais)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>No.</th>
                                                <th>País</th>
                                                <th>Acción</th>       
                                            </tr>
                                            <?php
                                            $i = 1;
                                            foreach ($pais as $p) {
                                                $ids = $p['idpais'];
                                                echo"
                                                    <tr>
                                                    <td><b>" . $i . "</b></td>
                                                    <td>" . $p['pais'] . "</td>
                                                    <td>" . '<a href="pais_editar.php?idpais=' . $ids . '">Editar</a> ---  <a href="pais_inactivar.php?idpais=' . $ids . '">Inactivar</a>' . "</td>
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