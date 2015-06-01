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
        <meta charset="UTF-8">
        <title>Reporte de Gestión de Campaña</title>
        <link href="Admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="Admin/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="css/jquery-ui.css" rel="stylesheet">
        <link href="Admin/assets/styles.css" rel="stylesheet" media="screen">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />        
    </head>
    <body>
        <div>
            <?php
            include 'menu_superior.php';
            ?>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12 well" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="inicio">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left">Reporte de Gestión de Campañas</div>
                                    </div>
                                </div>
                                <div id="total-tit" style="display:none">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left">Total por Programa</div>
                                    </div>
                                </div>
                                <div id="campania-tit" style="display:none">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left">Detallado de Programa por Campaña</div>
                                    </div>
                                </div>
                                <div id="asesor-tit" style="display:none">
                                    <div class="navbar navbar-inner block-header">
                                        <div class="muted pull-left">Detallado de Programa por Asesor</div>
                                    </div>
                                </div>
                                <div class="btn-toolbar">
                                <div class="btn-group well-large">
                                    <div class="muted pull-left" align="center"></div>
                                    <button class="btn btn-success" id="total-btn">Total de Programa</button>
                                    <div class="muted pull-left" align="center"></div>
                                    <button class="btn btn-success" id="campania-btn">Detalle de Campaña</button>
                                    <div class="muted pull-left" align="center"></div>
                                    <button class="btn btn-success" id="asesor-btn">Detalle de Asesor</button>
                                </div>
                                    </div>
                                <div class="block-content collapse in">
                                </div>
                                <!-- Formulario por Programa -->
                                <form class="form-horizontal" id="frmgestionxprograma" name="formgestionprograma" method="post" action="rep_gestion_de_campania_programa_procesar.php" style="display:none">
                                    <?php
                                        $consulta_programas = "select distinct idprograma, programa from campanias_x_programa_view";
                                        $lista_programas = bd_ejecutar_sql($consulta_programas);
                                    ?>
                                    <div class="control-group">
                                        <label class="control-label">Programa</label>
                                        <div class="controls">
                                            <select id="idprograma" name="idprograma" onchange="load(this.value)">
                                                <?php
                                                while ($fila_programa = bd_obtener_fila($lista_programas)) {
                                                    ?>
                                                    <option value="<?php echo $fila_programa['idprograma']; ?>"><?php echo $fila_programa['programa']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Fecha Inicio</label>
                                        <div class="controls">
                                            <input type="text" id="datepicker" name="fechainicio" value="<?php echo date('Y-m-d'); ?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Fecha Final</label>
                                        <div class="controls">
                                            <input type="text" id="datepicker1" name="fechafin" value="<?php echo date('Y-m-d'); ?>" />
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" name="Submit" class="btn btn-primary" value="Presentar" onclick="document.formgestionprograma.target = '_blank'" >
                                        <button type="reset" class="btn" onclick="location.href = 'rep_gestion_de_campanias_form.php'">Cancelar</button>
                                    </div>
                                </form>
                                <!-- Formulario por Campaña -->
                                <form class="form-horizontal" id="frmgestionxcampania" name="formgestioncampania" method="post" action="rep_gestion_de_campania_detallado_campania_procesar.php" style="display:none">
                                    <?php
                                        $consulta_programas1 = "select distinct idprograma, programa from campanias_x_programa_view";
                                        $lista_programas1 = bd_ejecutar_sql($consulta_programas1);
                                    ?>
                                    <div class="control-group">
                                        <label class="control-label">Programa</label>
                                        <div class="controls">
                                            <select id="idprograma" name="idprograma" onchange="load(this.value)">
                                                <?php
                                                while ($fila_programa = bd_obtener_fila($lista_programas1)) {
                                                    ?>
                                                    <option value="<?php echo $fila_programa['idprograma']; ?>"><?php echo $fila_programa['programa']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                                <label class="control-label">Fecha Inicio</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker2" name="fechainicio" value="<?php echo date('Y-m-d');?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Fecha Final</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker3" name="fechafin" value="<?php echo date('Y-m-d');?>" />
                                                </div>
                                            </div>
                                    <div class="form-actions">
                                        <input type="submit" name="Submit" class="btn btn-primary" value="Presentar" onclick="document.formgestioncampania.target = '_blank'" >
                                        <button type="reset" class="btn" onclick="location.href = 'rep_gestion_de_campanias_form.php'">Cancelar</button>
                                    </div>
                                </form>
                                <!-- Formulario por asesor -->
                                <form class="form-horizontal" id="frmgestionxasesor" name="formgestionasesor" method="post" action="rep_gestion_de_campania_detallado_asesor_procesar.php" style="display:none">
                                    <?php
                                        $consulta_programas2 = "select distinct idprograma, programa from campanias_x_programa_view";
                                        $lista_programas2 = bd_ejecutar_sql($consulta_programas2);
                                    ?>
                                    <div class="control-group">
                                        <label class="control-label">Programa</label>
                                        <div class="controls">
                                            <select id="idprograma" name="idprograma" onchange="load(this.value)">
                                                <?php
                                                while ($fila_programa = bd_obtener_fila($lista_programas2)) {
                                                    ?>
                                                    <option value="<?php echo $fila_programa['idprograma']; ?>"><?php echo $fila_programa['programa']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                                <label class="control-label">Fecha Inicio</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker4" name="fechainicio" value="<?php echo date('Y-m-d');?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Fecha Final</label>
                                                <div class="controls">
                                                    <input type="text" id="datepicker5" name="fechafin" value="<?php echo date('Y-m-d');?>" />
                                                </div>
                                            </div>
                                    <div class="form-actions">
                                        <input type="submit" name="Submit" class="btn btn-primary" value="Presentar" onclick="document.formgestionasesor.target = '_blank'" >
                                        <button type="reset" class="btn" onclick="location.href = 'rep_gestion_de_campanias_form.php'">Cancelar</button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script>
            $(document).ready(function () {
                $("#datepicker").datepicker({dateFormat: "yy-mm-dd"});
                $("#datepicker1").datepicker({dateFormat: "yy-mm-dd"});
                
                $("#datepicker2").datepicker({dateFormat: "yy-mm-dd"});
                $("#datepicker3").datepicker({dateFormat: "yy-mm-dd"});
                
                $("#datepicker4").datepicker({dateFormat: "yy-mm-dd"});
                $("#datepicker5").datepicker({dateFormat: "yy-mm-dd"});
            });
        </script>
        <script src="js/rep_gestion_campanias.js"></script>
    </body>
</html>
