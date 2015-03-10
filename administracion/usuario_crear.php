<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nuevo Usuario</title>
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
                <div class="span12" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left" align="center"></div>
                                </div>
                                <div class="block-content collapse in">
                                    <form class="form-horizontal" action="usuario_crear_procesar.php" name="formusuario" method="post">
                                        <fieldset>
                                            <legend >Ingresar Nuevo Usuario</legend>
                                            <div class="control-group">
                                                <label class="control-label">Nombre</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="nombre" name="nombre" autofocus>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Usuario</label>
                                                <div class="controls">
                                                    <input type="text" class="" id="usuario" name="usuario" >
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Contraseña</label>
                                                <div class="controls">
                                                    <input type="text" id="contrasenia" name="contrasenia">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Tipo Usuario</label>
                                                <div class="controls">
                                                    <select id="tipo" name="tipo">
                                                        <option value="0">Seminarios</option>
                                                        <option value="1">Maestría</option>
                                                        <option value="2">Administración</option>
                                                        <option value="3">Global EMBA</option>
                                                        <option value="4">Actualizadores</option>
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
        <div class="ac">
            <?php
            include './pie.php';
            ?>
        </div>
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="Admin/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="Admin/assets/scripts.js"></script>
        <script>
            function validar() {
                if (document.getElementById('nombre').value === '') {
                    alert('FALTA NOMBRE');
                } else {
                    if (document.getElementById('usuario').value === '') {
                        alert('FALTA USUARIO');
                    } else {
                        if (document.getElementById('contrasenia').value === '') {
                            alert('FALTA CONTRASEÑA');
                        } else {
                            if (confirm("¿Está seguro de guardar?")) {
                                document.formusuario.submit();
                            } else {
                                document.formusuario;
                            }
                        }
                    }
                }
            }
        </script>
    </body>
</html>