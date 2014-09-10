<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idpais = filter_input(INPUT_GET, 'idpais');

$consulta_pais = "SELECT * FROM pais WHERE idpais='" . $idpais . "' ";
$lista_pais = bd_ejecutar_sql($consulta_pais);
$paises = bd_obtener_fila($lista_pais);

$id = $paises['idpais'];
$pais = $paises['pais'];
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>Editar País</title>
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

                                    <form class="form-horizontal" action="pais_editar_procesar.php" name="formpais" method="POST">
                                        <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idpais" size="1"></div>
                                        <fieldset>
                                            <legend >Editar País</legend>
                                            <div class="control-group">
                                                <label class="control-label">País</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="pais" name="pais" value="<?php echo $pais; ?>" autofocus>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href='pais_lista.php'">Cancelar</button>
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
        <script src="Admin/assets/scripts.js"></script>
        <script>
            function validar() {
                if (document.getElementById('pais').value === '') {
                    alert('FALTA EL PAÍS');
                } 
                    document.formpais.submit();
            }
        </script>
    </body>
</html>