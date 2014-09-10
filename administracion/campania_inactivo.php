<?php
include_once './funciones.general.php';
	
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$campania = "SELECT * FROM campanias where terminada='s' and idcampania>1";
    $lista_campania = bd_ejecutar_sql($campania);
    while ($fila_campania = bd_obtener_fila($lista_campania)) {
        $campanias[] = $fila_campania;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Campañas Inactivas</title>
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
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($campanias)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>ID</th>
                                                <th>Campañas</th>
                                                <th>Fecha Inicio</th>
                                                <th>Fecha Fin</th>
                                                <th>Acción</th>
                                            </tr>
                                            <?php
                                            foreach ($campanias as $c) {
                                                $ids = $c['idcampania'];
                                                echo"
                                                    <tr>
                                                    <td>" . $c['idcampania'] . "</td>
                                                    <td>" . $c['campania'] . "</td>
                                                    <td>" . $c['fechainicio'] . "</td>
                                                    <td>" . $c['fechafin'] . "</td>
                                                    <td>" . '<a href="campania_activar.php?idcampania=' . $ids . ">Activar</a></td>
                                                    </tr>";
                                            }
                                        }
                                        ?>
                                    </table>
                                    <div class="form-actions">
                                        <button type="reset" class="btn" onclick="location.href = 'campania_lista.php'">Cancelar</button>
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
        <script src="Admin/assets/scripts.js"></script>
    </body>
</html>