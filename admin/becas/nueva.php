<?php
include_once("../../includes/clases/class_lib.php");
$tipos = Beca::getTipos();
@session_start();
$id_colegio = $_SESSION['id_colegio'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>Sistema Integral MEZE - Nueva Beca</title>
    

	<!-- lib-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic">
   
    <!-- Theme-->
    <!-- Concat all lib & plugins css-->
    <link id="mainstyle" rel="stylesheet" href="../../assets/stylesheets/theme-libs-plugins.css">
    <link id="mainstyle" rel="stylesheet" href="../../assets/stylesheets/skin.css">

    <!-- Demo only-->
    <link id="mainstyle" rel="stylesheet" href="../../assets/stylesheets/demo.css">

    <!-- This page only-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries--><!--[if lt IE 9]>
    <script src="assets/scripts/lib/html5shiv.js"></script>
    <script src="assets/scripts/lib/respond.js"></script><![endif]-->
    <script src="../../assets/scripts/lib/modernizr-custom.js"></script>
    <script src="../../assets/scripts/lib/respond.js"></script>
		
		<script src="../../plugins/assets/js/appear.min.js" type="text/javascript"></script>
		<script src="../../plugins/assets/js/animations.js" type="text/javascript"></script>
        
		<link rel="stylesheet" href="../../estilo/general.css" />
        <link rel="stylesheet" href="../../estilo/formas.css" />
        <link rel="stylesheet" href="../../estilo/buscadorAjax.css" />
        
        <style>
            #buscador_alumnos
            {
                width: 450px;
                border: 1px solid #CCC;
                background-color: #FFF;
                display: none;
                position: fixed;
                top: 150px;
                left: 200px;
            }
        </style>
        
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
		<script src="../../librerias/jquery.dataTables.min.js" ></script>
        <script src="../../librerias/messages_es.js"></script>
        <script>
            var tablaHistorialBecas;

            $(document).ready(function ()
            {
                $(".buscadorAjax").draggable({ handle: ".buscadorAjax_barra" });
                asignarReglasValidacion();
                declararDataTable();
                loadSubtipos();
            });

            function declararDataTable()
            {
                tablaHistorialBecas = $('#historia_becas_alumno').dataTable({
                    "oLanguage": {
                        "sLengthMenu": "Mostrar _MENU_ ciclos escolares por página",
                        "sZeroRecords": "El alumno nunca a estado becado",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ ciclos escolares con beca",
                        "sInfoEmpty": "Mostrando 0 a 0 de 0 ciclos escolares con beca",
                        "sInfoFiltered": "(Encontrados de _MAX_ ciclos escolares con beca)"
                    }
                });
            }

            function asignarReglasValidacion()
            {
                $('#forma_nueva_beca').validate({
                    rules:
                    {
                        "alumnoVal": { required: true },
                        "becaVal": { required: true, number: true, range: [1, 100] }
                    }
                })
            }

            function buscarAlumno()
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/buscar_alumnos.php",
                    data: "parametro=" + $("#parametroVal").val(),
                    success: function (data)
                    {
                        $("#buscador_alumnos_tabla").html(data);
                    }
                });
            }

            function toggleBuscadorAlumno()
            {
                $("#buscador_alumnos").fadeIn();
            }

            function cargarInfoAlumno(id_alumno)
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/getAlumnoJSON.php",
                    data: "id_alumno=" + id_alumno,
                    async: true,
                    success: function (data)
                    {
                        if (data != "error")
                        {
                            alumno = jQuery.parseJSON(data);
                            $("#id_alumnoVal").val(alumno.id_persona);
                            $("#alumnoVal").val(alumno.apellido_paterno + " " + alumno.apellido_materno + " " + alumno.nombres);
                        }
                    }
                });
            }

            function cargarTablaBecas(id_alumno)
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/print_tabla_becas.php",
                    data: "id_alumno=" + id_alumno,
                    success: function (data)
                    {
                        if (data != "error")
                        {
                            tablaHistorialBecas.fnDestroy();
                            $("#historia_becas_alumno tbody").html(data);
                            declararDataTable();
                        }
                    }
                });
            }

            function seleccionarAlumno(id_alumno)
            {
                cargarInfoAlumno(id_alumno);
                cargarTablaBecas(id_alumno);
                $("#buscador_alumnos").fadeOut();
            }

            function loadSubtipos()
            {
                var id_tipo = $("#tipoVal").val();
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/becas/load_subtipos.php",
                    data: "id_tipo=" + id_tipo,
                    success: function (data)
                    {
                        $("#subtipoVal").html(data);
                    }
                });
            }
        </script>
		 
    </head>
   <body class="stellar">

    <!-- #SIDEMENU-->
    <div class="mainmenu-block">
      <!-- SITE MAINMENU-->
      <nav class="menu-block">
        <ul class="nav">
          <li class="nav-item mainmenu-user-profile"><a href="#">
              <div class="circle-box"><img src="../../media/fotos/photo_NA.jpg" alt="">
                <div class="dot dot-success"></div>
              </div>
              <div class="menu-block-label"><b><?php if(isset($_SESSION['nombres'])) echo $_SESSION['nombres'] ; ?></b>
			  <br>Administrador
			  </div></a></li>
        </ul>
       
        <ul class="nav">
          <li class="nav-item"><a href="../../index.php" class="nav-link"> <i class="icon ion-home"></i>
              <div class="menu-block-label">
                 Inicio
              </div></a></li>
         
          <!--li.header colegios-->
          <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-stats-bars"></i>
              <div class="menu-block-label">Estadisticas</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../estadisticas/stats.php" class="nav-link">Personal</a></li>
              <li class="nav-item"><a href="../estadisticas/cuentas.php" class="nav-link">Cuentas</a></li>
            </ul>
          </li>
          <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-ios-clock-outline"></i>
              <div class="menu-block-label">Ciclos</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../ciclos_escolares/index.php" class="nav-link">Lista</a></li>
              <li class="nav-item"><a href="../ciclos_escolares/nuevo.php" class="nav-link">Nuevo</a></li>
            </ul>
          </li>
          <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-ios-body"></i>
              <div class="menu-block-label">Alumnos</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../alumnos/index.php" class="nav-link">Todos</a></li>
              <li class="nav-item"><a href="../alumnos/alumnos_inscritos.php" class="nav-link">Inscritos</a></li>
			  <li class="nav-item"><a href="../alumnos/inscribir.php" class="nav-link">Inscribir</a></li>
			  <li class="nav-item"><a href="../alumnos/reinscribir.php" class="nav-link">Reinscribir</a></li>
			  <li class="nav-item"><a href="../tareas/asignar.php" class="nav-link">Asignar Tareas</a></li>
            </ul>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-ios-people"></i>
              <div class="menu-block-label">Maestros</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../maestros/index.php" class="nav-link">Todos</a></li>
              <li class="nav-item"><a href="../maestros/nuevo.php" class="nav-link">Nuevos</a></li>
			  <li class="nav-item"><a href="../maestros/maestros_actuales.php" class="nav-link">Vigentes</a></li>
			  <li class="nav-item"><a href="../maestros/asistencia.php" class="nav-link">Asistencias</a></li>
            </ul>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-gear-b"></i>
              <div class="menu-block-label">Admin</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../administradores/index.php" class="nav-link">Ver Todos</a></li>
              <li class="nav-item"><a href="../administradores/nuevo.php" class="nav-link">Nuevo</a></li>
            </ul>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-university"></i>
              <div class="menu-block-label">Becas</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../becas/lista.php" class="nav-link">Listas</a></li>
              <li class="nav-item"><a href="../becas/nueva.php" class="nav-link">Nuevas</a></li>
			  <li class="nav-item"><a href="../becas/tipos.php" class="nav-link">Tipos</a></li>
            </ul>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-arrow-graph-up-right"></i>
              <div class="menu-block-label">Grados</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../grados/index.php" class="nav-link">Lista</a></li>
              <li class="nav-item"><a href="../grados/nuevo.php" class="nav-link">Nuevo</a></li>
            </ul>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="../grupos/index.php" class="nav-link"> <i class="icon ion-university"></i>
              <div class="menu-block-label">Grupos</div></a>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="../materias/index.php" class="nav-link"> <i class="icon ion-ios-book"></i>
              <div class="menu-block-label">Materias</div></a>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-cash"></i>
              <div class="menu-block-label">Cuentas</div></a>
              <ul class="nav menu-block-sub">
              <li class="nav-item menu-block-has-sub"><a href="#" class="nav-link">Pagos</a>
			  <ul class="nav menu-block-sub">
			   <li class="nav-item"><a href="../cuentas/pagos/inscripcion.php" class="nav-link">Inscripci&oacute;n</a></li>
			   <li class="nav-item"><a href="../cuentas/pagos/colegiaturas.php" class="nav-link">Colegiaturas</a></li>
			   <li class="nav-item"><a href="../cuentas/pagos/cuotas.php" class="nav-link">Cuotas</a></li>
			  </ul>
			  </li>
              <li class="nav-item menu-block-has-sub"><a href="#" class="nav-link">Descuentos</a>
			  <ul class="nav menu-block-sub">
			   <li class="nav-item"><a href="../cuentas/descuentos/lista.php" class="nav-link">Lista</a></li>
			   <li class="nav-item"><a href="../cuentas/descuentos.php" class="nav-link">Nuevos</a></li>
			  </ul>
			  </li>
			  <li class="nav-item"><a href="../cuentas/recibos.php" class="nav-link">Recibos</a></li>
              </ul>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-settings"></i>
              <div class="menu-block-label">Config.</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../configuracion/clubs/index.php" class="nav-link">Club</a></li>
              <li class="nav-item"><a href="../configuracion/colonias/index.php" class="nav-link">Colonias</a></li>
			  <li class="nav-item"><a href="../configuracion/papeleria/index.php" class="nav-link">Papeleria</a></li>
			  <li class="nav-item"><a href="../configuracion/ocupaciones/index.php" class="nav-link">Ocupaciones</a></li>
			  <li class="nav-item"><a href="../configuracion/cuentas_dinamicas/index.php" class="nav-link">Cuentas Dinamicas</a></li>
            </ul>
          </li>
        </ul>
        <!-- END SITE MAINMENU-->
      </nav>
    </div>

    <!-- #MAIN-->
    <div class="main-wrapper">

      <!-- VIEW WRAPPER-->
      <div class="view-wrapper">

        <!-- TOP WRAPPER-->
        <div class="topbar-wrapper">

          <!-- NAV FOR MOBILE-->
          <div class="topbar-wrapper-mobile-nav"><a href="#" class="topbar-togger js-minibar-toggler"><i class="icon ion-ios-arrow-back hidden-md-down"></i><i class="icon ion-navicon-round hidden-lg-up"></i></a><a href="#" class="topbar-togger pull-xs-right hidden-lg-up js-nav-toggler"><i class="icon ion-android-person"></i></a>

            <!-- ADD YOUR LOGO HEREText logo: a.topbar-wrapper-logo(href="#") AdminHero
            --><a href="index.php" class="topbar-wrapper-logo demo-logo">Colegio MEZE</a>
          </div>
          <!-- END NAV FOR MOBILE-->

          <!-- SEARCH-->
          <div class="topbar-wrapper-search">
            <form>
              <input type="search" placeholder="Search" class="form-control"><a href="#" class="topbar-togger topbar-togger-search js-close-search"><i class="icon ion-close"></i></a>
            </form>
          </div>
          <!-- END SEARCH-->

          <!-- TOP RIGHT MENU-->
          <ul class="nav navbar-nav topbar-wrapper-nav">
            <li class="nav-item"><a href="#" class="nav-link js-search-togger"><i class="icon ion-ios-search-strong"></i></a></li>

            
            <li class="nav-item dropdown"><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="nav-link"><i class="icon ion-paintbucket"></i></a>
              <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg"> 
                <div class="js-color-switcher demo-color-switcher">
                  <div class="dropdown-header">Flat</div>
                  <div class="list-inline"><a href="#" data-color="f-dark" class="list-inline-item">
                      <div class="demo-skin-grid f-dark"></div></a><a href="#" data-color="f-dark-blue" class="list-inline-item">
                      <div class="demo-skin-grid f-dark-blue"></div></a><a href="#" data-color="f-blue" class="list-inline-item">
                      <div class="demo-skin-grid f-blue"></div></a><a href="#" data-color="f-green" class="list-inline-item">
                      <div class="demo-skin-grid f-green"></div></a>
                  </div>
                  <div class="dropdown-header">Gradient</div>
                  <div class="list-inline"><a href="#" data-color="orchid" class="list-inline-item">
                      <div class="demo-skin-grid orchid"></div></a><a href="#" data-color="cadetblue" class="list-inline-item">
                      <div class="demo-skin-grid cadetblue"></div></a><a href="#" data-color="joomla" class="list-inline-item">
                      <div class="demo-skin-grid joomla"></div></a><a href="#" data-color="influenza" class="list-inline-item">
                      <div class="demo-skin-grid influenza"></div></a><a href="#" data-color="moss" class="list-inline-item">
                      <div class="demo-skin-grid moss"></div></a><a href="#" data-color="mirage" class="list-inline-item">
                      <div class="demo-skin-grid mirage"></div></a><a href="#" data-color="stellar" class="list-inline-item">
                      <div class="demo-skin-grid stellar"></div></a><a href="#" data-color="servquick" class="list-inline-item">
                      <div class="demo-skin-grid servquick"></div></a>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item"><a href="../../login.php" class="nav-link"><i class="icon ion-android-exit"></i></a></li>
           
          
            
           <li class="nav-item"><a href="../../login.php" class="nav-link close-mobile-nav js-close-mobile-nav"><i class="icon ion-close"></i></a></li>
            <!-- END TOP RIGHT MENU-->
          </ul>
        </div>
        <!--END TOP WRAPPER-->


        <!-- PAGE CONTENT HERE-->
        <!-- #PAGE HEADER-->
        <!-- PAGE HEADER-->
        <div class="page-header">
          <div class="row">
            <div class="col-md-4">
              <div class="media">
                <div class="media-body">
                  <div class="display-6">Asignar Beca</div>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <!-- #TABLE-->
        <div class="container-fluid">
          <div class="panel-wrapper">
            <div class="panel">
              <div class="panel-body">
        		<div id="area_trabajo">
                    <h2>Asignar beca</h2>
                    <form id="forma_nueva_beca" action="../../includes/acciones/alumnos/asignar_beca.php" method="post" onsubmit='return confirm("¿Los datos están correctos?");' >
                        <div class="form_row_2">
                            <input type="hidden" name="id_alumnoVal" id="id_alumnoVal" />
                            <label class="form_label" for="alumnoVal">Alumno</label>
                            <input type="text" name="alumnoVal" id="alumnoVal" class="form_input" ondblclick="toggleBuscadorAlumno()" readonly="readonly" />
                        </div>
                        <div class="form_row_2">
                            <label class="form_label" for="becaVal">% Beca</label>
                            <input class="form_input" type="text" name="becaVal" id="becaVal" required />
                        </div>
                        <div class="form_row_2">
                            <label class="form_label" for="cicloVal">Ciclo escolar</label>
                            <select class="form_input" name="cicloVal" id="cicloVal">
                                <?php
                                    $ciclos = CicloEscolar::getListaProximos($id_colegio);
                                    if(is_array($ciclos))
                                    {
                                        foreach($ciclos as $ciclo)
                                        {
                                            echo "<option value='".$ciclo['id_ciclo_escolar']."'>".$ciclo['ciclo']."</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form_row_2">
                            <label class="form_label" for="tipoVal">Tipo</label>
                            <select class="form_input" name="tipoVal" id="tipoVal" required onchange="loadSubtipos();" >
                                <?php
                                if(is_array($tipos))
                                {
                                    foreach($tipos as $tipo)
                                    {
                                        echo "<option value='".$tipo['id_tipo_beca']."' >".$tipo['tipo_beca']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form_row_2">
                            <label class="form_label" for="subtipoVal">Sub tipo</label>
                            <select class="form_input" name="subtipoVal" id="subtipoVal" required >
                            </select>
							
                        </div>

                        <table id="historia_becas_alumno" class="table" data-plugin="DataTable">
                            <thead>
                                <tr>
                                    <th>Ciclo escolar</th>
                                    <th>Usuario</th>
                                    <th>% Beca</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- AJAX -->
                            </tbody>
                        </table>

                        <?
                            switch($error)
                            {
                                case 1: echo ""; break;
                                case 2: echo ""; break;
                                default: break;
                            }
                        ?>
                        <div class="form_row">
                            <input id="boton_aceptar" class="form_submit btn btn-primary" type="submit" value="Aceptar"/>
                        </div>
                    </form>

                    <div id="buscador_alumnos" class="buscadorAjax">
                        <div class="buscadorAjax_barra">
                            <img src='../../media/iconos/icon_close.gif' alt="Cerrar" onclick="$(this).parent().parent().fadeOut()" />
                        </div>
                        <div class="buscadorAjax_top">
                            <label class="buscadorAjax_top_label">Parametro: </label>
                            <input class="buscadorAjax_top_input" type="text" id="parametroVal" />
                            <input class="buscadorAjax_top_boton" type="button" onclick="buscarAlumno()" value="Buscar" />
                        </div>
                        <div class="buscadorAjax_contenedor_tabla table-responsive">
                            <table id="buscador_alumnos_tabla" class="buscadorAjax_tabla tabe">
                                <!-- Buscador AJAX -->
                            </table>
                        </div>
                    </div>
                    
                </div><!--area_trabajo-->
				
	</div>
              </div>
          </div>
        </div>
        <!-- END PAGE CONTENT-->

      </div>
      <!-- END VIEW WAPPER-->

    </div>
    <!-- END MAIN WRAPPER-->


    <!-- WEB PERLOAD-->
    <div id="preload">
      <ul class="loading">
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>



    <!-- Lib -->
    
    <script src="../../assets/scripts/lib/jquery-ui.js"></script>
    <script src="../../assets/scripts/lib/tether.min.js"></script>

    <!-- Theme js-->
    <!-- Concat all plugins js-->
    <script src="../../assets/scripts/theme/theme-plugins.js"></script>
    <script src="../../assets/scripts/theme/main.js"></script>
    <!-- Below js just for this demo only-->
    <script src="../../assets/scripts/demo/demo-skin.js"></script>
    <script src="../../assets/scripts/demo/bar-chart-menublock.js"></script>

    <!-- Below js just for this page only-->

    </body>
</html>