<?php
include_once './funciones.general.php';

if (!$_SESSION) {
    echo '<script language = javascript>
	alert("usuario no autenticado")
	self.location = "index.html"
	</script>';
}
$idcampania = $_SESSION['idcampania'];
$idasignar = $_SESSION['idasignar'];
$opcion = filter_input(INPUT_POST, 'ajxopcion');
$cadena = filter_input(INPUT_POST, 'ajxcadena');

error_reporting(0);

if (isset($opcion)) {
    switch ($opcion) {
        case 0:
            $busqueda = "SELECT * FROM clientes WHERE idcampania='" . $idasignar . "' and agendado=0 ORDER BY clientes.prioridad";
            break;
        case 2:
            $busqueda = "SELECT * FROM clientes_busqueda_view WHERE nombre LIKE '%" . $cadena . "%' and idasignar='" . $idasignar . "' and agendado=0 ORDER BY prioridad";
            break;
        case 3:
            $busqueda = "SELECT * FROM clientes_busqueda_view WHERE cargo LIKE '%" . $cadena . "%' and idasignar='" . $idasignar . "' and agendado=0 ORDER BY prioridad";
            break;
        case 4:
            $busqueda = "SELECT * FROM clientes_busqueda_view WHERE empresa LIKE '%" . $cadena . "%' and idasignar='" . $idasignar . "' and agendado=0 ORDER BY prioridad";
            break;
        case 5:
            $busqueda = "SELECT * FROM clientes_busqueda_view WHERE email LIKE '%" . $cadena . "%' and idasignar='" . $idasignar . "' and agendado=0 ORDER BY prioridad";
            break;
        case 6:
            $busqueda = "SELECT * FROM clientes_busqueda_view WHERE pais LIKE '%" . $cadena . "%' and idasignar='" . $idasignar . "' and agendado=0 ORDER BY prioridad";
            break;
    }

    $lista_contactos_campania = bd_ejecutar_sql($busqueda);
    while ($fila = bd_obtener_fila($lista_contactos_campania)) {
        $contactos[] = $fila;
    }
}
?>
<center>
    <table class="table table-hover">
        <?php
        if (!isset($contactos)) {
            echo '<table><tr><th><h3><center>Sin resultado</center></h3><th><tr><table>';
        } else {
            ?>
            <tr>
                <th>No.</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Celular</th>
                <th>Tel. oficina</th>
                <th>Correo</th>
                <th>Empresa</th>
                <th>Cargo</th>
                <th>País</th>
                <th>Acción</th>                                                            
            </tr>
            <?php
            $i=1;
            foreach ($contactos as $c) {
                $ids = $c['idcliente'];
                if ($c['idestado'] == '0') {
                    switch ($c['prioridad']) {
                        case 2:
                            echo"
                                <tr>
                                    <td id='td2'><b>" . $i . "</b></td>
                                    <td id='td2'>" . ($c['nombre']) . "</td>
                                    <td id='td2'>" . ($c['telfijo']) . "</td>
                                    <td id='td2'>" . ($c['telmovil']) . "</td>
                                    <td id='td2'>" . ($c['teltrabajo']) . "</td>
                                    <td id='td2'>" . ($c['email']) . "</td>
                                    <td id='td2'>" . ($c['empresa']) . "</td>						
                                    <td id='td2'>" . ($c['cargo']) . "</td>
                                    <td id='td2'>" . ($c['pais']) . "</td>
                                    <td>" . '<a href="cliente.php?idcliente=' . $ids . '">Gestionar</a>' . "</strong></td>
                                </tr>";
                            break;
                        case 1:
                            echo"
                                <tr>
                                    <td id='td1'><b>" . $i . "</b></td>
                                    <td id='td1'>" . ($c['nombre']) . "</td>
                                    <td id='td1'>" . ($c['telfijo']) . "</td>
                                    <td id='td1'>" . ($c['telmovil']) . "</td>
                                    <td id='td1'>" . ($c['teltrabajo']) . "</td>
                                    <td id='td1'>" . ($c['email']) . "</td>    
                                    <td id='td1'>" . ($c['empresa']) . "</td>					
                                    <td id='td1'>" . ($c['cargo']) . "</td>
                                    <td id='td1'>" . ($c['pais']) . "</td>
                                    <td>" . '<a href="cliente.php?idcliente=' . $ids . '">Gestionar</a>' . "</strong></td>
                                </tr>";
                            break;
                        case 0:
                            echo"
                                <tr>
                                    <td id='td0'><b>" . $i . "</b></td>
                                    <td id='td0'>" . ($c['nombre']) . "</td>
                                    <td id='td0'>" . ($c['telfijo']) . "</td>
                                    <td id='td0'>" . ($c['telmovil']) . "</td>
                                    <td id='td0'>" . ($c['teltrabajo']) . "</td>
                                    <td id='td0'>" . ($c['email']) . "</td>    
                                    <td id='td0'>" . ($c['empresa']) . "</td>						
                                    <td id='td0'>" . ($c['cargo']) . "</td>
                                    <td id='td0'>" . ($c['pais']) . "</td>
                                    <td>" . '<a href="cliente.php?idcliente=' . $ids . '">Gestionar</a>' . "</strong></td>
                                </tr>";
                            break;
                    }
                    $i = $i + 1;
                }
            }
        }
        ?>
    </table>    
</center>