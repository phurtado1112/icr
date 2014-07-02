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
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Nueva Campaña</title>
        <link href="css/fio.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/bs.css" media="screen" rel="stylesheet" type="text/css">
        <link href="css/jquery-ui.css" rel="stylesheet">
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
                                    <form class="form-horizontal" action="campania_crear_procesar.php" name="formasignacion" method="post">
                                        <fieldset>
                                            <legend >Ingresar Nueva Campaña</legend>
                                            <div class="control-group">
                                                <label class="control-label">Campaña</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="campania" name="campania"   >
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Terminada</label>
                                                <div class="controls">
                                                    <select id="terminada" name="terminada">
                                                        <option value="n">No</option>
                                                        <option value="s">Si</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Fecha Inicio</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker" name="fechainicio" value="0000-00-00" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Fecha Final</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker1" name="fechafin" value="0000-00-00" />
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href = 'campania_lista.php'">Cancelar</button>
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
        <script type="text/javascript" src="js/cronos.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="Admin/assets/scripts.js"></script>
        <script>
            function validar() {
                if (document.getElementById('campania').value === '') {
                    alert('FALTA CAMPAÑA');
                } else {
                    if (confirm("¿Está seguro de guardar?")) {
                        document.formasignacion.submit();
                    } else {
                        document.formasignacion;
                    }

                }
            }
        </script>
        <script>
            $(function() {
                $("#datepicker").datepicker({dateFormat: "yy-mm-dd"});
                $("#datepicker1").datepicker({dateFormat: "yy-mm-dd"});
            });
        </script>
    </body>
</html>