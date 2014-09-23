<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_campania = "SELECT * FROM campanias WHERE terminada= 'n'";
$lista_campania = bd_ejecutar_sql($consulta_campania);
?>
<!DOCTYPE html>
<html lang="en">
    <head >
        <meta charset="utf-8" />
        <title>Contactos</title>
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

                                    <form class="form-horizontal" action="contactos_lista.php" name="formcontactos" method="POST">
                                        <fieldset>
                                            <legend>Selecciona la campaña para ver los Leads</legend>
                                            <div class="control-group">
                                                <label class="control-label">Campaña</label>
                                                <div class="controls">
                                                    <select id="idcampania" name="idcampania">
                                                        <?php
                                                        while ($fila_campania = bd_obtener_fila($lista_campania)) {
                                                            ?>
                                                            <option value="<?php echo $fila_campania['idcampania']; ?>"><?php echo $fila_campania['campania']; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="document.formcontactos.submit()" name='enviar' value="Contactos">
                                                <button type="reset" class="btn" onclick="location.href = 'contactos.php'">Cancelar</button>
                                                <input type="hidden" value="upload" name="action" />
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
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="Admin/assets/scripts.js"></script>
<!--        <script>
            function validar() {
                if (confirm("¿Está seguro de importar los datos?")) {
                    document.formimportar.submit();
                } else {
                    document.formimportar;
                }
            }
        </script>-->
    </body>
</html>