<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.php"
	</script>';
}

$consulta_programas = "select distinct idprograma, programa from campanias_x_programa_view";
$lista_programas = bd_ejecutar_sql($consulta_programas);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Reporte de Gestión de Campaña</title>
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
            include 'menu_superior.php';
            ?>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12 well" id="content">
                    <div class="row-fluid">
                        <div class="row-fluid">
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Reporte de Gestión de Campaña</div>
                                </div>
                                <div class="block-content collapse in">
                                </div>
                                <form class="form-horizontal" id="frmgestionxprograma" name="formgestioncampania" method="post" action="rep_gestion_de_campania_procesar.php">
                                    <div class="control-group">
                                        <label class="control-label">Programa</label>
                                        <div class="controls">
                                            <select id="idprograma" name="idprograma" onchange="load(this.value)">
                                                <?php
//                                                    gen_llenar_combo("campanias_x_programa_view","idprograma","programa",$asignacion["idprograma"]);
                                                ?>
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
                                    <legend> &nbsp; Tipo de Reporte</legend>
                                        <div class="control-group radio">
                                            <div class="controls radio">
                                                <input type="radio" name="tipo" id="tipo" value="0" checked>Ejecutivo de Leads por Programa<br>
                                                <input type="radio" name="tipo" id="tipo" value="1">Leads por Campaña de Programa<br>
                                                <input type="radio" name="tipo" id="tipo" value="2">Leads por Agente por Programa<br>
                                            </div>
                                        </div>
                                    <div class="form-actions">
                                        <input type="submit" name="Submit" class="btn btn-primary" value="Presentar" onclick="Enviar()" >
                                        <button type="reset" class="btn" onclick="location.href = 'rep_gestion_campania_form.php'">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="Admin/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="Admin/vendors/jquery-1.9.1.min.js"></script>
        <script src="Admin/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/ajax_agentes.js"></script>
        <script src="js/ajax.js"></script>
        <script type="text/javascript">
            //VALIDACION PARA FORMULARIO DE NUEVO CONTACTO
            function Enviar() {
                if (document.getElementById('tipo').value === 0) {
                    document.formgestioncampania.target = '_blank';
                } else {
                    alert('Selección incorrecta');
                    location.href = 'rep_gestion_campania_form.php';
//                    if (document.getElementById('mail').value === '') {
//                        alert('Datos Incompletos');
//                    } else {
//                        document.formnewclient.submit();
//                    }
                }
            }
        </script>
    </body>
</html>
