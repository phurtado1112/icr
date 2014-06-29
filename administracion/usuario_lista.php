<?php
include_once './funciones.general.php';
	
if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_usuarios = "SELECT * FROM usuarios";
    $lista_usuarios = bd_ejecutar_sql($consulta_usuarios);
    while ($fila_usuario = bd_obtener_fila($lista_usuarios)) {
        $usuarios[] = $fila_usuario;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Usuarios</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="Admin/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
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
                                    <a href="usuario_crear.php" class="btn btn-small btn-success">Nuevo Usuario</a>
                                </div>
                                <div class="block-content collapse in">
                                    <table class="table table-striped table-hover">                            
                                        <?php
                                        if (!isset($usuarios)) {
                                            echo '<table><tr><th><h3><center></center></h3><th><tr><table>';
                                        } else {
                                            ?>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Usuario</th>
                                                <th>Tipo</th>
                                                <th>Acción</th>       
                                            </tr>
                                            <?php
                                            foreach ($usuarios as $u) {
                                                $ids = $u['idusuario'];
                                                echo"
                                                    <tr>
                                                    <td>" . $u['idusuario'] . "</td>
                                                    <td>" . $u['nombre'] . "</td>
                                                    <td>" . $u['usuario'] . "</td>
                                                    <td>" . $u['tipo'] . "</td>
                                                    <td>" . '<a href="usuario_editar.php?idusuario=' . $ids . '">Editar</a> ---  <a href="usuario_eliminar.php?idusuario=' . $ids . '">Eliminar</a>' . "</td>
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
        <script src="Admin/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="Admin/assets/scripts.js"></script>
        <script>
            $(function() {
                // Easy pie charts
                $('.chart').easyPieChart({animate: 1000});
            });
        </script>
    </body>
</html>