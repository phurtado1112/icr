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
                                        <a href="campania_lista.php">Campañas</a>
                                    </li>
                                    <li>
                                        <a href="asignacion_lista.php">Asignación Agente - Campaña</a>
                                    </li>
                                    <li>
                                        <a href="carga_contactos_campania.php">Carga de Contactos por Campaña</a>
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
                                        <a href="usuario_lista.php">Usuarios</a>
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
                                    <li>
                                        <a href="estado_cliente_lista.php">Estados de Clientes</a>
                                    </li>                                                                        
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Reportes<b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu3">                                    
                                    <li>
                                        <a href="rep_gestion_programa_form.php">Gestión por Campaña</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="rep_campania_form.php">Campañas</a>
                                    </li>
                                    <li>
                                        <a href="rep_estados_contacto_form.php">Estados de Contacto</a>
                                    </li>
                                    <li>
                                        <a href="rep_subtipificacion_form.php">Subtipificación</a>
                                    </li>
                                    <li>
                                        <a href="rep_tipificacion_form.php">Tipificación</a>
                                    </li>
                                    <li>
                                        <a href="rep_usuarios_form.php">Usuarios</a>
                                    </li>
                                    <li class="divider"></li>
                                    
                                    <li>
                                        <a href="rep_conectados_form.php">Conectados</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
