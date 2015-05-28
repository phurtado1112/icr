<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
alert("usuario no autenticado")
self.location = "index.php"
</script>';
}

$idclien = filter_input(INPUT_GET, 'idcliente');

$consulta_cliente = "SELECT * FROM transacciones_view WHERE idcliente=" . $idclien;
$lista_clientes = bd_ejecutar_sql($consulta_ctes);
while ($filax = bd_obtener_fila($lista_clientes)) {
    $contactosx[] = $filax;
}

$idasignar = $_SESSION['idasignar'];

$consulta_cte = "SELECT * FROM clientes WHERE idasignar='" . $idasignar . "'AND idcliente=" . $idclient;
$lista_clien = bd_ejecutar_sql($consulta_cte);
while ($filas = bd_obtener_fila($lista_clien)) {
    $idcliente = $filas['idcliente'];
    $nombre = $filas['nombre'];
    $telfijo = $filas['telfijo'];
    $email = $filas['email'];
    $celular = $filas['telmovil'];
    $telofi = $filas['teltrabajo'];
    $cargo = $filas['cargo'];
    $empresa = $filas['empresa'];
}

$atendido = "SELECT count(*) as conteo FROM clientes WHERE idasignar='" . $idasignar . "'AND idestado='1'";
$lista_atendidos = bd_ejecutar_sql($atendido);
while ($filaat = bd_obtener_fila($lista_atendidos)) {
    $var_atendido = $filaat['conteo'];
}

$noatendido = "SELECT count(*) as conteo FROM clientes WHERE idasignar='" . $idasignar . "'";
$lista_noatendidos = bd_ejecutar_sql($noatendido);
while ($filanoat = bd_obtener_fila($lista_noatendidos)) {
    $var_no_atendido = $filanoat['conteo'];
}

$consulta_camp = "SELECT * FROM campanias where idcampania=" . $_SESSION['idcampania'];
$lista_campania = bd_ejecutar_sql($consulta_camp);
while ($filacam = bd_obtener_fila($lista_campania)) {
    $var_camp_nombre = $filacam['campania'];
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>INCAE</title>
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">  
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/jquery-ui.css" rel="stylesheet">
        <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
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
                        <tr bgcolor="#00CC66">
                            <td><strong>Cliente:</strong></td>
                            <td><strong>Teléfono:</strong></td>
                            <td><strong>Email:</strong></td>
                            <td><strong>Celular:</strong></td>
                            <td><strong>Teléfono Oficina:</strong></td>
                            <td><strong>Cargo:</strong> </td>
                            <td><strong>Empresa:</strong> </td>
                        </tr>
                        <tr>
                            <td><?php echo $nombre ?></td>
                            <td><?php echo $telfijo ?></td>
                            <td><?php echo $email ?></td>
                            <td><?php echo $celular ?></td>
                            <td><?php echo $telofi ?></td>
                            <td><?php echo $cargo ?></td>
                            <td><?php echo $empresa ?></td>
                        </tr>
                    </table>
                    <br><br>
                    <div class="row-fluid">
                        <div class="span6 offset3 well">
                            <div class="row-fluid">
                                <div class="row-fluid">
                                    <div class="block-content">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Tipificación:</th>
                                                <td>
                                                    <?php
                                                    $consulta_tipi = "select * from tipificacion where activo=0";
                                                    $lista_tipi = bd_ejecutar_sql($consulta_tipi);
                                                    ?>
                                                    <select name="finales" id="finales" onChange="tipificacion(this.value)" >
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
                                                    <textarea name="observacion" id="OBSERVACION" style="width: 480px; height: 70px;" ></textarea>
                                                </td>
                                            </tr>     
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <input type="button" value="Guardar" onClick="SAVE()" class="btn btn-success" />
                        <button type="reset" class="btn btn-success" onclick="location.href = 'cliente_contacto_agendado.php'">Cancelar</button>
                    </div>
                    <br><br>
                    <table class="table table-hover">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>                    
                            <th>Tipificación</th>                    
                            <th>Observación</th>                                        
                        </tr>
                        <?php
                        if (!isset($contactosx)) {
                            echo '<table><tr><th><h1><center>Historial en Cero</center></h1><th><tr><table>';
                        } else {
                            echo '<h3><center>Historial de contacto</center></h3>';
                            foreach ($contactosx as $c) {
                                echo"
						<tr>
						<td>" . $c['fecha'] . "</td>
						<td>" . $c['hora'] . "</td>
						<td>" . $c['tipificacion'] . "</td>
						<td>" . $c['observaciones'] . "</td>																														
						</tr>";
                            }
                        }
                        ?>
                    </table>
                </fieldset>
            </form>
        </div>
        <hr>

        <footer> </footer>

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
                                    load(cliente, finales, observacion, usuario, sub_finales, agendar, actual);
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

                                if (indice === '14') {
                                    $('#actualiza').prop('disabled', true);
                                } else {
                                    $('#actualiza').prop('disabled', false);
                                }
                            });
        </script>
    </body>
</html>
