<?php
include_once './funciones.general.php';
//include_once '';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idcampania = filter_input(INPUT_POST, 'idasignar');
if($idcampania){
    $_SESSION['idcampania'] = $idcampania;
}


$consulta_contactos = "SELECT * FROM clientes_view where idasignar = " . $_SESSION['idcampania'];
$lista_contactos = bd_ejecutar_sql($consulta_contactos);
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
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        while ($fila_contactos = bd_obtener_fila($lista_contactos)) {
                                            $contactos[] = $fila_contactos;
                                        }

                                        if (!isset($contactos)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th><b>No.</b></th>
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
                                            $i = 1;
                                            foreach ($contactos as $c) {
                                                $ids = $c['idcliente'];
                                                echo"
                                                    <tr>
                                                    <td><b>" . $i . "</b></td>
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