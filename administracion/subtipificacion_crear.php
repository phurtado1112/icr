<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_tipificacion = "SELECT * FROM tipificacion where activo=0 order by tipificacion";
$lista_tipificacion = bd_ejecutar_sql($consulta_tipificacion);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nueva Subtipificación</title>
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
                                    <form class="form-horizontal" action="subtipificacion_crear_procesar.php" name="formsubtipificacion" method="post">
                                        <fieldset>
                                            <legend >Ingresar Nueva Subtipificación</legend>
                                            <div class="control-group">
                                                <label class="control-label">Subtipificación</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="subtipificacion" name="subtipificacion" autofocus>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Tipificación</label>
                                                <div class="controls">
                                                    <select id="idtipificacion" name="idtipificacion">
                                                        <?php
                                                            while ($fila_tipificacion = bd_obtener_fila($lista_tipificacion)) {
                                                        ?>
                                                            <option value="<?php echo $fila_tipificacion['idtipificacion'];?>"><?php echo $fila_tipificacion['tipificacion'];?></option>
                                                        <?php 
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href='subtipificacion_lista.php'">Cancelar</button>
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
                if (document.getElementById('subtipificacion').value === '') {
                    alert('FALTA EL SUBTIPIFICACIÓN');
                } else {
                    if (confirm("¿Está seguro de guardar?")) {
                        document.formsubtipificacion.submit();
                    } else {
                        document.formsubtipificacion;
                    }
                }
            }
        </script>
    </body>
</html>