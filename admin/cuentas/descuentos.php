<?php
$id_modulo = 39; // Cuentas - Descuento
include_once("../../includes/clases/class_lib.php");
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<link rel="shortcut icon" href="../../../images/logo.ico">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <title>Sistema Integral Meze - Materias</title>
		
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
        <link rel="stylesheet" href="../../estilo/formas_mini.css" />
        <link rel="stylesheet" href="../../estilo/buscadorAjax.css" />
        <style>
           .boton{margin-left: 800px;}
	       .cajatexto{width: 310px;}

            #tabla_cuentas
            {
                border-collapse: collapse;
                font-size: 12px;
                text-align: left;
                border: 1px solid #A4C7E1;
                width: 100%;
            }

            #tabla_cuentas_wrapper
            {
                float: left;
                margin-top: 25px;
                overflow: auto;
                width: 100%;
            }

            #tabla_cuentas thead
            {
                background-color: #152975;
                color: #FFFFFF;
                height: 30px;
            }

            #tabla_cuentas tbody tr
            {
                height: 30px;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        
        <script src="../../librerias/jquery.validate.min.js" ></script>
        <script src="../../librerias/messages_es.js" ></script>
        <script src="../../librerias/fnAjaxReload.js" ></script>
        <script>
            var alumno;
            var descuentos;

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
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/getAlumnoJSON.php",
                    data: "id_alumno=" + id_alumno,
                    async: false,
                    success: function (data)
                    {
                        if (data != "error")
                        {
                            alumno = jQuery.parseJSON(data);
                            $("#id_alumnoVal").val(alumno.id_persona);
                            $("#input_alumno").val(alumno.apellido_paterno + " " + alumno.apellido_materno + " " + alumno.nombres);
                            cargarCiclos();
                            printCuentas();
                        }
                    }
                });
                $("#buscador_alumnos").fadeOut();
            }

            function cargarCiclos()
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/getCiclosInscrito.php",
                    data: "id_alumno=" + alumno.id_persona,
                    async: false,
                    success: function (data)
                    {
                        $("#cicloVal").html(data);
                    }
                });
            }

            function printCuentas()
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/print_status_cuentas.php",
                    data: "id_alumno=" + alumno.id_persona + "&id_ciclo_escolar=" + $("#cicloVal").val(),
                    success: function (data)
                    {
                        $("#div_cuentas").html(data);
                        $("#tabla_cuentas tbody").html(data);
                        descuentos = [];

                        asignarListener();
                    }
                });
            }

            function asignarListener()
            {
                $(".montoVal").bind('keyup mouseup oninput', function()
                {
                    console.log("Recalcular descuentos...");
                    descuentos = [];

                    $(".cuenta").each(function()
                    {
                        var id_cuenta   = $(this).children('.td_cuenta').children('.id_cuentaVal').val() * 1.0;
                        var monto       = $(this).children('.td_monto').children('.montoVal').val() * 1.0;
                        var adeudo      = $(this).children('.td_adeudo').children('.adeudoVal').val() * 1.0;

                        if(monto < 0)
                        {
                            monto = 0;
                            $(this).children('.td_monto').children('.montoVal').val(monto);
                        }
                        if(monto > adeudo)
                        {
                            monto = adeudo;
                            $(this).children('.td_monto').children('.montoVal').val(monto);
                        }

                        var descuento = {"id_cuenta":id_cuenta,"descuento":monto}
                        if(monto > 0){ descuentos.push(descuento); }
                    });
                });
            }

            function guardarDescuentos()
            {
                console.dir(descuentos);
                if(descuentos.length > 0)
                {
                    if(confirm("¿Seguro que los descuentos están correctos?"))
                    {
                        $("#boton").prop('disabled', true);

                        $.ajax({
                            type: "POST",
                            url: "../../includes/acciones/cuentas/descuentos/asignar_descuentos.php",
                            data: "descuentos=" + JSON.stringify(descuentos),
                            success: function (data)
                            {
                                if(data == 1){ alert("Descuentos asignados."); window.location.reload(true); }
                                else{ alert("Error."); $("#boton").prop('disabled', false); }
                            }
                        });
                    }
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
		  <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-university"></i>
              <div class="menu-block-label">Grupos</div></a>
			<ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../grupos/index.php" class="nav-link">Lista</a></li>
              <li class="nav-item"><a href="../grupos/nuevo.php" class="nav-link">Nuevo</a></li>
            </ul>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-ios-book"></i>
              <div class="menu-block-label">Materias</div></a>
			<ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../materias/index.php" class="nav-link">Lista</a></li>
              <li class="nav-item"><a href="../materias/nueva.php" class="nav-link">Nueva</a></li>
            </ul>
          </li>
		  <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-cash"></i>
              <div class="menu-block-label">Cuentas</div></a>
              <ul class="nav menu-block-sub">
              <li class="nav-item menu-block-has-sub"><a href="#" class="nav-link">Pagos</a>
			  <ul class="nav menu-block-sub">
			   <li class="nav-item"><a href="pagos/inscripcion.php" class="nav-link">Inscripci&oacute;n</a></li>
			   <li class="nav-item"><a href="pagos/colegiaturas.php" class="nav-link">Colegiaturas</a></li>
			   <li class="nav-item"><a href="pagos/cuotas.php" class="nav-link">Cuotas</a></li>
			  </ul>
			  </li>
              <li class="nav-item menu-block-has-sub"><a href="#" class="nav-link">Descuentos</a>
			  <ul class="nav menu-block-sub">
			   <li class="nav-item"><a href="descuentos/lista.php" class="nav-link">Lista</a></li>
			   <li class="nav-item"><a href="descuentos.php" class="nav-link">Nuevos</a></li>
			  </ul>
			  </li>
			  <li class="nav-item"><a href="recibos.php" class="nav-link">Recibos</a></li>
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
                  <div class="display-6">Descuentos</div>
                  
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

                
                    <input type="hidden" id="id_alumnoVal" />
                    <label class="form_label">Alumno</label>
                    <input id="input_alumno" name="input_alumno" class="form_input cajatexto" type="text" readonly="" onDblClick="$('#buscador_alumnos').fadeIn();" />
               
                    <label for="cicloVal" class="form_label">Ciclo escolar</label>
                    <select class="form_input_half" id="cicloVal" name="cicloVal" onChange="printCuentas()" >
                        <!-- AJAX -->
                    </select>
               <br><br>

                <div class="responsive-nav">
                    <table id="tabla_cuentas" class="table">
                        <thead class="thead-inverse">
                            <tr>
                                <th style="width: 15%" ></th>
                                <th style="width: 10%" >Subtotal</th>
                                <th style="width: 10%" >Recargos</th>
                                <th style="width: 10%" >Descuento</th>
                                <th style="width: 10%" >Total</th>
                                <th style="width: 10%" >Pagado</th>
                                <th style="width: 10%" >Adeudo</th>
                                <th style="width: 10%" >Fecha límite</th>
                                <th style="width: 15%" >Descuento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- AJAX -->
                        </tbody>
                    </table>
                </div>
                <div class="boton">
                <input type="button" class="form_submit btn btn-primary" value="Aceptar" id="boton" onClick="guardarDescuentos();" />
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

        <div class="buscadorAjax" id="buscador_alumnos" style="box-shadow: 2px 2px 5px #5f5f5f; " >
            <div class="buscadorAjax_barra">
                <img onClick="$(this).parent(0).parent(0).fadeOut()" alt="Cerrar" src="../../media/iconos/icon_close.gif">
            </div>
            <div class="buscadorAjax_top">
                <label class="buscadorAjax_top_label">Parametro: </label>
                <input type="text" id="parametroVal" class="buscadorAjax_top_input">
                <input type="button" value="Buscar" onClick="buscarAlumno()" class="buscadorAjax_top_boton">
            </div>
            <div class="buscadorAjax_contenedor_tabla">
                <table class="buscadorAjax_tabla" id="buscador_alumnos_tabla">
                    <!-- Buscador AJAX -->
                </table>
            </div>
        </div>

    </div>
    </body>
    <script>
        $(".buscadorAjax").draggable({ handle: ".buscadorAjax_barra", containment: "document" });
    </script>
</html>