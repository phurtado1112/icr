<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idcampania = filter_input(INPUT_POST, 'idcampania');
$_SESSION['idcampania'] = $idcampania;

$_pagi_sql = "SELECT * FROM clientes_view where idcampania = " . $_SESSION['idcampania'];
$lista_contactos = bd_ejecutar_sql($_pagi_sql);
//$numero_total_registros = mysqli_num_rows($lista_contactos);

while ($fila_contatos = bd_obtener_fila($lista_contactos)) {
    $contactos[] = $fila_contatos;
}

include './paginator.inc.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Leads</title>
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
                                    <?php
                                    echo $_SESSION ['idcampania'];
                                    ?>
                                    <!--                                    <a href="campania_crear.php" class="btn btn-small btn-success">Nueva Campaña</a>
                                                                        <a href="campania_inactivo.php" class="btn btn-small btn-success">Campañas Inactivas</a>-->
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        $_pagi_cuantos = 10; 
                                        
                                        if (!isset($contactos)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Teléfono</th>
                                                <th>Email</th>
                                                <th>Celular</th>
                                                <th>Oficina</th>
                                                <th>Cargo</th>
                                                <th>Empresa</th>
                                                <th>Prioridad</th>
                                                <th>País</th>
                                                <th>Acción</th>
                                            </tr>
                                            <?php
                                            while($row = mysql_fetch_array($_pagi_result)){ 
                                                $ids = $c['idcliente'];
                                                echo"
                                                    <tr>
                                                    <td>" . $c['nombre'] . "</td>
                                                    <td>" . $c['telfijo'] . "</td>
                                                    <td>" . $c['email'] . "</td>
                                                    <td>" . $c['telmovil'] . "</td>
                                                    <td>" . $c['teltrabajo'] . "</td>
                                                    <td>" . $c['cargo'] . "</td>
                                                    <td>" . $c['empresa'] . "</td>
                                                    <td>" . $c['prioridad'] . "</td>
                                                    <td>" . $c['pais'] . "</td>
                                                    <td>" . '<a href="contactos_editar.php?idcliente=' . $ids . '">Editar</a>' . "</td>
                                                    </tr>";
                                            }
                                        }
                                        echo"<p>".$_pagi_navegacion."</p>";
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