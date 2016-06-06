<?php
include_once("../../includes/clases/class_lib.php");
extract($_GET);
# id_grupo
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$grupo = new Grupo($id_grupo);
if(is_null($grupo->id_grupo)){ header('Location: index.php'); exit; }
$grado = new Grado($grupo->id_grado);
$ciclo_actual = CicloEscolar::getActual($id_colegio);
$clases = $grupo->getClases();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<link rel="shortcut icon" href="../../images/logo.ico">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <title>Sistema Integral Meze - Perfil de grupo</title>
		
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
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <style>
            #datos_generales
            {
                width: 1000px;
                padding: 10px 0;
                overflow: auto;
            }
            
            .datos_generales_row
            {
                width: 500px;
                float: left;
                margin: 10px 0;
            }
            
            .datos_generales_label
            {
                width: 100px;
                float: left;
            }
            
            .datos_generales_value
            {
                float: left;
                font-weight: bold;
                margin-left: 10px;
                width: 380px;
            }

            #tabs{ font-size:12px; }

            #div_cambio_maestro
            {
                background-color: #fff;
                border: 1px solid #506aa0;
                display: none;
                height: 120px;
                left: 500px;
                overflow: auto;
                position: fixed;
                top: 200px;
                width: 250px;
                z-index: 10;
            }

            #div_cambio_maestro_inner
            {
                padding: 10px;
            }

            .barra
            {
                background-color: #506aa0;
                float: left;
                width: 100%;
            }

            .barra img
            {
                margin: 2px;
                float: right;
            }

            #div_cambio_maestro_inner label
            {
                width: 80%;
            }

            .imagen_icono
            {
                width: 20px;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="../../librerias/jquery.dataTables.min.js" ></script>
        <script>
            $(document).ready(function ()
            {
                declararDataTables();
                $("#tabs").tabs();
            });

            function declararDataTables()
            {
                $('#tabla_clases').dataTable({
                    "oLanguage": {
                        "sLengthMenu": "Mostrar _MENU_ clases por página",
                        "sZeroRecords": "No existen clases",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ clases",
                        "sInfoEmpty": "Mostrando 0 a 0 de 0 clases",
                        "sInfoFiltered": "(Encontrados de _MAX_ clases)"
                    }
                });

                $('#tabla_alumnos').dataTable({
                    "oLanguage": {
                        "sLengthMenu": "Mostrar _MENU_ alumnos por página",
                        "sZeroRecords": "No existen alumnos inscritos al grupo",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ alumnos",
                        "sInfoEmpty": "Mostrando 0 a 0 de 0 alumnos",
                        "sInfoFiltered": "(Encontrados de _MAX_ clases)"
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
                  <div class="display-6">Grupos</div>
                  
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
                <div id="datos_generales">
                    <div class="datos_generales_row">
                        <div class="datos_generales_label">Grupo:</div>
                        <div class="datos_generales_value"><?php echo $grupo->grupo; ?></div>
                    </div>
                    <div class="datos_generales_row">
                        <div class="datos_generales_label">Grado:</div>
                        <div class="datos_generales_value"><?php echo $grado->grado; ?></div>
                    </div>
                    <div class="datos_generales_row">
                        <div class="datos_generales_label">Area:</div>
                        <div class="datos_generales_value"><?php echo $grupo->getArea(); ?></div>
                    </div>
                    <div class="datos_generales_row">
                        <div class="datos_generales_label">Ciclo escolar:</div>
                        <div class="datos_generales_value"><?php echo $ciclo_actual->fecha_inicio; ?></div>
                    </div>
                </div>

               
                  <ul role="tablist" class="nav nav-pills nav-justified text-uppercase">
                    <li class="nav-item"><a href="#demo3tab-1" aria-controls="demo3tab-1" role="tab" data-toggle="tab" class="nav-link active">Materias</a></li>
                    <li class="nav-item"><a href="#demo3tab-2" aria-controls="demo3tab-2" role="tab" data-toggle="tab" class="nav-link">Alumnos</a></li>
				  </ul>
				  <div class="tab-content">
                    <div role="tabpanel" id="demo3tab-1" class="tab-pane p-y-2 active fade in">
                        <table id="tabla_clases" class="table">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                    <th>Maestro</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(is_array($clases))
                            {
                                foreach($clases as $clases)
                                {
                                    echo "
                                        <tr>
                                            <td>".$clases['materia']."</td>
                                            <td>
                                                <img
                                                    class='imagen_icono'
                                                    src='../../media/iconos/icon_modify.png'
                                                    onclick='mostrarCambioMaestro(".$clases['id_clase'].")'
                                                />
                                                ".$clases['nombre']."
                                            </td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" id="demo3tab-2" class="tab-pane p-y-2 fade in">
                        <table id="tabla_alumnos" class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Apellido paterno</th>
                                    <th>Apellido materno</th>
                                    <th>Nombres</th>
                                    <th>Perfil</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $alumnos = $grupo->getAlumnos();
                            if(is_array($alumnos))
                            {
                                foreach($alumnos as $alumno)
                                {
                                    echo "
                                        <tr>
                                            <td>".$alumno['id_alumno']."</td>
                                            <td>".$alumno['apellido_paterno']."</td>
                                            <td>".$alumno['apellido_materno']."</td>
                                            <td>".$alumno['nombres']."</td>
                                            <td>
                                                <a href='../alumnos/perfil.php?id_alumno=".$alumno['id_alumno']."'>
                                                    <img alt='P' src='../../media/iconos/icon_profile.png'>
                                                </a>
                                            </td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                            </tbody>
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

        <div id="div_cambio_maestro">
            <div class="barra">
                <img src='../../media/iconos/icon_close.gif' alt="Cerrar" onclick="$(this).parent().parent().fadeOut()" />
            </div>
            <div id="div_cambio_maestro_inner">
                <label>Maestro:</label>
                <select id="select_nuevo_maestro">
                    <?php
                    $maestros = Maestro::getLista($id_colegio);
                    if(is_array($maestros))
                    {
                        foreach($maestros as $maestro)
                        {
                            echo "
                            <option value=".$maestro['id_persona'].">
                                ".$maestro['nombres']." ".$maestro['apellido_paterno']."
                            </option>
                        ";
                        }
                    }
                    ?>
                </select>
                <input type="button" class="form_submit" value="Aceptar" onclick="cambiarMaestro(this)" />
            </div>
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
    <script>
        var id_clase_seleccionada = 0;

        function mostrarCambioMaestro(id_clase)
        {
            id_clase_seleccionada = id_clase;
            $("#div_cambio_maestro").fadeIn();
        }

        function cambiarMaestro(caller)
        {
            var id_maestro = $("#select_nuevo_maestro").val();
            if(id_maestro)
            {
                if(confirm("¿Desea cambiar el docente?"))
                {
                    $(caller).attr('disabled', 'disabled');
                    $("#div_cambio_maestro").hide();
                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/clases/cambiar_maestro.php",
                        data: "id_clase=" + id_clase_seleccionada + "&id_maestro=" + id_maestro,
                        success: function (data)
                        {
                            if(data == 1)
                            {
                                alert("Maestro cambiado");
                                location.reload();
                            }
                        }
                    });
                }
            }
            else
            {
                alert("Debe seleccionar un docente");
            }
        }

        /** Document Ready */
        $("#div_cambio_maestro").draggable({ handle: ".barra" });
    </script>
</html>