<?php
$id_modulo = 16; // Ciclos - Estadísticas
include_once("../../includes/funciones_auxiliares.php");
include_once("../../includes/clases/class_lib.php");
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$ciclos_escolares = CicloEscolar::getLista($id_colegio);
$ciclo_actual = CicloEscolar::getActual($id_colegio);
$count_alumnos = $ciclo_actual->getCountAlumnosInscritos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>Sistema Integral MEZE - Estadisticas</title>
    

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
    
    <style>
        .charts_div{ overflow: auto; display: none; }
        .chart_inner_div{ width: 480px; float: left; }
        .chart_inner_div_title{ color: #4F4F4F; text-align: center; }
        #charts_options
        {
            margin: 15px 0;
            overflow: auto;
            padding: 0;
            width: 100%;
            list-style: none;
        }

        #charts_options li.selected, #charts_options li:hover
        {
            background-color: #E1E1FF;
            border: 1px solid #838683;
        }

        #charts_options li
        {
            background-color: #FFFFFF;
            border: 1px solid #AEB0AD;
            height: 20px;
            padding: 10px 0;
            text-align: center;
            width: 100px;
            float: left;
            margin: 0px 10px 0px 0px;
        }

        .data_row
        {
            width: 100%;
            margin: 0px 0px 10px 0px;
            overflow: auto;
            height: 20px;
        }

        .data_row_color_square
        {
            border: 1px solid #AAAAAA;
            float: left;
            height: 14px;
            margin: 2px 10px 2px 2px;
            width: 14px;
        }

        .data_row_label
        {
            width: 200px;
            float: left;
        }

        .data_row_label_mini
        {
            width: 100px;
            float: left;
        }
    </style>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script src="/librerias/Chart.js/Chart.min.js" ></script>
    <script>
        /** Alunmnos */
        var ctx_alumnos_pie;
        var chart_alumnos_pie;
        var ctx_alumnos_ciclos;
        var chart_alumnos_ciclos;
        var ctx_alumnos_inscripciones_bajas;
        var chart_alumnos_inscripciones_bajas;

        /** Maestros */
        var ctx_maestros_bar;
        var chart_maestros_bar;

        /** Clubs */
        var ctx_clubs_pie;
        var chart_clubs_pie;

        /** Colonias */
        var ctx_colonias_pie;
        var chart_colonias_pie;

        $(document).ready(function ()
        {

        });

        function crearChartsAlumnos()
        {
            ctx_alumnos_pie = $("#canvas_alumnos_pie").get(0).getContext("2d");
            chart_alumnos_pie = new Chart(ctx_alumnos_pie);

            $.getJSON('../../includes/acciones/stats/alumnos/distribucion_area.php', "tipo=2", function(jsonData)
            {
                var alumnos_pie_data = [];

                $.each(jsonData, function(i, area)
                {
                    switch(i)
                    {
                        case 0: $("#alumnos_kinder").html(area.value); break;
                        case 1: $("#alumnos_primaria").html(area.value); break;
                        case 2: $("#alumnos_secundaria").html(area.value); break;
                        case 3: $("#alumnos_bachillerato").html(area.value); break;
                        case 4: $("#alumnos_ingenieria").html(area.value); break;
                    }
                    alumnos_pie_data.push({value: area.value * 1.0, color: area.color});
                });

                var options_pie = {animationSteps  : 180};
                new Chart(ctx_alumnos_pie).Pie(alumnos_pie_data, options_pie);
            });

            ctx_alumnos_ciclos = $("#canvas_alumnos_ciclos").get(0).getContext("2d");
            chart_alumnos_ciclos = new Chart(ctx_alumnos_ciclos);

            $.getJSON('../../includes/acciones/stats/alumnos/inscritos_ciclos.php', function(jsonData)
            {
                var alumnos_ciclos_labels = ['Inicio'];
                var alumnos_ciclos_data = [0];

                $.each(jsonData, function(i, ciclo)
                {
                    alumnos_ciclos_labels.push(ciclo.ciclo);
                    alumnos_ciclos_data.push(ciclo.alumnos);
                });

                var alumnos_ciclos_metadata = {
                    labels : alumnos_ciclos_labels,
                    datasets : [
                        {
                            fillColor : "rgba(151,187,205,0.5)",
                            strokeColor : "rgba(151,187,205,1)",
                            pointColor : "rgba(151,187,205,1)",
                            pointStrokeColor : "#fff",
                            data : alumnos_ciclos_data
                        }
                    ]
                };

                var options_line = {animationSteps  : 180};
                new Chart(ctx_alumnos_ciclos).Line(alumnos_ciclos_metadata, options_line);
            });

            ctx_alumnos_inscripciones_bajas = $("#canvas_alumnos_inscripciones_bajas").get(0).getContext("2d");
            chart_alumnos_inscripciones_bajas = new Chart(ctx_alumnos_inscripciones_bajas);

            $.getJSON('../../includes/acciones/stats/alumnos/inscripciones_ciclos.php', function(jsonData)
            {
                var alumnos_inscripciones_bajas_labels = ['Inicio'];
                var alumnos_altas_data = [0];
                var alumnos_bajas_data = [0];

                $.each(jsonData, function(i, ciclo)
                {
                    alumnos_inscripciones_bajas_labels.push(ciclo.ciclo);
                    alumnos_altas_data.push(ciclo.altas);
                    alumnos_bajas_data.push(ciclo.bajas);
                });

                var alumnos_ciclos_metadata = {
                    labels : alumnos_inscripciones_bajas_labels,
                    datasets : [
                        {
                            fillColor : "rgba(151,187,205,0.5)",
                            strokeColor : "rgba(151,187,205,1)",
                            pointColor : "rgba(151,187,205,1)",
                            pointStrokeColor : "#fff",
                            data : alumnos_altas_data
                        },
                        {
                            fillColor : "rgba(220,220,220,0.5)",
                            strokeColor : "rgba(220,220,220,1)",
                            pointColor : "rgba(220,220,220,1)",
                            pointStrokeColor : "#fff",
                            data : alumnos_bajas_data
                        }
                    ]
                };

                var options_line = {animationSteps  : 180};
                new Chart(ctx_alumnos_inscripciones_bajas).Line(alumnos_ciclos_metadata, options_line);
            });
        }

        function crearChartsMaestros()
        {
            ctx_maestros_bar = $("#canvas_maestros_bar").get(0).getContext("2d");
            chart_maestros_bar = new Chart(ctx_maestros_bar);

            $.getJSON('../../includes/acciones/stats/maestros/distribucion_area.php', "tipo=1", function(jsonData)
            {
                var datos = {
                    labels : ["Kinder", "Primaria", "Secundaria", "Bachillerato", "Ingenieria"],
                    datasets : [
                        {
                            fillColor : "rgba(151,187,205,0.5)",
                            strokeColor : "rgba(151,187,205,1)",
                            pointColor : "rgba(151,187,205,1)",
                            pointStrokeColor : "#fff",
                            data : jsonData
                        }
                    ]
                }
                var options = {animationSteps  : 180};
                new Chart(ctx_maestros_bar).Bar(datos, options);
            });
        }

        function crearChartsClubs()
        {
            ctx_clubs_pie = $("#canvas_clubs_pie").get(0).getContext("2d");
            chart_clubs_pie = new Chart(ctx_clubs_pie);

            $.getJSON('../../includes/acciones/stats/clubs/pie.php', function(jsonData)
            {
                var clubs_pie_data = [];

                $("#datos_clubs").html("");
                $.each(jsonData, function(i, club)
                {
                    clubs_pie_data.push({value: club.value * 1.0, color: club.color, label: club.label});
                    $("#datos_clubs").append('<div class="data_row" style="color: '+club.color+'; font-weight: bold">' +
                        '<div class="data_row_label">'+club.label+'</div>' +
                        '<div class="data_row_value" id="total_alumnos" >'+club.value+'</div>' +
                    '</div>');
                });

                var options_pie = {animationSteps  : 50};
                new Chart(ctx_clubs_pie).Pie(clubs_pie_data, options_pie);
            });
        }

        function crearChartsColonias()
        {
            ctx_colonias_pie = $("#canvas_colonias_pie").get(0).getContext("2d");
            chart_colonias_pie = new Chart(ctx_colonias_pie);

            $.getJSON('../../includes/acciones/stats/colonias/pie.php', function(jsonData)
            {
                var colonias_pie_data = [];

                $.each(jsonData, function(i, colonia)
                {
                    colonias_pie_data.push({value: colonia.value * 1.0, color: colonia.color, label: colonia.label});
                });

                var options_pie = {animationSteps  : 50};
                new Chart(ctx_colonias_pie).Pie(colonias_pie_data, options_pie);
            });
        }

        function selectedDiv(opt, caller)
        {
            $(".charts_div").hide();
            $("#charts_options li").removeClass('selected');
            $(caller).addClass('selected');
            switch(opt)
            {
                case 1: $("#charts_alumnos").show(0 , function(){ crearChartsAlumnos(); }); break;
                case 2: $("#charts_maestros").show(0, function(){ crearChartsMaestros(); }); break;
                case 3: $("#charts_clubs").show(0, function(){ crearChartsClubs(); }); break;
                case 4: $("#charts_colonias").show(0, function(){ crearChartsColonias(); }); break;
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
                  <div class="display-6">Estadísticas</div>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
        
        <div class="container-fluid">
          <div class="panel-wrapper">
            <div class="panel">
              <div class="panel-body">

            <ul id="charts_options" >
				<button type="button" class="btn btn-primary" onclick="selectedDiv(1, this);" ><i class="fa fa-child"></i> Alumnos</button>
				<button type="button" class="btn btn-default" onclick="selectedDiv(2, this);" ><i class="fa fa-users"></i> Maestros</button>
				<button type="button" class="btn btn-info" onclick="selectedDiv(3, this);" ><i class="fa fa-cubes"></i> Clubs</button>
				<button type="button" class="btn btn-default" onclick="selectedDiv(4, this);" ><i class="fa fa-street-view"></i> Colonias</button>
            </ul>

            <div class="charts_div" id="charts_alumnos">
                <div class="chart_inner_div">
                    <div class="chart_inner_div_title">Distribución por area</div>
                    <canvas id="canvas_alumnos_pie" width="400" height="400"></canvas>
                </div>
                <div class="chart_inner_div" style="margin: 125px 0;">
                    <div class="data_row">
                        <div class="data_row_label">Alumnos inscritos:</div>
                        <div class="data_row_value" id="total_alumnos" ><?php echo $count_alumnos; ?></div>
                    </div>
                    <div class="data_row">
                        <div class="data_row_color_square" style="background-color: #A3A3FA;" ></div>
                        <div class="data_row_label_mini">Kinder:</div>
                        <div class="data_row_value" id="alumnos_kinder" ></div>
                    </div>
                    <div class="data_row">
                        <div class="data_row_color_square" style="background-color: #FF7373;" ></div>
                        <div class="data_row_label_mini">Primaria:</div>
                        <div class="data_row_value" id="alumnos_primaria" ></div>
                    </div>
                    <div class="data_row">
                        <div class="data_row_color_square" style="background-color: #8BFF8B;" ></div>
                        <div class="data_row_label_mini">Secundaria:</div>
                        <div class="data_row_value" id="alumnos_secundaria" ></div>
                    </div>
                    <div class="data_row">
                        <div class="data_row_color_square" style="background-color: #FFFB9B;" ></div>
                        <div class="data_row_label_mini">Bachillerato:</div>
                        <div class="data_row_value" id="alumnos_bachillerato" ></div>
                    </div>
                    <div class="data_row">
                        <div class="data_row_color_square" style="background-color: #D873FF;" ></div>
                        <div class="data_row_label_mini">Ingenieria:</div>
                        <div class="data_row_value" id="alumnos_ingenieria" ></div>
                    </div>
                </div>
                <div class="chart_inner_div">
                    <div class="chart_inner_div_title">Alumnos inscritos por ciclo</div>
                    <canvas id="canvas_alumnos_ciclos" width="480" height="400"></canvas>
                </div>
                <div class="chart_inner_div">
                    <div class="chart_inner_div_title">Inscripciones y bajas</div>
                    <canvas id="canvas_alumnos_inscripciones_bajas" width="480" height="400"></canvas>
                </div>
            </div>

            <div class="charts_div" id="charts_maestros" class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3">
                <div class="chart_inner_div">
                    <div class="chart_inner_div_title">Maestros</div>
                    <canvas id="canvas_maestros_bar" width="480" height="400"></canvas>
                </div>
            </div>

            <div class="charts_div" id="charts_clubs" class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3">
                <div class="chart_inner_div">
                    <div class="chart_inner_div_title">Clubs</div>
                    <canvas id="canvas_clubs_pie" width="480" height="400"></canvas>
                </div>
                <div class="chart_inner_div" style="margin: 125px 0;" id="datos_clubs">

                </div>

                <!-- DATATABLE -->
                <table id="tabla_clubs">

                </table>
                <!--------------->
            </div>

            <div class="charts_div" id="charts_colonias" class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-3">
                <div class="chart_inner_div">
                    <div class="chart_inner_div_title">Colonias</div>
                    <canvas id="canvas_colonias_pie" width="480" height="400"></canvas>
                </div>
            </div>

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
