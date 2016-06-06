<?php
include_once("../../includes/clases/class_lib.php");
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>Sistema Integral MEZE - Tipos de Becas</title>
    

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
        <link rel="stylesheet" href="../../estilo/fixed_form.css" />
        <style>
            .tabla
            {
                width: 100%;
                border: 1px solid black;
                padding: 10px;
            }
            
            .titulo_tabla
            {
                width: 100%;
                font-size: 12px;
            }
            
            .table_wrapper
            {
                width: 400px;
            }
            
            .seleccionado
            {
                background-color: #BBCBFF;
            }

            tr{ height: 10px; }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script>
            var tipo_seleccionado;

            $(document).ready(function ()
            {
                cargarTablaTipos();
                $("#div_nuevo_tipo").draggable({ handle: "#div_nuevo_tipo_bar" });
                $("#div_nuevo_subtipo").draggable({ handle: "#div_nuevo_subtipo_bar" });
            });

            function cargarTablaTipos()
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/becas/print_tipos.php",
                    data: "",
                    success: function (data)
                    {
                        $("#tabla_tipos").html(data);
                    }
                });
            }

            function agregarTipo()
            {
                $("#boton_nuevo_tipo").attr('disabled', 'disabled');
                var tipoVal = $("#tipoVal").val();
                var subtipoVal = $("#subtipoVal").val();
                if (tipoVal.length < 1 || subtipoVal.length < 1)
                {
                    alert("Debe introducir un valor");
                    $("#boton_nuevo_tipo").removeAttr('disabled');
                }
                else
                {
                    if (confirm("¿Seguro que desea agregar el tipo de beca: '" + tipoVal + "'?"))
                    {
                        $.ajax({
                            type: "POST",
                            url: "../../includes/acciones/becas/insert_tipo.php",
                            data: "tipoVal=" + tipoVal + "&subtipoVal=" + subtipoVal,
                            success: function (data)
                            {
                                cargarTablaTipos();
                                $('#div_nuevo_tipo').fadeOut();
                                $("#boton_nuevo_tipo").removeAttr('disabled');
                            }
                        });
                    }
                }
            }

            function agregarSubTipo()
            {
                $("#boton_nuevo_subtipo").attr('disabled', 'disabled');
                var id_tipo_beca = $("#id_tipo_becaVal").val();
                var subtipo = $("#subtipo2Val").val();

                if (subtipo.length < 1)
                {
                    alert("Debe introducir un valor");
                    $("#boton_nuevo_subtipo").removeAttr('disabled');
                }
                else
                {
                    if (confirm("¿Seguro que desea agregar el subtipo de beca: '" + subtipo + "'?"))
                    {
                        $.ajax({
                            type: "POST",
                            url: "../../includes/acciones/becas/insert_subtipo.php",
                            data: "id_tipo=" + id_tipo_beca + "&subtipoVal=" + subtipo,
                            success: function (data)
                            {
                                cargarTablaTipos();
                                $('#div_nuevo_subtipo').fadeOut();
                                $("#boton_nuevo_subtipo").removeAttr('disabled');
                            }
                        });
                    }
                }
            }

            function seleccionarTipo(id_tipo, caller)
            {
                tipo_seleccionado = id_tipo;
                $("#tabla_tipos tr").each(function ()
                {
                    $(this).removeAttr('class');
                });
                $(caller).attr('class', 'seleccionado');
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/becas/print_subtipos.php",
                    data: "id_tipo_beca=" + id_tipo,
                    success: function (data)
                    {
                        $("#tabla_subtipos").html(data);
                    }
                });
            }

            function mostrarNuevoSubtipo()
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/becas/print_select_tipos.php",
                    data: "",
                    success: function (data)
                    {
                        $("#id_tipo_becaVal").html(data);
                        $('#div_nuevo_subtipo').fadeIn();
                        $("#id_tipo_becaVal").val(tipo_seleccionado);
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
                  <div class="display-6">Tipos de Beca</div>
                  
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
                

                <div class="table_wrapper" >
                    <div class="titulo_tabla table">Tipo de beca</div>
                    <table class="tabla" id="tabla_tipos">
                        <!-- AJAX -->
                    </table>
                    <img src="../../media/iconos/icon_add.png" ALT="nuevo" style="float: right;" onclick="$('#div_nuevo_tipo').fadeIn();" />
                </div>

                <div class="table_wrapper"  >
                    <div class="titulo_tabla table" >Subtipos</div>
                    <table class="tabla" id="tabla_subtipos">
                        <tr><td>Seleccione un tipo de beca</td></tr>
                        <!-- AJAX -->
                    </table>
                    <img src="../../media/iconos/icon_add.png" ALT="nuevo" style="float: right;" onclick="mostrarNuevoSubtipo();" />
                </div>

                <div id="div_nuevo_tipo" class="fixed_form" >
                    <div id="div_nuevo_tipo_bar" class="fixed_form_handle table" >
                        <img src="../../media/iconos/icon_close.gif" alt="X" onclick="$(this).parent().parent().fadeOut();" />
                    </div>
                    <div class="fixed_form_content" >
                        <div class="fixed_form_row">
                            <label>Tipo</label>
                            <input type="text" class="fixed_form_value" id="tipoVal" />
                        </div>
                        <div class="fixed_form_row">
                            <label>Debe agregar al menos 1 sub-tipo</label>
                            <input type="text" class="fixed_form_value" id="subtipoVal" placeholder="General" />
                        </div>
                        <div class="fixed_for_row">
                            <input id="boton_nuevo_tipo" type="button" value="Aceptar" class="fixed_form_button" onclick="agregarTipo();" />
                        </div>
                    </div>
                </div>

                <div id="div_nuevo_subtipo" class="fixed_form"  >
                    <div id="div_nuevo_subtipo_bar" class="fixed_form_handle" >
                        <img src="../../media/iconos/icon_close.gif" alt="X" onclick="$(this).parent().parent().fadeOut();" />
                    </div>
                    <div class="fixed_form_content" >
                        <div class="fixed_form_row">
                            <label>Tipo de beca</label>
                            <select class="fixed_form_value" id="id_tipo_becaVal" >
                                <!-- AJAX -->
                            </select>
                        </div>
                        <div class="fixed_form_row">
                            <label>Subtipo</label>
                            <input type="text" class="fixed_form_value" id="subtipo2Val" />
                        </div>
                        <div class="fixed_for_row">
                            <input id="boton_nuevo_subtipo" type="button" value="Aceptar" class="fixed_form_button" onclick="agregarSubTipo();" />
                        </div>
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
