<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$programa = "SELECT * FROM programas where activo=1";
$lista_programas = bd_ejecutar_sql($programa);
while ($fila_programa = bd_obtener_fila($lista_programas)) {
    $programas[] = $fila_programa;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Programas</title>
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
                                        if (!isset($programas)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>ID</th>
                                                <th>Programa</th>
                                                <th>Acción</th>
                                            </tr>
                                            <?php
                                            foreach ($programas as $p) {
                                                $ids = $p['idprograma'];
                                                echo"
                                                    <tr>
                                                    <td>" . $p['idprograma'] . "</td>
                                                    <td>" . $p['programa'] . "</td>
                                                    <td class='btn'>" . '<a href="programa_activar.php?idprograma=' . $ids . '">Activar</a>'."</td>
                                                    </tr>";
                                            }
                                        }
                                        ?>
                                    </table>
                                    <div class="form-actions">
                                        <button type="reset" class="btn" onclick="location.href = 'programa_lista.php'">Cancelar</button>
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