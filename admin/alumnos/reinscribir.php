<?php
$id_modulo = 7; // Alumnos - Inscribir
include_once("../../includes/clases/class_lib.php");
//include_once("../../includes/validar_acceso.php");
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$tipos_tutor = Tutor::getTipos();
$ciclo      = CicloEscolar::getActual($id_colegio);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8" />
    <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>Sistema Integral MEZE - Reinscribir Alumno</title>
    

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
		
        <link rel="stylesheet" href="../../estilo/general.css" />
        <link rel="stylesheet" href="../../estilo/formas_extensas.css" />
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

            #div_nuevo_grupo
            {
                display: none;
                overflow: auto;
                width: 100%;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="../../librerias/messages_es.js"></script>
        <script>
            $(document).ready(function ()
            {
                $(".buscadorAjax").draggable({ handle: ".buscadorAjax_barra" });
            });

            function toggleBuscador()
            {
                $("#buscador_alumnos").fadeIn();
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

            function seleccionarAlumno(id_alumno)
            {
                cargarInfoAlumno(id_alumno);
                $("#buscador_alumnos").fadeOut();
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
                            var alumno = jQuery.parseJSON(data);
                            $("#id_alumno_val").val(alumno.id_alumno);
                            $("#nombres_val").val(alumno.nombres);
                            $("#paterno_val").val(alumno.apellido_paterno);
                            $("#materno_val").val(alumno.apellido_materno);
                            $("#div_nuevo_grupo").fadeIn();
                        }
                    }
                });
            }

            function loadGrados()
            {
                var id_area = $("#areaVal").val();
				$.post("../../includes/acciones/grados/print_select_grados.php", { id_area: id_area }, function (data)
                {
                    $("#gradoVal").html(data);
                    loadGrupos();
                });
            }

            function loadGrupos()
            {
                var id_grado = $("#gradoVal").val();
				var id_ciclo = <?php echo $ciclo->id_ciclo_escolar ?>;
                $.post("../../includes/acciones/grupos/print_select_grupos.php", {id_ciclo: id_ciclo, id_grado: id_grado }, function (data)
                {
                    $("#grupoVal").html(data);
                });
            }

            function reinscribir()
            {
                if(confirm("¿Desea reinscribir al alumno al grupo seleccionado?"))
                {
                    $("#boton_reinscribir").attr('disabled','disabled');
                    var id_alumno = $("#id_alumno_val").val();
                    var id_grupo = $("#grupoVal").val();
                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/alumnos/reinscribir.php",
                        data: "id_alumno=" + id_alumno + "&id_grupo=" + id_grupo,
                        success: function (data)
                        {
                            if(data == 1)
                            {
                                alert("Alumno reiscrito");
                                window.location.href = "index.php";
                            }
                        }
                    });
                }
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
         
          <!--li.header administradores-->
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
                  <div class="display-6">Reinscribir Alumno</div>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
        
        <div class="container-fluid">
          <div class="panel-wrapper">
            <div class="panel">
              <div class="panel-body">
           	<div id="principal" >
        		<div id="area_trabajo">
                    
                    <button onclick="toggleBuscador();" class="btn btn-warning"><span class="glyphicon glyphicon-search"></span> Buscar</button>
                    <br />

                    <input type="hidden" id="id_alumno_val" />
                    <div class="row">
                    <div class="form-group col-sm-4">
                        <label>Nombres</label>
                        <input class="form_input form-control" type="text" id="nombres_val" readonly />
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Apellido paterno</label>
                        <input class="form_input form-control" type="text" id="paterno_val" readonly />
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Apellido materno</label>
                        <input class="form_input form-control" type="text" id="materno_val" readonly />
                    </div>
                    </div>
                    <div id="div_nuevo_grupo">
                        <div class="form_row_4">
                            <label for="areaVal" class="form_label">Area</label>
                            <select onchange="loadGrados();" required id="areaVal" name="areaVal" class="form_input">
                                <option></option>
                                <?php
								   $areas = Area::getLista($_SESSION['id_colegio']);
								   for($i = 0; $i < count($areas); $i++)
								     echo "<option value='".$areas[$i]['id_area']."'>".$areas[$i]['area']."</option>";
								?>
                            </select>
                        </div>
                        <div class="form_row_4">
                            <label for="gradoVal" class="form_label">Grado</label>
                            <select onchange="loadGrupos();" required="" id="gradoVal" name="gradoVal" class="form_input">
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="">
                            <label for="grupoVal" class="form_label">Grupo</label>
                            <select id="grupoVal" required="" name="grupoVal" class="form_input">
                                <!-- AJAX -->
                            </select>
                        </div>

                        <br />
                        <button id="boton_reinscribir" onclick="reinscribir();" class="btn btn-primary">Reinscribir</button>
                    </div>

                    <div id="buscador_alumnos" class="buscadorAjax" style="height:350px; box-shadow: 2px 2px 10px #5f5f5f;">
                        <div class="buscadorAjax_barra">
                            <img src='../../media/iconos/icon_close.gif' alt="Cerrar" onclick="$(this).parent().parent().fadeOut()" />
                        </div>
                        <div class="buscadorAjax_top">
                            <label class="buscadorAjax_top_label">Parametro: </label>
                            <input class="buscadorAjax_top_input form-control" type="text" id="parametroVal" />
                            <input class="buscadorAjax_top_boton btn btn-primary" style="margin-top:5px;" type="button" onclick="buscarAlumno()" value="Buscar" />
                        </div>
                        <div class="buscadorAjax_contenedor_tabla table-responsive" >
                            <table id="buscador_alumnos_tabla" class="buscadorAjax_tabla table">
                                <!-- Buscador AJAX -->
                            </table>
                        </div>
                    </div>

                </div><!--fin area_trabajo-->

            </div><!--fin principal-->
	 </div><!--fin panel-body-->
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
    <script src="../../assets/scripts/lib/jquery-1.11.3.min.js"></script>
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