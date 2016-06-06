<?php

include_once("../../includes/clases/class_lib.php");
extract($_GET);
# id_alumno
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_alumno, $id_colegio);
if(is_null($alumno->id_persona)){ header('Location: index.php'); exit; }
$area       = $alumno->getArea();
$emails     = $alumno->getEmails();
$telefonos  = $alumno->getTelefonos();
$clases     = $alumno->getClasesActuales();
$pagos      = $alumno->getPagosCuentasCiclo();
$ciclo      = CicloEscolar::getActual($id_colegio);
$grupo      = $alumno->getGrupo($ciclo->id_ciclo_escolar);
$grado      = $alumno->getGrado($ciclo->id_ciclo_escolar);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>Sistema Integral Meze - Perfil de alumno</title>
        
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
        <link rel="stylesheet" href="../../estilo/perfil_alumno.css" />
        <link rel="stylesheet" href="../../estilo/fixed_form.css" />
        <link rel="stylesheet" href="../../estilo/perfiles.css" />
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

        
        
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
                  <div class="display-6">Perfil del Alumno</div>
                  
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
                <div id="profile_picture">

                    <div id="profile_picture_inner">
                       <img src="../../media/fotos/<?php echo $alumno->foto; ?>" alt="N/A" id="foto_maestro" />
                    </div>

                </div>

                <!-- Datos del perfil. CSS: perfiles.css -->
                <div class="datos_perfil" >
                    <div class="datos_perfil_seccion" >
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Nombre(s):</div>
                            <div class="perfil_dato_value"><?php echo $alumno->nombres; ?></div>
                            <img src="../../media/iconos/icon_modify.png"
                                 ALT="M" onClick="cambiarNombresClicked()"
                                 style="width: 15px" title="Cambiar nombre" />
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Apellido paterno:</div>
                            <div class="perfil_dato_value"><?php echo $alumno->apellido_paterno; ?></div>
                            <img src="../../media/iconos/icon_modify.png"
                                 ALT="M" onClick="cambiarApellidoPaternoClicked()"
                                 style="width: 15px" title="Cambiar apellido paterno" />
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Apellido materno:</div>
                            <div class="perfil_dato_value"><?php echo $alumno->apellido_materno; ?></div>
                            <img src="../../media/iconos/icon_modify.png"
                                 ALT="M" onClick="cambiarApellidoMaternoClicked()"
                                 style="width: 15px" title="Cambiar apellido materno" />
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Matricula:</div>
                            <div class="perfil_dato_value"><?php echo $alumno->matricula; ?></div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Registrad@ desde:</div>
                            <div class="perfil_dato_value"><?php echo $alumno->fecha_alta; ?></div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Peso:</div>
                            <div class="perfil_dato_value">
                            <?php echo $alumno->getPeso(); ?>
                                                                <img src="../../media/iconos/icon_modify.png"
                                     ALT="M" onClick="$('#nuevo_registro_nut').dialog('open');"
                                     style="width: 15px" title="Cambiar grupo" />
                            </div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Talla:</div>
                            <div class="perfil_dato_value">
                            <?php echo $alumno->getTalla(); ?>
                            </div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">IMC:</div>
                            <div class="perfil_dato_value">
                            <?php echo $alumno->getIMC(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="datos_perfil_seccion" >
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Estado:</div>
                            <div class="datos_generales_value" style="color: red">
                            <?php
                                if($alumno->getEstado())
                                {
                                    echo '
                                        <div class="datos_generales_value" style="color: green">
                                            Activo
                                            <img onclick="baja('.$alumno->id_persona.')" src="../../media/iconos/icon_close.gif" alt="X" />
                                        </div>
                                    ';
                                }
                                else
                                {
                                    echo '<div class="datos_generales_value" style="color: red">Inactivo</div>';
                                }
                            ?>
                            </div>                        
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Beca:</div>
                            <div class="perfil_dato_value">
                               <?php
                                $beca = $alumno->getBecaActual();
                                if(is_null($beca))
                                {
                                    echo "No";
                                }
                                else
                                {
                                    echo $beca['beca']." (".$beca['tipo'].")";
                                    echo '
                                    <a href="../becas/modificar.php?id_alumno='.$id_alumno.'">
                                        <img width="11" height="12" src="../../media/iconos/icon_modify.png" alt="M" />
                                    </a>
                                    ';
                                }
                                ?>                         
                            </div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Contrase&ntilde;a:</div>
                            <div class="perfil_dato_value">
                               <?php echo $alumno->password; ?>                        
                                   <img src="../../media/iconos/icon_modify.png"
                                     ALT="M" onClick="cambiarPasswordClicked()"
                                     style="width: 15px" title="Cambiar contraseña" />
                            </div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Nivel:</div>
                            <div class="perfil_dato_value">
                               <?php echo $grado." de ".$area['area']; ?>                        
                            </div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Grupo:</div>
                            <div class="perfil_dato_value">
                               <?php echo $grupo; ?>                               
                                <img src="../../media/iconos/icon_modify.png"
                                     ALT="M" onClick="cambiarGrupoClicked()"
                                     style="width: 15px" title="Cambiar grupo" />
                            </div>
                        </div>
                    </div>
                </div>

               

                <div id="panel_imagen">
                    <!-- loader.gif -->
                    <img style="display:none" id="loader" src="../../media/imagenes/loader.gif" alt="Cargando...." title="Cargando...." />
                    <!-- simple file uploading form -->
                    <form id="form_imagen" action="../../includes/ajaxuploadAlumnos.php" method="post" enctype="multipart/form-data">
                        <input id="uploadImage" type="file" accept="image/*" name="image" value="Seleccionar foto"/><br><br>
                        <input id="button" type="submit" value="Subir" class="btn btn-warning">
                    </form>
                </div>

				<ul role="tablist" class="nav nav-pills nav-justified text-uppercase">
                    <li class="nav-item"><a href="#demo3tab-1" aria-controls="demo3tab-1" role="tab" data-toggle="tab" class="nav-link active">Clases</a></li>
                    <li class="nav-item"><a href="#demo3tab-2" aria-controls="demo3tab-2" role="tab" data-toggle="tab" class="nav-link">Tutores</a></li>
					<li class="nav-item"><a href="#demo3tab-3" aria-controls="demo3tab-3" role="tab" data-toggle="tab" class="nav-link">E-Mails</a></li>
					<li class="nav-item"><a href="#demo3tab-4" aria-controls="demo3tab-4" role="tab" data-toggle="tab" class="nav-link">Telefonos</a></li>
					<li class="nav-item"><a href="#demo3tab-5" aria-controls="demo3tab-5" role="tab" data-toggle="tab" class="nav-link">Pagos</a></li>
					<li class="nav-item"><a href="#demo3tab-6" aria-controls="demo3tab-6" role="tab" data-toggle="tab" class="nav-link">Informacion</a></li>
					<li class="nav-item"><a href="#demo3tab-7" aria-controls="demo3tab-7" role="tab" data-toggle="tab" class="nav-link">Becas</a></li>
					<li class="nav-item"><a href="#demo3tab-8" aria-controls="demo3tab-8" role="tab" data-toggle="tab" class="nav-link">Calificaciones</a></li>
					<li class="nav-item"><a href="#demo3tab-9" aria-controls="demo3tab-9" role="tab" data-toggle="tab" class="nav-link">Papeleria</a></li>
					<li class="nav-item"><a href="#demo3tab-10" aria-controls="demo3tab-10" role="tab" data-toggle="tab" class="nav-link">Nutricion</a></li>
					<li class="nav-item"><a href="#demo3tab-11" aria-controls="demo3tab-11" role="tab" data-toggle="tab" class="nav-link">Cuentas</a></li>
                </ul>
				  
                <div class="tab-content">
                    
                    <div role="tabpanel" id="demo3tab-1" class="tab-pane p-y-2 active fade in">
                        <table id="tabla_clases" class="table" data-plugin="DataTable">
                            <thead>
                                <tr>
                                    <th>Grado</th>
                                    <th>Grupo</th>
                                    <th>Materia</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php
                            if(is_array($clases))
                            {
                                foreach($clases as $clase)
                                {
                                    echo "
                                        <tr>
                                            <td>".$clase['grado']."</td>
                                            <td>".$clase['grupo']."</td>
                                            <td>".$clase['materia']."</td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                                                                </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" id="demo3tab-2" class="tab-pane p-y-2 fade in">
                        <table id="tabla_tutores" class="table" data-plugin="DataTable">
                            <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Calle</th>
                                <th>Numero</th>
                                <th>Colonia</th>
                                <th>CP</th>
                                <th>Telefonos</th>
                                <th>Celular</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $tutores = $alumno->getTutores();
                            if(is_array($tutores))
                            {
                                foreach($tutores as $tutor)
                                {
                                    echo "
                                        <tr class='tutor' >
                                            <input type='hidden' class='id_tipo_tutor' value='".$tutor['id_tipo_tutor']."' />
                                            <td class='tipo_tutor' >".$tutor['tipo_tutor']."</td>
                                            <td class='nombre' >".$tutor['nombre']."</td>
                                            <td class='calle' >".$tutor['calle']."</td>
                                            <td class='numero' >".$tutor['numero']."</td>
                                            <td class='colonia' >".$tutor['colonia']."</td>
                                            <td class='CP' >".$tutor['CP']."</td>
                                            <td class='telefonos' >".$tutor['telefonos']."</td>
                                            <td class='celular' >".$tutor['celular']."</td>
                                            <td><img src='../../media/iconos/icon_modify.png' style='width:15px' onclick='modificarTutor(this)' /></td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                                                                </tbody>
                        </table>
                        <img src="../../media/iconos/icon_add.png" alt="Nuevo" style="float: right;" onClick="toggleTutor();" />
                    </div>
                    <div role="tabpanel" id="demo3tab-3" class="tab-pane p-y-2 fade in">
                        <table id="tabla_emails" class="table" data-plugin="DataTable">
                            <thead>
                                <tr>
                                    <th>Tipo de correo electronico</th>
                                    <th>Correo electronico</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php
                            if(is_array($emails))
                            {
                                foreach($emails as $email)
                                {
                                    echo "
                                        <tr>
                                            <td>".$email['tipo_email']."</td>
                                            <td>".$email['email']."</td>
                                            <td>
                                                <a href='../../includes/acciones/alumnos/eliminar_email.php?id_email=".$email['id_email']."' >
                                                    <img src='../../media/iconos/icon_close.gif' alt='borrar' />
                                                </a>
                                            </td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                                                        </tbody>
                        </table>
                        <img src="../../media/iconos/icon_add.png" alt="Nuevo" style="float: right;" onClick="toggleEmail();" />
                    </div>
                    <div role="tabpanel" id="demo3tab-4" class="tab-pane p-y-2 fade in">
                        <table id="tabla_telefonos" class="table" data-plugin="DataTable">
                            <thead>
                                <tr>
                                    <th>Tipo de telefono</th>
                                    <th>Telefono</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(is_array($telefonos))
                            {
                                foreach($telefonos as $telefono)
                                {
                                    echo "
                                        <tr>
                                            <td>".$telefono['tipo_telefono']."</td>
                                            <td>".$telefono['telefono']."</td>
                                            <td>
                                                <a href='../../includes/acciones/alumnos/eliminar_telefono.php?id_telefono=".$telefono['id_telefono']."' >
                                                    <img src='../../media/iconos/icon_close.gif' alt='borrar' />
                                                </a>
                                            </td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                                                        </tbody>
                        </table>
                        <img src="../../media/iconos/icon_add.png" alt="Nuevo" style="float: right;" onClick="toggleTelefono();" />
                    </div>
                    <div role="tabpanel" id="demo3tab-5" class="tab-pane p-y-2 fade in">
                        <table id="tabla_pagos" class="table" data-plugin="DataTable">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Usuario</th>
                                <th>Descripcion</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(is_array($pagos))
                            {
                                foreach($pagos as $pago)
                                {
                                    echo "
                                        <tr>
                                            <td>".$pago['fecha']."</td>
                                            <td>".$pago['concepto']."</td>
                                            <td>$ ".$pago['monto']."</td>
                                            <td>".$pago['usuario']."</td>
                                            <td>".$pago['descripcion']."</td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                                                        </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" id="demo3tab-6" class="tab-pane p-y-2 fade in">
                        <div style="width: 90%; margin: 10px 0;">
                          <?php $direccion = $alumno->getDireccion(); ?>
                            <label class="form_label" for="calleVal">Calle</label>
                            <input type="text" class="form_input form-control" id="calleVal" value="<?php echo $direccion['calle']; ?>" readonly />
                            <label class="form_label" for="numeroVal">Numero</label>
                            <input type="text" class="form_input form-control" id="numeroVal" value="<?php echo $direccion['numero']; ?>" readonly />
                            <label class="form_label" for="coloniaVal">Colonia</label>
                            <input type="text" class="form_input form-control" id="coloniaVal" value="<?php echo $direccion['colonia']; ?>" readonly />
                            <label class="form_label" for="CPVal">CP</label>
                            <input type="text" class="form_input form-control" id="CPVal" value="<?php echo $direccion['CP']; ?>" readonly />
                            <img src="../../media/iconos/icon_modify.png" width="15" ALT="M" onClick="mostrarMdyDireccion()" />
                        </div>
                        <label>Club</label>
                        <input type="text" class="form_input form-control" value="<?php echo $alumno->getClubDeportivo(); ?>" readonly />
                        <label>CURP</label>
                        <input type="text" class="form_input form-control" value="<?php echo $alumno->getCURP(); ?>" readonly />
                    </div>
                    <div role="tabpanel" id="demo3tab-7" class="tab-pane p-y-2 fade in">
                        <table id="tabla_becas" class="table" data-plugin="DataTable">
                            <thead>
                            <tr>
                                <th>Ciclo escolar</th>
                                <th>Beca</th>
                                <th>Tipo</th>
                                <th>Subtipo</th>
                                <th>Aprobada por</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $becas = $alumno->getHistorialBecas();
                            if(is_array($becas))
                            {
                                foreach($becas as $beca)
                                {
                                    echo "
                                        <tr>
                                            <td>".$beca['ciclo_escolar']."</td>
                                            <td>".$beca['beca']."</td>
                                            <td>".$beca['tipo_beca']."</td>
                                            <td>".$beca['subtipo_beca']."</td>
                                            <td>".$beca['usuario']."</td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                                                        </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" id="demo3tab-8" class="tab-pane p-y-2 fade in">
                        <label>Ciclo escolar</label>
                        <select id="ciclo_escolarVal" onChange="reloadCalis()">
                            <?php
							    $ciclos = CicloEscolar::getLista($id_colegio);
                                if(is_array($ciclos))
                                {
                                    //foreach($ciclos as $ciclo)
									for($i=0; $i < count($ciclos); $i++)
                                    {
                                      echo "<option value='".$ciclos[$i]['id_ciclo_escolar']."'>".$ciclos[$i]['ciclo_escolar']."</option>";
                                    }
                                }
                            ?>               
                        </select>
                        <table id="tabla_calificaciones" class="table">
                            <thead>
                                <tr>
                                    <th>Materia</th>
                                   <?php
                                    for($p = 1; $p <= $area['no_parciales']; $p++)
                                    {
                                        echo "<th>Bloque ".$p."</th>";
                                    }
                                    ?>                                    
                                    <th>Promedio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- AJAX -->
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" id="demo3tab-9" class="tab-pane p-y-2 fade in">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Documento</th>
                                <th style="width: 120px" >Original</th>
                                <th>Copia</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $papeleria = $alumno->getPapeleria();
                            if(is_array($papeleria))
                            {
                                foreach($papeleria as $documento)
                                {
                                    $id_documento   = $documento['id_documento'];
                                    $nombre         = $documento['documento'];
                                    $original = ''; $copia = '';
                                    if($documento['original'] == 1) $original = 'checked';
                                    if($documento['copia'] == 1) $copia = 'checked';

                                    echo "
                                            <tr class='documento' >
                                                <input type='hidden' class='id_documento' value='".$id_documento."' />
                                                <td>".$nombre."</td>
                                                <td><input type='checkbox' class='original' value='".$id_documento."' ".$original." /></td>
                                                <td><input type='checkbox' class='copia' value='".$id_documento."' ".$copia." /></td>
                                            </tr>
                                        ";
                                }
                            }
                            ?>
                                                                    </tbody>
                        </table>
                        <input type="button" class="btn btn-primary" value="Actualizar" onClick="updatePapeleria(this)" />
                    </div>
                    <div role="tabpanel" id="demo3tab-10" class="tab-pane p-y-2 fade in">

                    </div>
                    <div role="tabpanel" id="demo3tab-11" class="tab-pane p-y-2 fade in">
                        <table id="tabla_cuentas" class="table" data-plugin="DataTable">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Total</th>
                                    <th>Pagado</th>
                                    <th>Adeudo</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							    $cuentas = $alumno->getCuentasOtras($ciclo->id_ciclo_escolar);
                                if(is_array($cuentas))
                                {
                                    foreach($cuentas as $cuenta)
                                    {
                                        echo "
                                            <tr>
                                                <td>".$cuenta['concepto']."</td>
                                                <td>$".$cuenta['monto']."</td>
                                                <td>$".$cuenta['pagado']."</td>
                                                <td>$".$cuenta['deuda']."</td>
                                            </tr>
                                        ";
                                    }
                                }
                            ?>
                                                        </tbody>
                        </table>
                    </div>
                </div><!--fin tab-content-->

                <div id="div_boton_cuentas">
                    <div id="wrapper_select">
                        <label>Ciclo escolar</label>
                        <select id="ciclo_escolarCuentasVal" class="form-control" >
                            <?php
							$ciclos = CicloEscolar::getLista($id_colegio);
                            if(is_array($ciclos))
                            {
                                //foreach($ciclos as $ciclo)
								for($j = 0; $j < count($ciclos); $j++)
                                {
                                    echo "<option value='".$ciclos[$j]['id_ciclo_escolar']."'>".$ciclos[$j]['ciclo_escolar']."</option>";
                                }
                            }
                            ?>                        
                        </select>
                    <button onClick="perfilCuentas();" class="btn btn-primary" style="margin-top:5px; width:250px;" >Perfil de cuentas</button>
                </div>

                <div id="prompt_email" class="fixed_form" >
                    <div id="prompt_email_handle" class="fixed_form_handle">
                        <img src="../../media/iconos/icon_close.gif" alt="Cerrar" onClick="$(this).parent().parent().fadeOut();" />
                    </div>
                    <div class="fixed_form_content">
                        <div class="fixed_form_row">
                            <label>Tipo:</label>
                            <select id="tipo_emailVal" class="fixed_form_value" >
                            <?php
                            $tipos_email = Email::getTipos();
                            if(is_array($tipos_email))
                            {
                                foreach($tipos_email as $tipo)
                                {
                                    echo "<option value='".$tipo['id_tipo_email']."' >".$tipo['tipo_email']."</option>";
                                }
                            }
                            ?>                          
                            </select>
                        </div>
                        <div class="fixed_form_row">
                            <label>E-Mail:</label>
                            <input id="emailVal" type="text" class="fixed_form_value" />
                        </div>
                        <div class="fixed_form_row">
                            <input type="button" value="Aceptar" class="fixed_form_button" onClick="addEmail()" />
                        </div>
                    </div>
                </div>

                <div id="prompt_telefono" class="fixed_form" >
                    <div id="prompt_telefono_handle" class="fixed_form_handle">
                        <img src="../../media/iconos/icon_close.gif" alt="Cerrar" onClick="$(this).parent().parent().fadeOut();" />
                    </div>
                    <div class="fixed_form_content">
                        <div class="fixed_form_row">
                            <label>Tipo:</label>
                            <select id="tipo_telefonoVal" class="fixed_form_value" >
                            <?php
                                $tipos_telefono = Telefono::getTipos();
                                if(is_array($tipos_telefono))
                                {
                                    foreach($tipos_telefono as $tipo)
                                    {
                                        echo "<option value='".$tipo['id_tipo_telefono']."' >".$tipo['tipo_telefono']."</option>";
                                    }
                                }
                            ?>                                
                            </select>
                        </div>
                        <div class="fixed_form_row">
                            <label>Teléfono:</label>
                            <input id="telefonoVal" type="tel" class="fixed_form_value"  />
                        </div>
                        <div class="fixed_form_row">
                            <input type="button" value="Aceptar" class="fixed_form_button" onClick="addTelefono()" />
                        </div>
                    </div>
                </div>

                <div id="prompt_tutor" class="fixed_form" >
                    <div id="prompt_tutor_handle" class="fixed_form_handle">
                        <img src="../../media/iconos/icon_close.gif" alt="Cerrar" onClick="$(this).parent().parent().fadeOut();" />
                    </div>
                    <div class="fixed_form_content">
                        <div class="prompt_column">
                            <div class="fixed_form_row">
                                <label>Tipo:</label>
                                <select id="tipo_tutorVal" class="fixed_form_value" >
                                  <?php
                                    $tipos = Tutor::getTipos();
                                    if(is_array($tipos))
                                    {
                                        foreach($tipos as $tipo)
                                        {
                                            echo "<option value='".$tipo['id_tipo_tutor']."' >".$tipo['tipo_tutor']."</option>";
                                        }
                                    }
                                    ?>                               
                                </select>
                            </div>
                            <div class="fixed_form_row">
                                <label>Nombre:</label>
                                <input id="nombreTutorVal" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>Calle:</label>
                                <input id="calleTutorVal" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>Número:</label>
                                <input id="numeroTutorVal" type="text" class="fixed_form_value"  />
                            </div>
                        </div>
                        <div class="prompt_column">
                            <div class="fixed_form_row">
                                <label>Colonia:</label>
                                <input id="coloniaTutorVal" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>CP:</label>
                                <input id="CPTutorVal" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>Teléfonos:</label>
                                <input id="telefonosTutorVal" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>Celular:</label>
                                <input id="celularTutorVal" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <input type="button" value="Aceptar" class="fixed_form_button" onClick="addTutor()" />
                            </div>
                        </div>
                    </div>
                </div>

                <div id="prompt_tutor_modificar" class="fixed_form" >
                    <div id="prompt_tutor_handle_modificar" class="fixed_form_handle">
                        <img src="../../media/iconos/icon_close.gif" alt="Cerrar" onClick="$(this).parent().parent().fadeOut();" />
                    </div>
                    <div class="fixed_form_content">
                        <div class="prompt_column">
                            <div class="fixed_form_row">
                                <label>Nombre:</label>
                                <input id="nombreTutorVal_mdy" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>Calle:</label>
                                <input id="calleTutorValMdy" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>Número:</label>
                                <input id="numeroTutorValMdy" type="text" class="fixed_form_value"  />
                            </div>
                        </div>
                        <div class="prompt_column">
                            <div class="fixed_form_row">
                                <label>Colonia:</label>
                                <input id="coloniaTutorValMdy" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>CP:</label>
                                <input id="CPTutorValMdy" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>Teléfonos:</label>
                                <input id="telefonosTutorVal_mdy" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <label>Celular:</label>
                                <input id="celularTutorVal_mdy" type="text" class="fixed_form_value"  />
                            </div>
                            <div class="fixed_form_row">
                                <input type="button" id="boton_update" value="Aceptar" class="fixed_form_button" onClick="updateTutor()" />
                            </div>
                        </div>
                    </div>
                </div>

                <div id="prompt_modificar_direccion" class="fixed_form" >
                    <div id="prompt_modificar_direccion_handle" class="fixed_form_handle">
                        <img src="../../media/iconos/icon_close.gif" alt="Cerrar" onClick="$(this).parent().parent().fadeOut();" />
                    </div>
                    <div class="fixed_form_content">
                        <div class="fixed_form_row">
                            <label>Calle:</label>

                            <input id="calleValMdy" type="text" class="fixed_form_value"  />
                        </div>
                        <div class="fixed_form_row">
                            <label>Número:</label>
                            <input id="numeroValMdy" type="text" class="fixed_form_value"  />
                        </div>
                        <div class="fixed_form_row">
                            <label>Colonia:</label>
                            <select class="fixed_form_value" name="coloniaValMdy" id="coloniaValMdy" >
                               <?php
                                $colonias = Colonia::getColonias();
                                if(is_array($colonias))
                                {
                                    foreach($colonias as $colonia)
                                    {
                                        echo "<option value='".$colonia['id_colonia']."'>".$colonia['nombre']."</option>";
                                    }
                                }
                                ?>                          
                           </select>
                        </div>
                        <div class="fixed_form_row">
                            <label>CP:</label>
                            <input id="CPValMdy" type="text" class="fixed_form_value"  />
                        </div>
                        <div class="fixed_form_row">
                            <label>Club:</label>
                            <select class="fixed_form_value" name="ClubValMdy" id="ClubValMdy" >
                                <option></option>
								<?php
                                $clubs = Club::getClubs();
                                if(is_array($clubs))
                                {
                                    foreach($clubs as $club)
                                    {
                                        echo "<option value='".$club['id_club']."'>".$club['nombre']."</option>";
                                    }
                                }
                                ?>                           
                            </select>
                        </div>
                        <div class="fixed_form_row">
                            <label>CURP:</label>
                            <input id="CURPValMdy" type="text" class="fixed_form_value"  />
                        </div>
                        <div class="fixed_form_row">
                            <input type="button" id="boton_update" value="Aceptar" class="fixed_form_button" onClick="updateDireccion(this)" />
                        </div>
                    </div>
                </div>

            </div>
        </div><!--area_trabajo-->
		
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


        <!-- Dialogo para cambiar de grupo -->
        <div id="dialogo_cambio" title="Cambio de grupo" >
            <label>&#191;A que grupo desea cambiar al alumno?</label>
            <hr />
            <div class="dialogo_row">
                <label>Area</label>
                <select id="areaVal" onChange="loadGrados();">
                    <?php
                    $areas = Area::getLista($id_colegio);
                    if(is_array($areas))
                    {
                        foreach($areas as $area)
                        {
                            echo "<option value='".$area['id_area']."' >".$area['area']."</option>";
                        }
                    }
                    ?>               
                </select>
            </div>
            <div class="dialogo_row">
                <label>Grado</label>
                <select id="gradoVal" onChange="loadGrupos();">
                    <!-- AJAX -->
                </select>
            </div>
            <div class="dialogo_row">
                <label>Grupo</label>
                <select id="nuevoGrupoVal">
                    <!-- AJAX -->
                </select>
            </div>

            <button onClick="aceptarCambioClicked(this)">Aceptar</button>
            <!--<input type="button" value="Aceptar" onclick="aceptarCambioClicked(this)" />-->
        </div>
        <!-- -------Fin del dialogo------- -->

        <!-- Dialogo nutrición -->
        <div id="nuevo_registro_nut">
            <div class="dialogo_row">
                <label>Peso</label>
                <input type="text" id="nuevoPesoVal" />
            </div>
            <div class="dialogo_row">
                <label>Talla</label>
                <input type="text" id="nuevaTallaVal" />
            </div>
            <div class="dialogo_row">
                <label>IMC</label>
                <input type="text" id="nuevoIMCVal" />
            </div>
            <span>NOTA. Puedes dejar los campos vacios y no se har&aacute; cambio al valor actual</span>
            <button type="button" onClick="nuevoRegistroNut()">Aceptar</button>
        </div>
        <!-- Fin dialogo nutrición -->

        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>-->
		<script src="../../librerias/jquery.min.js"></script>
		<script src="../../librerias/jquery.dataTables.min.js" ></script>
        <script src="../../librerias/fnAjaxReload.js" ></script>
        <!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>-->
		<script src="../../librerias/jquery-ui.min.js" ></script>
		<script src="../../librerias/jquery.form.js"></script>
		
		
		
		<script>
        var id_alumno = <?php echo $id_alumno; ?>;
        var id_ciclo = <?php echo $ciclo->id_ciclo_escolar ?>;
        var id_tipo_tutor;
        var tablaCalificaciones;
        
        /** Document ready */
        $("#prompt_modificar_direccion").draggable({ handle: "#prompt_modificar_direccion_handle" });
        $("#dialogo_cambio").dialog({ autoOpen: false });
        $("#nuevo_registro_nut").dialog({ autoOpen: false });
        declararDataTables();
        $("#prompt_email").draggable({ handle: "#prompt_email_handle" });
        $("#prompt_telefono").draggable({ handle: "#prompt_telefono_handle" });
        $("#prompt_tutor").draggable({ handle: "#prompt_tutor_handle" });
        $("#prompt_tutor_modificar").draggable({ handle: "#prompt_tutor_handle_modificar" });
        

        /** Cosas del Ajax image loader */
        var f = $('#form_imagen');
        var l = $('#loader'); // loder.gif image
        var b = $('#button'); // upload button
        var imagen;

        b.click(function(){
            // implement with ajaxForm Plugin
            f.ajaxForm({
                beforeSend: function(){
                    l.show();
                    b.attr('disabled', 'disabled');
                },
                success: function(img){
                    l.hide();
                    f.resetForm();
                    b.removeAttr('disabled');

                    asignarFoto(img);
                },
                error: function(e){
                    b.removeAttr('disabled');
                }
            });
        });

        function reloadCalis()
        {
            tablaCalificaciones.fnReloadAjax();
        }

        function asignarFoto(img)
        {
            if(img == "photo_NA.jpg") alert("La foto debe de tener un tamaño no mayor a 400kb y tener una terminación .jpg, .jpeg, .gif o .png");
            $.ajax({
                type: "POST",
                url: "../../includes/acciones/personas/asignar_foto.php",
                data: "id_persona=" + id_alumno + "&imagen=" + img,
                success: function (data)
                {
                    document.location.reload(true);
                }
            });
        }

        function cambiarNombresClicked()
        {
            var nuevosNombres = prompt("Nombres ", "");
            if(nuevosNombres !== null)
            {
                if(nuevosNombres.length > 2)
                {
                    if(confirm("¿Seguro que desea cambiar el nombre del alumno a: " + nuevosNombres))
                    {
                        $.post("../../includes/acciones/personas/cambiar_nombres.php", {id_persona:id_alumno, nombres:nuevosNombres}, function (data)
                        {
                            document.location.reload(true);
                        });
                    }
                }
            }
        }

        function cambiarApellidoPaternoClicked()
        {
            var nuevoApellidoPaternoNuevo = prompt("Apellido paterno ", "");
            if(nuevoApellidoPaternoNuevo !== null)
            {
                if(nuevoApellidoPaternoNuevo.length > 2)
                {
                    if(confirm("¿Seguro que desea cambiar el apellido paterno del alumno a: " + nuevoApellidoPaternoNuevo))
                    {
                        $.post("../../includes/acciones/personas/cambiar_apellido_paterno.php", {id_persona:id_alumno, apellido:nuevoApellidoPaternoNuevo}, function (data)
                        {
                            document.location.reload(true);
                        });
                    }
                }
            }
        }

        function cambiarApellidoMaternoClicked()
        {
            var nuevaApellidoMaternoNuevo = prompt("Apellido materno ", "");
            if(nuevaApellidoMaternoNuevo !== null)
            {
                if(nuevaApellidoMaternoNuevo.length > 2)
                {
                    if(confirm("¿Seguro que desea cambiar el apellido materno del alumno a: " + nuevaApellidoMaternoNuevo))
                    {
                        $.post("../../includes/acciones/personas/cambiar_apellido_materno.php", {id_persona:id_alumno, apellido:nuevaApellidoMaternoNuevo}, function (data)
                        {
                            document.location.reload(true);
                        });
                    }
                }
            }
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

            $.post("../../includes/acciones/grupos/print_select_grupos.php", { id_ciclo:id_ciclo, id_grado: id_grado }, function (data)
            {
                $("#nuevoGrupoVal").html(data);
            });
        }

        function updatePapeleria(boton)
        {
            $(boton).attr('disabled', 'disabled');

            var papeleria = [];
            $(".documento").each(function(){
                var documento = {};
                documento.id_documento  = $(this).find('.id_documento').val();
                documento.original      = $(this).find('.original').prop('checked') ? 1 : 0;
                documento.copia         = $(this).find('.copia').prop('checked') ? 1 : 0;
                papeleria.push(documento);
            });

            $.ajax({
                type: "POST",
                url: "../../includes/acciones/alumnos/updatePapeleriaAJAX.php",
                data: "id_alumno=" + id_alumno + "&papeleria=" + JSON.stringify(papeleria),
                success: function (data)
                {
                    if(data == 1) document.location.reload(true);
                    else alert("Error al actualizar la papeleria");
                }
            });
        }

        function modificarTutor(caller)
        {
            var tutor = {};
            id_tipo_tutor = $(caller).parent(0).parent(0).children('.id_tipo_tutor').val();
            tutor.nombre        = $(caller).parent(0).parent(0).children('.nombre').html();
            tutor.calle         = $(caller).parent(0).parent(0).children('.calle').html();
            tutor.numero        = $(caller).parent(0).parent(0).children('.numero').html();
            tutor.colonia       = $(caller).parent(0).parent(0).children('.colonia').html();
            tutor.CP            = $(caller).parent(0).parent(0).children('.CP').html();
            tutor.telefonos     = $(caller).parent(0).parent(0).children('.telefonos').html();
            tutor.celular       = $(caller).parent(0).parent(0).children('.celular').html();

            $("#nombreTutorVal_mdy").val(tutor.nombre);
            $("#calleTutorValMdy").val(tutor.calle);
            $("#numeroTutorValMdy").val(tutor.numero);
            $("#coloniaTutorValMdy").val(tutor.colonia);
            $("#CPTutorValMdy").val(tutor.CP);
            $("#telefonosTutorVal_mdy").val(tutor.telefonos);
            $("#celularTutorVal_mdy").val(tutor.celular);

            console.dir(tutor);
            $("#prompt_tutor_modificar").fadeIn("slow");
        }

        function updateTutor()
        {
            $("#boton_update").attr('disabled','disabled');
            var tutor = {};
            tutor.id_alumno     = id_alumno;
            tutor.id_tipo_tutor = id_tipo_tutor;
            tutor.nombre        = $("#nombreTutorVal_mdy").val();
            tutor.calle         = $("#calleTutorValMdy").val();
            tutor.numero        = $("#numeroTutorValMdy").val();
            tutor.colonia       = $("#coloniaTutorValMdy").val();
            tutor.CP            = $("#CPTutorValMdy").val();
            tutor.telefonos     = $("#telefonosTutorVal_mdy").val();
            tutor.celular       = $("#celularTutorVal_mdy").val();

            $.ajax({
                type: "POST",
                url: "../../includes/acciones/alumnos/updateTutorAJAX.php",
                data: "datos=" + JSON.stringify(tutor),
                success: function (data)
                {
                    if(data == 1) document.location.reload(true);
                    else alert("Error al actualizar datos del tutor");
                }
            });
        }

        function mostrarMdyDireccion()
        {
            $("#calleValMdy").val('');
            $("#numeroValMdy").val('');
            $("#coloniaValMdy option").filter(function(){
                return $(this).text() == "";
            }).prop('selected', true);
            $("#CPValMdy").val('');

            $("#ClubValMdy option").filter(function(){
                return $(this).text() == "";
            }).prop('selected', true);
            $("#CURPValMdy").val('');

            $("#prompt_modificar_direccion").fadeIn();
        }

        function updateDireccion(boton)
        {
            $(boton).attr('disabled','disabled');

            var calle   = $("#calleValMdy").val();
            var numero  = $("#numeroValMdy").val();
            var colonia = $("#coloniaValMdy").val();
            var CP      = $("#CPValMdy").val();

            var club    = $("#ClubValMdy").val();
            var CURP    = $("#CURPValMdy").val();

            $.ajax({
                type: "POST",
                url: "../../includes/acciones/personas/update_direccion.php",
                data: "id_persona=" + id_alumno + "&calle=" + calle
                    + "&numero=" + numero + "&colonia=" + colonia + "&CP=" + CP,
                success: function (data)
                {
                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/alumnos/update_club_curp.php",
                        data: "id_persona=" + id_alumno + "&club=" + club + "&CURP=" + CURP,
                        success: function (data)
                        {
                            document.location.reload(true);
                        }
                    });
                }
            });


        }

        function perfilCuentas()
        {
            console.log("perfilCuentas()");
            var id_ciclo_escolar = $("#ciclo_escolarCuentasVal").val();
            document.location.href = "perfil_cuentas.php?id_alumno=" + id_alumno + "&ciclo=" + id_ciclo_escolar;
        }

        function cambiarGrupoClicked()
        {
            $("#dialogo_cambio").dialog( "open" );
        }

        function cambiarPasswordClicked()
        {
            var pass_nuevo = prompt("Contraseña nueva: ");
            if(pass_nuevo !== null)
            {
                if(pass_nuevo.length > 3)
                {
                    if(confirm("¿Desea cambiar la contraseña a '" + pass_nuevo + "'?"))
                    {
                        $.post("../../includes/acciones/personas/cambiar_password.php", {id_persona:id_alumno, passwordVal:pass_nuevo, password2Val:pass_nuevo}, function (data)
                        {
                            document.location.reload(true);
                        });
                    }
                }
                else
                {
                    alert("El nuevo password debe de contener al menos 4 caracteres");
                }
            }
        }

        function aceptarCambioClicked(caller)
        {
            var id_grupo = $("#nuevoGrupoVal").val();
            if(id_grupo != '' && id_grupo != null)
            {
                if(confirm("¿Desea cambia de grupo al alumno?"))
                {
                    $(caller).attr('disabled', 'disabled');

                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/alumnos/cambiar_grupo.php",
                        data: "id_alumno=" + id_alumno + "&id_grupo=" + id_grupo,
                        success: function (data)
                        {
							if(data == 1)
                            {
                                alert("Cambio completado.");
                                document.location.reload(true);
                            }
                        }
                    });
                }
            }
        }

        function getURLParameter(name)
        {
            return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [, ""])[1].replace(/\+/g, '%20')) || null
        }

        function declararDataTables() {
            tablaCalificaciones = $("#tabla_calificaciones").dataTable({
			    
                "paginate": false,
                "language": {
                        "lengthMenu": "Mostrar _MENU_ materias por página",
                        "zeroRecords": "No se encontraron materias",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ materias",
                        "infoEmpty": "Mostrando 0 a 0 de 0 materias",
                        "infoFiltered": "(Encontrados de _MAX_ materias)"
                },
                "columns": [
                    {"width": "40%"}, {"width": "10%"}, {"width": "10%"},
                    {"width": "10%"}, {"width": "10%"}, {"width": "10%"},
                    {"width": "10%"}
                ],
                
                "bProcessing": true,
				"sAjaxSource": '../../includes/acciones/alumnos/get_calificaciones_ciclo.php',
				"fnServerParams": function (aoData) {
				    var id_ciclo = $("#ciclo_escolarVal").val();
                    var id_persona = <?php echo $alumno->id_persona; ?>;
                    aoData.push({"name": "id_ciclo", "value": id_ciclo});
                    aoData.push({"name": "id_persona", "value": id_persona});
                }
            });
		}

        var id_alumno = getURLParameter("id_alumno");

        function baja(id_persona)
        {
            if (confirm("¿Está seguro que desea dar de baja al alumno?"))
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/baja.php",
                    data: "id_persona=" + id_persona,
                    success: function (data)
                    {
                        if (data == 1)
                        {
                            window.location.reload(true);
                        }
                    }
                });
            }
        }

        function toggleEmail()
        {
            $("#prompt_email").fadeIn();
        }

        function addEmail()
        {
            var email = $("#emailVal").val();
            var tipo_email = $("#tipo_emailVal").val();

            if (email.length > 0)
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/agregar_email.php",
                    data: "id_alumno=" + id_alumno + "&email=" + email + "&tipo_email=" + tipo_email,
                    success: function (data)
                    {
                        if (data == 1)
                        {
                            window.location.reload(true);
                        }
                    }
                });
            }
            else
            {
                alert("No ingresó ningún correo electrónico");
            }
        }

        function toggleTelefono()
        {
            $("#prompt_telefono").fadeIn();
        }

        function toggleTutor()
        {
            $("#prompt_tutor").fadeIn();
        }

        function addTelefono()
        {
            var telefono = $("#telefonoVal").val();
            var tipo_telefono = $("#tipo_telefonoVal").val();

            if (telefono.length > 0)
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/agregar_telefono.php",
                    data: "id_alumno=" + id_alumno + "&telefono=" + telefono + "&tipo_telefono=" + tipo_telefono,
                    success: function (data)
                    {
                        if (data == 1)
                        {
                            window.location.reload(true);
                        }
                    }
                });
            }
            else
            {
                alert("No ingresó ningún teléfono");
            }
        }

        function addTutor()
        {
            if(confirm("¿Seguro que desea agregar el tutor?"))
            {
                var tipo_tutor  = $("#tipo_tutorVal").val();
                var nombre      = $("#nombreTutorVal").val();
                var calle       = $("#calleTutorVal").val();
                var numero      = $("#numeroTutorVal").val();
                var colonia     = $("#coloniaTutorVal").val();
                var CP          = $("#CPTutorVal").val();
                var telefonos   = $("#telefonosTutorVal").val();
                var celular     = $("#celularTutorVal").val();

                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/alumnos/agregar_tutor.php",
                    data: "id_persona=" + id_alumno + "&tipo_tutor=" + tipo_tutor + "&nombre=" + nombre +
                        "&calle=" + calle + "&numero=" + numero + "&colonia=" + colonia
                        + "&CP=" + CP + "&telefonos=" + telefonos + "&celular=" + celular,
                    success: function (data)
                    {
                        if(data == 1) window.location.reload(true);
                        else alert("Código de error: " + data);
                    }
                });
            }
        }

        function nuevoRegistroNut()
        {
            var peso = $("#nuevoPesoVal").val();
            var talla = $("#nuevaTallaVal").val();
            var IMC = $("#nuevoIMCVal").val();

            if(confirm("¿Desea agregar el nuevo registro de nutrición?"))
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/personas/nuevo_registro_nutricion.php",
                    data: "id_persona=" + id_alumno + "&peso=" + peso + "&talla=" + talla + "&IMC=" + IMC,
                    success: function (data)
                    {
                        $('#nuevo_registro_nut').dialog('close');
                        document.location.reload(true);
                    }
                });
            }
        }
		
		
        </script>	
		
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