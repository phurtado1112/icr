<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$idcliente = filter_input(INPUT_GET, 'idcliente');

$consulta_cliente = "SELECT * FROM clientes WHERE idcliente='" . $idcliente . "' ";
$lista_cliente = bd_ejecutar_sql($consulta_cliente);
$cliente = bd_obtener_fila($lista_cliente);

$id = $cliente['idcliente'];
$nombre = $cliente['nombre'];
$telfijo = $cliente['telfijo'];
$email = $cliente['email'];
$telmovil = $cliente ['telmovil'];
$teltrabajo = $cliente ['teltrabajo'];
$cargo = $cliente ['cargo'];
$empresa = $cliente ['empresa'];
$prioridad = $cliente ['prioridad'];
$idestado = $cliente ['idestado'];
$agendado = $cliente ['agendado'];
$pais = $cliente ['pais'];
$idcampania = $cliente['idcampania'];

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Editar Leads</title>
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

                                    <form class="form-horizontal" action="contactos_editar_procesar.php" name="formcontactos" method="POST">
                                        <div style="display:none"><input type="text" value="<?php echo $id; ?>" name="idcliente" size="1"></div>
                                        <div style="display:none"><input type="text" value="<?php echo $idestado; ?>" name="idestado" size="1"></div>
                                        <div style="display:none"><input type="text" value="<?php echo $agendado; ?>" name="agendado" size="1"></div>
                                        <div style="display:none"><input type="text" value="<?php echo $idcampania; ?>" name="idcampania" size="1"></div>
                                        <fieldset>
                                            <legend >Editar Leads</legend>
                                            <div class="control-group">
                                                <label class="control-label">Nombre</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="nombre" name="nombre" value="<?php echo $nombre; ?>" autofocus>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Teléfono</label>
                                                <div class="controls">
                                                    <input type="text" class="span3 typeahead" id="telfijo" name="telfijo" value="<?php echo $telfijo; ?>">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Email</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="email" name="email" value="<?php echo $email; ?>">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Celular</label>
                                                <div class="controls">
                                                    <input type="text" class="span3 typeahead" id="telmovil" name="telmovil" value="<?php echo $telmovil; ?>">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Tel. Trabajo</label>
                                                <div class="controls">
                                                    <input type="text" class="span3 typeahead" id="teltrabajo" name="teltrabajo" value="<?php echo $teltrabajo; ?>">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Cargo</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="cargo" name="cargo" value="<?php echo $cargo; ?>">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Empresa</label>
                                                <div class="controls">
                                                    <input type="text" class="span6 typeahead" id="empresa" name="empresa" value="<?php echo $empresa; ?>">
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Prioridad</label>
                                                <div class="controls">
                                                    <select>
                                                        <?php
                                                            $elementos_combo_prioridad = array("0"=>"Roja","1"=>"Verde","2"=>"Azul");
                                                            gen_llenar_combo_arreglo($elementos_combo_prioridad ,$prioridad); 
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">País</label>
                                                <div class="controls">
                                                    <select>
                                                        <?php 
                                                            gen_llenar_combo("pais","idpais","pais",$pais);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <input type="button" class="btn btn-primary" onClick="validar()" value="Guardar">
                                                <button type="reset" class="btn" onclick="location.href='contactos_lista.php?idcampania=idcampania'">Cancelar</button>
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
                    document.formcampania.submit();
                }
            }
        </script>
<!--        <script>
            $(function() {
                $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
                $("#datepicker1").datepicker({ dateFormat: "yy-mm-dd" });
            });
        </script>-->
    </body>
</html>