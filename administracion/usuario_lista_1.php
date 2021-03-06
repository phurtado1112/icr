<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

//$consulta_usuarios = "SELECT * FROM usuarios_view where activo=0 order by tipo desc";
//$lista_usuarios = bd_ejecutar_sql($consulta_usuarios);
//while ($fila_usuario = bd_obtener_fila($lista_usuarios)) {
//    $usuarios[] = $fila_usuario;
//}
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
                                    <div class="muted pull-left" align="center"></div>
                                    <a href="usuario_inactivo.php" class="btn btn-small btn-success">Usuarios Inactivos</a>
                                </div>
                                <div class="block-content collapse in">

                                    <?php
                                    //primero obtenemos el parametro que nos dice en que pagina estamos
                                    $page = 1; //inicializamos la variable $page a 1 por default
                                    if (array_key_exists('pg', $_GET)) {
                                        $page = $_GET['pg']; //si el valor pg existe en nuestra url, significa que estamos en una pagina en especifico.
                                    }

                                    $consulta_conteo = "SELECT count(*) as conteo FROM usuarios_view where activo=0";
                                    $lista_conteo = bd_ejecutar_sql($consulta_conteo);

                                    $conteo = bd_obtener_fila($lista_conteo);
                                    settype($conteo, "integer");

                                    //ahora dividimos el conteo por el numero de registros que queremos por pagina.
                                    $max_num_paginas = intval($conteo / 10); //en esto caso 10
                                    // ahora obtenemos el segmento paginado que corresponde a esta pagina
//                                        $segmento = $mysqli->query("SELECT *  FROM usuarios LIMIT " . (($page - 1) * 10) . ", 10 ");
                                    $consulta_segmento = "SELECT * FROM usuarios_view where activo=0 limit " . (($page - 1) * 10) . ", 10 ";
                                    $segmento = bd_ejecutar_sql($consulta_segmento);
                                    if ($segmento) {
                                        ?>
                                        <table class="table table-striped table-hover">
                                            <?php
                                            while ($fila_usuario = bd_obtener_fila($segmento)) {
                                                $usuarios[] = $fila_usuario;

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
//                                                    foreach ($usuarios as $u) {
                                                        $ids = $usuarios['idusuario'];
                                                        echo"
                                                    <tr>
                                                    <td>" . $usuarios['idusuario'] . "</td>
                                                    <td>" . utf8_decode($usuarios['nombre']) . "</td>
                                                    <td>" . $usuarios['usuario'] . "</td>
                                                    <td>" . $usuarios['tipo'] . "</td>
                                                    <td>" . '<a href="usuario_editar.php?idusuario=' . $ids . '">Editar</a> ---  <a href="usuario_inactivar.php?idusuario=' . $ids . '">Inactivar</a>' . "</td>
                                                    </tr>";
                                                    }
                                                }
                                            }
                                            ?>
                                        </table>
                                        <?php
//                                    }
                                    for ($i = 0; $i < $max_num_paginas; $i++) {
                                        echo '<a href="usuario_lista.php?pg=' . ($i + 1) . '">' . ($i + 1) . '</a> | ';
                                    }
                                    ?>
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