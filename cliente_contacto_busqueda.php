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
            $busqueda = "SELECT * FROM clientes WHERE nombre LIKE '%" . $cadena . "%' and idasignar='" . $idasignar . "' and agendado=0 ORDER BY clientes.prioridad";
            break;
        case 3:
            $busqueda = "SELECT * FROM clientes WHERE cargo LIKE '%" . $cadena . "%' and idasignar='" . $idasignar . "' and agendado=0 ORDER BY clientes.prioridad";
            break;
        case 4:
            $busqueda = "SELECT * FROM clientes WHERE empresa LIKE '%" . $cadena . "%' and idasignar='" . $idasignar . "' and agendado=0 ORDER BY clientes.prioridad";
            break;
        case 5:
            $busqueda = "SELECT * FROM clientes WHERE email LIKE '%" . $cadena . "%' and idasignar='" . $idasignar . "' and agendado=0 ORDER BY clientes.prioridad";
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
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Celular</th>
                <th>Tel. oficina</th>
                <th>Correo</th>
                <th>Empresa</th>
                <th>Cargo</th>
                <th>Acción</th>                                                            
            </tr>
            <?php
            foreach ($contactos as $c) {
                $ids = $c['idcliente'];
                if ($c['idestado'] == '0') {
                    switch ($c['prioridad']) {
                        case '2':
                            echo"
                                <tr>
                                <td><font color='#094AB2'><strong>" . ($c['nombre']) . "</td>
                                <td ><font color='#094AB2'><strong>" . ($c['telfijo']) . "</td>
                                <td ><font color='#094AB2'><strong>" . ($c['telmovil']) . "</td>
                                <td ><font color='#094AB2'><strong>" . ($c['teltrabajo']) . "</td>
                                <td ><font color='#094AB2'><strong>" . ($c['email']) . "</td>
                                <td ><font color='#094AB2'><strong>" . ($c['empresa']) . "</td>						
                                <td ><font color='#094AB2'><strong>" . ($c['cargo']) . "</td>
                                <td >" . '<a href="cliente.php?idcliente=' . $ids . '">Gestionar</a>' . "</strong></td>
                                </tr";
                            break;
                        case '1':
                            echo"
                                <tr>
                                <td><font color='#008A00'><strong>" . ($c['nombre']) . "</td>
                                <td ><font color='#008A00'><strong>" . ($c['telfijo']) . "</td>
                                <td ><font color='#008A00'><strong>" . ($c['telmovil']) . "</td>
                                <td ><font color='#008A00'><strong>" . ($c['teltrabajo']) . "</td>
                                <td ><font color='#008A00'><strong>" . ($c['email']) . "</td>    
                                <td ><font color='#008A00'><strong>" . ($c['empresa']) . "</td>					
                                <td ><font color='#008A00'><strong>" . ($c['cargo']) . "</td>
                                <td >" . '<a href="cliente.php?idcliente=' . $ids . '">Gestionar</a>' . "</strong></td>
                                </tr";
                            break;
                        case '0':
                            echo"
                                <tr>
                                <td>" . ($c['nombre']) . "</td>
                                <td >" . ($c['telfijo']) . "</td>
                                <td >" . ($c['telmovil']) . "</td>
                                <td >" . ($c['teltrabajo']) . "</td>
                                <td >" . ($c['email']) . "</td>    
                                <td >" . ($c['empresa']) . "</td>						
                                <td >" . ($c['cargo']) . "</td>
                                <td >" . '<a href="cliente.php?idcliente=' . $ids . '">Gestionar</a>' . "</strong></td>
                                </tr";
                            break;
                    }
                }
            }
        }
        ?>
    </table>    
</center>