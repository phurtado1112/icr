<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "index.php"
</script>';
}

$idclien = filter_input(INPUT_GET, 'idcliente');
$proceso = filter_input(INPUT_GET, 'proceso');
$idtransaccion = filter_input(INPUT_GET, 'idtransaccion');

$consulta_cliente = "SELECT * FROM transacciones_view WHERE idcliente='" . $idclien . "'";
$lista_cliente = bd_ejecutar_sql($consulta_cliente);
while ($filax = bd_obtener_fila($lista_cliente)) {
    $contactosx[] = $filax;
}

$idasignar = $_SESSION['idasignar'];
$idcampania = $_SESSION['idcampania'];

$consulta_clientes = "SELECT * FROM clientes WHERE idasignar='" . $idasignar . "'AND idcliente='" . $idclien . "' ";
$lista_clientes = bd_ejecutar_sql($consulta_clientes);
$fila = bd_obtener_fila($lista_clientes);
$idcliente = $fila['idcliente'];
$nombre = $fila['nombre'];
$telefono = $fila['telfijo'];
$correo = $fila['email'];
$celular = $fila['telmovil'];
$teltrabajo = $fila['teltrabajo'];
$cargo = $fila['cargo'];
$empresa = $fila['empresa'];

$atendido = "SELECT count(*) AS conteo FROM clientes WHERE idasignar='" . $idasignar . "'AND idestado='1'";
$lista_antendido = bd_ejecutar_sql($atendido);
$filaa = bd_obtener_fila($lista_antendido);
$var_atendido = $filaa['conteo'];

$noatendido = "SELECT count(*) AS conteo1 FROM clientes WHERE idasignar='" . $idasignar . "'";
$lista_noatendidos = bd_ejecutar_sql($noatendido);
$filana = bd_obtener_fila($lista_noatendidos);
$var_no_atendido = $filana['conteo1'];

$consulta_campania = "SELECT * FROM campanias WHERE idcampania=" . $idcampania;
$lista_campanias = bd_ejecutar_sql($consulta_campania);
$filacamp = bd_obtener_fila($lista_campanias);
$var_camp_nombre = $filacamp['campania'];

$consulta_idtipificacion_transaccion_origen = "SELECT idtipificacion FROM transaccion WHERE idtrasaccion='" . $idtransaccion . "'";
$lista_idtipificacion_transaccion_origen = bd_ejecutar_sql($consulta_idtipificacion_transaccion_origen);
$fila_idtipificacion_transaccion_origen = bd_obtener_fila($lista_idtipificacion_transaccion_origen);
$idtipificacion = $fila_idtipificacion_transaccion_origen['idtipificacion'];

$consulta_asesor = "SELECT nombre FROM usuarios WHERE idusuario='" . $_SESSION['idusuario'] . "'";
$lista_asesor = bd_ejecutar_sql($consulta_asesor);
$fila_asesor = bd_obtener_fila($lista_asesor);
$nombre_asesor = $fila_asesor['nombre'];

if ($idtipificacion == '5') {
    echo '<script language = javascript>
         alert("Contacto Agendado procesar en Agendados")
         self.location = "contacto_atendido.php"
         </script>';
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>INCAE</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/jquery-ui.css" rel="stylesheet">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="brand" href="#"><?php echo $var_camp_nombre; ?></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="cliente_contacto_agendado.php">Agendados</a></li>
                            <li><a href="cliente_contacto.php">Contactos</a></li>
                            <li><a href="cliente_atendido.php">Atendidos</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div align="center"></div>    

        <div align="center" id="DIVcliente">
            <form action="cliente_procesar.php" method="post" name="Frmcliente">
                <fieldset>
                    <legend>Clientes atendidos: <?php echo $var_atendido ?> de <?php echo $var_no_atendido ?></legend>             
                    <div style="display:none">
                        <input type="text" id="idusuario" size="1" value="<?php echo $_SESSION['idusuario'] ?>"/>
                        <input type="text" name="idcliente" id="idcliente" size="1" value="<?php echo $idcliente ?>"  />                
                    </div>
                    <table width="1200">
                        <thead>
                            <?php if ($proceso == 2) { ?>
                                <tr id="titulogestion">
                                <?php } else if ($proceso == 3) { ?>
                                <tr id="tituloatendido">
                                <?php } else { ?>
                                <tr id="tituloagendado">
                                <?php } ?>
                                <td><strong>Nombre:</strong></td> 
                                <td><strong>Teléfono:</strong></td>
                                <td><strong>Email:</strong></td>
                                <td><strong>Celular:</strong></td>
                                <td><strong>Teléfono Trabajo:</strong></td>
                                <td><strong>Puesto:</strong> </td>
                                <td><strong>Empresa:</strong> </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $nombre ?></td>
                                <td><?php echo $telefono ?></td>
                                <td><?php echo $correo ?></td>
                                <td><?php echo $celular ?></td>
                                <td><?php echo $teltrabajo ?></td>
                                <td><?php echo $cargo ?></td>
                                <td><?php echo $empresa ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br><br>
                    <div class="row-fluid">
                        <div class="span6 offset3 well">
                            <div class="row-fluid">
                                <div class="row-fluid">
                                    <div class="block-content">
                                        <input type="hidden" value="<?php echo $proceso; ?>" name="proceso" id="proceso">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Tipificación:</th>
                                                    <td>
                                                        <?php
                                                        $consulta_tipi = "select * from tipificacion where activo=0";
                                                        $lista_tipi = bd_ejecutar_sql($consulta_tipi);
                                                        ?>
                                                        <select name="finales" id="finales" >  <!--onChange="subtipo(this.value)"-->
                                                            <option value="0">Seleccione...</option>
                                                            <?php
                                                            while ($fila = bd_obtener_fila($lista_tipi)) {
                                                                ?>
                                                                <option  id="tipicacion" value="<?php echo $fila['idtipificacion']; ?>"><?php echo $fila['tipificacion']; ?></option>
                                                            <?php } ?>	    
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Subtipificación</th>
                                                    <td>
                                                        <div id="Divtiponointeresado"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Actualización:</th>
                                                    <td>
                                                        <div id="actualiza">
                                                            <input type="radio" id="actualiza0" name="actualiza" value="no" checked> NO
                                                            <input type="radio" id="actualiza1" name="actualiza" value="si"> SI
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Agendar:</th>
                                                    <td>
                                                        <input type="text" id="datepicker" value="0000-00-00"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Observación:</th>
                                                    <td>
                                                        <textarea name="observacion" id="OBSERVACION"></textarea>
                                                    </td>
                                                </tr> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-control">
                        <input type="button" value="Guardar" onClick="SAVE()" class="btn btn-success" />
                        <?php if ($proceso == 2) { ?>
                                <button type="reset" class="btn btn-success" onclick="location.href = 'contacto_nuevo.php'">Cancelar</button>
                                <?php } else if ($proceso == 3) { ?>
                                <button type="reset" class="btn btn-success" onclick="location.href = 'contacto_atendido.php'">Cancelar</button>
                                <?php } else { ?>
                                <button type="reset" class="btn btn-success" onclick="location.href = 'contacto_agendado.php'">Cancelar</button>
                                <?php } ?>
                    </div>
                    <br><br>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>                    
                                <th>Tipificación</th>                    
                                <th>Observación</th>                                        
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!isset($contactosx)) {
                                echo '<tr><td colspan=4><h1><center>Historial en Cero</center></h1></td></tr>';
                            } else {
                                echo '<h3><center>Historial de contacto</center></h3>';
                                foreach ($contactosx as $c) {
                                    echo"
                                    <tr>
                                    <td>" . $c['fecha'] . "</td>
                                    <td>" . $c['hora'] . "</td>
                                    <td>" . ($c['tipificacion']) . "</td>																														
                                    <td>" . ($c['observaciones']) . "</td>																														
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </form>
        </div>
        <hr>
        <script src="js/obj_ajax.js"></script>
        <script>
                            function getsearch(evt) {
                                var keyPressed = (evt.which) ? evt.which : event.keyCode;
                                if (keyPressed === 13) {
                                    var_numero = document.getElementById('cadena').value;
                                    searchdata(var_numero);
                                }
                            }

                            function SAVE() {
                                if (document.getElementById('actualiza1').checked) {
                                    actual = document.getElementById('actualiza1').value;
                                } else {
                                    actual = document.getElementById('actualiza0').value;
                                }
                                if (document.getElementById('OBSERVACION').value === '' && document.getElementById('finales').value === '5') {
                                    alert('¡ALERTA!.Falta la Observación');
                                } else if (document.getElementById('OBSERVACION').value === '' && document.getElementById('finales').value === '18') {
                                    alert('¡ALERTA!.Falta indicar el programa en Observación');
                                } else if (document.getElementById('finales').value === '9' &&
                                        document.getElementById('subfinales').value === '0') {
                                    alert('ALERTA!.Falta la Subtipificación');
                                } else if (document.getElementById('finales').value === '16' &&
                                        document.getElementById('subfinales').value === '0') {
                                    alert('ALERTA!.Falta la Subtipificación');
                                } else if (document.getElementById('finales').value === '17' &&
                                        document.getElementById('subfinales').value === '0') {
                                    alert('ALERTA!.Falta la Subtipificación');
                                } else if (document.getElementById('finales').value === '10' &&
                                        document.getElementById('subfinales').value === '0') {
                                    alert('ALERTA!.Falta la Subtipificación');
                                } else {
                                    cliente = document.getElementById('idcliente').value;
                                    finales = document.getElementById('finales').value;
                                    observacion = document.getElementById('OBSERVACION').value;
                                    usuario = document.getElementById('idusuario').value;
                                    sub_finales = document.getElementById('subfinales').value;
                                    agendar = document.getElementById('datepicker').value;
                                    proceso = document.getElementById('proceso').value;
                                    if (proceso === '1') {
                                        load_agendado(cliente, finales, observacion, usuario, sub_finales, agendar, actual, proceso);
                                    } else if (proceso === '2') {
                                        load_nuevo(cliente, finales, observacion, usuario, sub_finales, agendar, actual, proceso);
                                    } else {
                                        load_atendido(cliente, finales, observacion, usuario, sub_finales, agendar, actual, proceso);
                                    }
                                }
                            }
        </script>
        <script src="js/jquery-2.1.0.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script>
                            $(function () {
                                $("#datepicker").datepicker({dateFormat: "yy-mm-dd"});
                            });
                            $('#finales').change(function () {
                                var indice = $(this).val();
                                tipificacion(indice);
                                if (indice === '5') { // Llamar más tarde
                                    document.getElementById("actualiza0").disabled = true;
                                    document.getElementById("actualiza1").disabled = true;
                                    document.getElementById('OBSERVACION').disabled = false;
                                    document.getElementById('datepicker').disabled = false;
                                    document.getElementById('Divtiponointeresado').style.display = 'none';
                                } else if (indice === '9') { // No interesado
                                    document.getElementById("actualiza0").disabled = false;
                                    document.getElementById("actualiza1").disabled = false;
                                    document.getElementById('OBSERVACION').disabled = false;
                                    $('#subfinale').change(function () {
                                        var subtipi = $(this).val();
                                        if (subtipi === '13') {
                                            document.getElementById('OBSERVACION').disabled = false;
                                        } else {
                                            document.getElementById('OBSERVACION').disabled = true;
                                        }
                                    });
                                    document.getElementById('datepicker').disabled = true;
                                    document.getElementById('Divtiponointeresado').style.display = 'block';
                                } else if (indice === '10') { // Otras
                                    document.getElementById("actualiza0").disabled = false;
                                    document.getElementById("actualiza1").disabled = false;
                                    document.getElementById('OBSERVACION').disabled = true;
                                    document.getElementById('datepicker').disabled = true;
                                    document.getElementById('Divtiponointeresado').style.display = 'block';
                                } else if (indice === '14') { // Actualización
                                    document.getElementById("actualiza0").disabled = true;
                                    document.getElementById("actualiza1").disabled = true;
                                    document.getElementById('OBSERVACION').disabled = true;
                                    document.getElementById('datepicker').disabled = true;
                                    document.getElementById('Divtiponointeresado').style.display = 'none';
                                } else if (indice === '16') { // Calificado
                                    document.getElementById("actualiza0").disabled = false;
                                    document.getElementById("actualiza1").disabled = false;
                                    document.getElementById('OBSERVACION').disabled = true;
                                    document.getElementById('datepicker').disabled = true;
                                    document.getElementById('Divtiponointeresado').style.display = 'block';
                                } else if (indice === '17') { // Llamada fallida
                                    document.getElementById("actualiza0").disabled = true;
                                    document.getElementById("actualiza1").disabled = true;
                                    document.getElementById('datepicker').disabled = true;
                                    document.getElementById('OBSERVACION').disabled = true;
                                    document.getElementById('Divtiponointeresado').style.display = 'block';
                                } else if (indice === '18') { // Otro programa
                                    document.getElementById("actualiza0").disabled = false;
                                    document.getElementById("actualiza1").disabled = false;
                                    document.getElementById('OBSERVACION').disabled = false;
                                    document.getElementById('datepicker').disabled = true;
                                    document.getElementById('Divtiponointeresado').style.display = 'none';
                                } else if (indice === '21') { // Futuro EMBA
                                    document.getElementById("actualiza0").disabled = false;
                                    document.getElementById("actualiza1").disabled = false;
                                    document.getElementById('OBSERVACION').disabled = true;
                                    document.getElementById('datepicker').disabled = true;
                                    document.getElementById('Divtiponointeresado').style.display = 'none';
                                } else { // Otra tipificación futura sin control
                                    document.getElementById("actualiza0").disabled = false;
                                    document.getElementById("actualiza1").disabled = false;
                                    document.getElementById('OBSERVACION').disabled = false;
                                    document.getElementById('datepicker').disabled = false;
                                    document.getElementById('Divtiponointeresado').style.display = 'block';
                                }
                            });
        </script>
    </body>
</html>
