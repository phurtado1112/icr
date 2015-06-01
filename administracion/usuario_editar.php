<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idusuario = filter_input(INPUT_GET, 'idusuario');

$consulta_usuario = "SELECT * FROM usuarios WHERE idusuario='" . $idusuario . "' ";
$lista_usuario = bd_ejecutar_sql($consulta_usuario);
$usuario = bd_obtener_fila($lista_usuario);

$id = $usuario['idusuario'];
$nombre = $usuario['nombre'];
$usua = $usuario['usuario'];
$contrasenia = $usuario['contrasena'];
$tipo = $usuario['tipo'];

$consulta_usuario_tipo = "SELECT idusuariotipo, usuariotipo from usuario_tipo";
$lista_usuario_tipo = bd_ejecutar_sql($consulta_usuario_tipo);
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>Editar Usuario</title>
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
        <div class="container">
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span10 well" id="content">
                        <div class="row-fluid">
                            <div class="row-fluid">
                                <div class="block">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left" align="center"></div>
                                    </div>
                                    <div class="block-content collapse in">

                                        <form class="form-horizontal" action="usuario_editar_procesar.php" name="formusuario" method="POST">
                                            <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idusuario" size="1"></div>
                                            <fieldset>
                                                <legend >Editar Usuario</legend>
                                                <div class="control-group">
                                                    <label class="control-label">Nombre</label>
                                                    <div class="controls">
                                                        <input type="text" class="span6 typeahead" id="nombre" name="nombre" value="<?php echo $nombre; ?>" autofocus>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" >Usuario</label>
                                                    <div class="controls">
                                                        <input type="text" class="span6 typeahead" id="usuario" name="usuario" value="<?php echo $usua; ?>"  >
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Tipo</label>
                                                    <div class="controls">
                                                        <select id="tipo" name="tipo">
                                                            <?php
                                                            while ($fila_usuario_tipo = bd_obtener_fila($lista_usuario_tipo)) {

                                                                echo '<option value="' . $fila_usuario_tipo['idusuariotipo'] . '"';
                                                                if ($fila_usuario_tipo['idusuariotipo'] == $tipo) {
                                                                    echo 'selected';
                                                                }
                                                                echo '>' . $fila_usuario_tipo['usuariotipo'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-actions">
                                                    <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                    <button type="reset" class="btn" onclick="location.href = 'usuario_lista.php'">Cancelar</button>
                                                </div>
                                            </fieldset>
                                        </form>
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
        <!--<script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <!--<script src="Admin/assets/scripts.js"></script>-->
        <script>
                                                        function validar() {
                                                            if (document.getElementById('nombre').value === '') {
                                                                alert('FALTA NOMBRE');
                                                            } else {
                                                                if (document.getElementById('usuario').value === '') {
                                                                    alert('FALTA USUARIO');
                                                                } else {
                                                                    document.formusuario.submit();
                                                                }
                                                            }
                                                        }
        </script>
    </body>
</html>