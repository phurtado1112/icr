<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="main.php">Panel de Administración</a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i><?php echo $_SESSION['nombre_usuario'] ?><i class="caret"></i></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="salir.php">Salir</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Procesos<b class="caret"></b></a>
                        <ul class="dropdown-menu" id="menu1">
                            <li>
                                <a href="asignacion_programa_lista.php">Asignación Campaña a Programa</a>
                            </li>
                            <li>
                                <a href="asignacion_lista.php">Asignación Asesor a Campaña</a>
                            </li>
                            <li>
                                <a href="importar_datos.php">Carga de Contactos por Campaña</a>
                            </li>                                    
                        </ul>
                    </li>                            
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Catálogos<b class="caret"></b></a>
                        <ul class="dropdown-menu" id="menu2">
                            <li>
                                <a href="noticias_lista.php">Noticias</a>
                            </li>
                            <li>
                                <a href="campania_lista.php">Campañas</a>
                            </li>
                            <li>
                                <a href="programa_lista.php">Programas</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="usuario_lista.php">Usuarios</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="pais_lista.php">Países</a>
                            </li>
                            <li>
                                <a href="tipificacion_lista.php">Tipificación de Respuestas</a>
                            </li>
                            <li>
                                <a href="subtipificacion_lista.php">Subtipificación de Respuestas</a>
                            </li>
                            <li>
                                <a href="estado_conectado_lista.php">Estados de Usuario Conectados</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="contactos.php">Leads por campaña</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Reportes<b class="caret"></b></a>
                        <ul class="dropdown-menu" id="menu3">                                    
                            <li>
                                <a href="rep_gestion_campania_form.php">Gestión de Asesor por Campaña</a>
                            </li>
                            <li>
                                <a href="rep_gestion_de_campania_program_form.php">Gestión Total de Programa</a>
                            </li>
                            <li>
                                <a href="rep_gestion_de_campania_detallado_campania_form.php">Gestión Detallada de Programa por Campañas</a>
                            </li>
                            <li>
                                <a href="rep_gestion_de_campania_detallado_asesor_form.php">Gestión Detallada de Programa por Asesor</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="rep_actualizacion_program_form.php">Actualización de Contactos Total de Programa</a>
                            </li>
                            <li>
                                <a href="rep_actualizacion_detallado_campania_form.php">Actualización de Contactos Detallada de Programa por Campaña</a>
                            </li>
                            <li>
                                <a href="rep_actualizacion_detallado_asesor_form.php">Actualización de Contactos Detallada de Programa por Asesor</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="rep_campanias_x_asesor_form.php">Campañas asignadas a Asesor</a>
                            </li>
<!--                            <li>
                                <a href="rep_contactos _x_campanias_x_asesor_form.php">Contactos de Campaña por Asesor</a>
                            </li>-->
<!--                            <li>
                                <a href="rep_campanias_x_asesor_form.php">Desempeño por Asesor por Programa</a>
                            </li>-->
                            <li class="divider"></li>
                            <li>
                                <a href="rep_campanias_form.php">Campañas</a>
                            </li>
<!--                            <li>
                                <a href="rep_estados_contacto_form.php">Estados de Contacto</a>
                            </li>-->
                            <li>
                                <a href="rep_subtipificacion_form.php">Subtipificación</a>
                            </li>
                            <li>
                                <a href="rep_tipificacion_form.php">Tipificación</a>
                            </li>
                            <li>
                                <a href="rep_usuario_form.php">Usuarios</a>
                            </li>
                            <li class="divider"></li>

                            <li>
                                <a href="rep_usuarios_conectados_form.php">Usuarios Conectados</a>
                            </li>
                            <li>
                                <a href="rep_estados_asesor_form.php">Actividad de Asesor</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
