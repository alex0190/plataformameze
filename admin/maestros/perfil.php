<?php

include_once("../../includes/clases/class_lib.php");
extract($_GET);
# id_maestro

$maestro = new Maestro($id_maestro);
if(is_null($maestro->id_persona)){ header('Location: index.php'); exit; } 
$emails = $maestro->getEmails();
$telefonos = $maestro->getTelefonos();
$clases = $maestro->getClasesCiclo();
$escolaridad = $maestro->getEscolaridad();
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
      <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>Sistema Integral Meze - Perfil del Maestro</title>
    <!-- lib-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic">
   
    <meta name="viewport" content="width=device-width, initial-scale=1">
		
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
        <link rel="stylesheet" href="../../estilo/perfil_maestro.css" />
		<link rel="stylesheet" href="../../estilo/formas_extensas.css" />
        <link rel="stylesheet" href="../../estilo/fixed_form.css" />
		<style>
            #prompt_email, #prompt_telefono
            {
                width: 200px;
                height: 100px;
                position: fixed;
                top: 150px;
                left: 40%;
                border: 1px solid #CCC;
                background-color: #FFF;
                padding: 10px;
                display: none;
            }

            #nuevo_registro_nut
            {
                font-size: 12px;
            }

            

            #prompt_modificar_direccion, #prompt_modificar_escolaridad
            {
                width: 400px;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="../../librerias/jquery.ocupload-1.1.2.packed.js"></script>
        <script src="../../librerias/htmlbarcode.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="../../librerias/jquery.form.js"></script>
        <script>
            var id_maestro;

            $(document).ready(function ()
            {
                id_maestro = $("#id_maestroVal").val();

                get_object("barcode").innerHTML = DrawCode39Barcode($("#matriculaVal").val(), 0);
                $("#tabs").tabs();

            });

            

            function getURLParameter(name)
            {
                return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [, ""])[1].replace(/\+/g, '%20')) || null
            }

            var id_maestro = getURLParameter("id_maestro");
            function baja(id_persona)
            {
                if (confirm("¿Está seguro que desea dar de baja al maestro? Una vez dado de baja no se le podrá asignar una nueva clase"))
                {
                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/maestros/baja.php",
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

            function mostrarPassword()
            {
                alert($("#param_password").val());
            }

            function toggleEmail()
            {
                $("#prompt_email").fadeIn();
            }

            function addEmail(caller)
            {
                var email = $("#emailVal").val();
                var tipo_email = $("#tipo_emailVal").val();

                if (email.length > 0)
                {
                    $(caller).attr('disabled', 'disabled');

                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/maestros/agregar_email.php",
                        data: "id_maestro=" + id_maestro + "&email=" + email + "&tipo_email=" + tipo_email,
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
                    $(caller).removeAttr('disabled');
                }
            }

            function toggleTelefono()
            {
                $("#prompt_telefono").fadeIn();
            }

            function addTelefono()
            {
                var telefono = $("#telefonoVal").val();
                var tipo_telefono = $("#tipo_telefonoVal").val();

                if (telefono.length > 0)
                {
                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/maestros/agregar_telefono.php",
                        data: "id_maestro=" + id_maestro + "&telefono=" + telefono + "&tipo_telefono=" + tipo_telefono,
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

            function get_object(id)
            {
                var object = null;
                if (document.layers)
                {
                    object = document.layers[id];
                }
                else if (document.all)
                {
                    object = document.all[id];
                }
                else if (document.getElementById)
                {
                    object = document.getElementById(id);
                }
                return object;
            }

            function modificarNombresClicked()
            {
                var nombres = prompt("Nombres:");
                if(nombres.length > 0)
                {
                    $.post("../../includes/acciones/maestros/cambiar_nombres.php", {id_maestro:id_maestro, nombres:nombres}, function (data)
                    {
						if(data == 1) window.location.reload();
                        else { alert("Error al actualizar los datos"); }
                    });
                }
            }

            function modificarPaternoClicked()
            {
                var apellido_paterno = prompt("Apellido paterno:");
                if(apellido_paterno.length > 0)
                {
                    $.post("../../includes/acciones/maestros/cambiar_apellido_paterno.php", {id_maestro:id_maestro, apellido_paterno:apellido_paterno}, function (data)
                    {
                        if(data == 1) window.location.reload();
                        else { alert("Error al actualizar los datos"); }
                    });
                }
            }

        function modificarMaternoClicked()
        {
            var apellido_materno = prompt("Apellido materno:");
            if(apellido_materno.length > 0)
            {
                $.post("../../includes/acciones/maestros/cambiar_apellido_materno.php", {id_maestro:id_maestro, apellido_materno:apellido_materno}, function (data)
                {
                    if(data == 1) window.location.reload();
                    else { alert("Error al actualizar los datos"); }
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
                  <div class="display-6">Perfil del Maestro</div>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
          <div class="container-fluid">
        <div class="panel-wrapper">
		
		<div class="panel">
              <div class="panel-body">
			    <div id="principal">
            <div id="area_trabajo">
				<input type="hidden" id='param_password' value="<?php echo $maestro->password; ?>" />
                <input type="hidden" id="id_maestroVal" value="<?php echo $maestro->id_persona; ?>" />
                <input type="hidden" id="matriculaVal" value="<?php echo $maestro->matricula; ?>" />
				
                <div id="wrapper_top" >
                    <div id="profile_picture">

                        <div id="profile_picture_inner">
                            <img src="../../media/fotos/<?php echo $maestro->foto; ?>" alt="N/A" id="foto_maestro" />
                        </div>

                    </div>

                    <div id="datos_generales">
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">Nombre(s):</div>
                            <div class="datos_generales_value">
                                <img src="../../media/iconos/icon_modify.png" style="width: 15px;" onclick="modificarNombresClicked();" />
                                <?php echo $maestro->nombres; ?>
                            </div>
                        </div>
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">Apellido paterno:</div>
                            <div class="datos_generales_value">
                                <img src="../../media/iconos/icon_modify.png" style="width: 15px;" onclick="modificarPaternoClicked();" />
                                <?php echo $maestro->apellido_paterno; ?>
                            </div>
                        </div>
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">Apellido materno:</div>
                            <div class="datos_generales_value">
                                <img src="../../media/iconos/icon_modify.png" style="width: 15px;" onclick="modificarMaternoClicked();" />
                                <?php echo $maestro->apellido_materno; ?>
                            </div>
                        </div>
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">Matricula:</div>
                            <div class="datos_generales_value"><?php echo $maestro->matricula; ?></div>
                        </div>
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">Registrad@ desde:</div>
                            <div class="datos_generales_value"><?php echo $maestro->fecha_alta; ?></div>
                        </div>
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">Contrase&ntilde;a:</div>
                            <div class="datos_generales_value">
                                <input type="button" onclick="mostrarPassword()" value="Mostrar" />
                            </div>
                        </div>
                        <?php
                        if($maestro->getEstado())
                        {
                            echo '
                                <div class="datos_generales_row">
                                    <div class="datos_generales_label">Estado:</div>
                                    <div class="datos_generales_value" style="color: green">
                                        Activo
                                        <img src="../../media/iconos/icon_close.gif" alt="Baja" onclick="baja('.$maestro->id_persona.')" />
                                    </div>
                                </div>
                            ';
                        }
                        else
                        {
                            echo '
                                <div class="datos_generales_row">
                                    <div class="datos_generales_label">Fecha de baja:</div>
                                    <div class="datos_generales_value">'.$maestro->fecha_baja.'</div>
                                </div>
                                <div class="datos_generales_row">
                                    <div class="datos_generales_label">Estado:</div>
                                    <div class="datos_generales_value" style="color: red">Inactivo</div>
                                </div>
                            ';
                        }
                        ?>
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">Peso:</div>
                            <div class="datos_generales_value">
                                <?php echo $maestro->getPeso(); ?>
                                <img src="../../media/iconos/icon_modify.png"
                                     ALT="M" onclick="mostrarNutricion()"
                                     style="width: 15px" title="Cambiar grupo" />
                            </div>
                        </div>
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">Talla:</div>
                            <div class="datos_generales_value">
                                <?php echo $maestro->getTalla(); ?>
                            </div>
                        </div>
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">IMC:</div>
                            <div class="datos_generales_value">
                                <?php echo $maestro->getIMC(); ?>
                            </div>
                        </div>
                        <div class="datos_generales_row">
                            <div class="datos_generales_label">Colegio:</div>
                            <div class="datos_generales_value">
                                <?php echo $maestro->getColegios(); ?>
                            </div>
                        </div>
                    </div>

                    <div id="barcode"></div>

                    <img 
                        id="qr_code"
                        alt ="<?php echo $maestro->matricula; ?>" 
                        src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?php echo $maestro->matricula; ?>&chld=L|0"  
						width="150" height="150"
                    />

                    <div id="panel_imagen">
                        <!-- loader.gif -->
                        <img style="display:none" id="loader" src="../../media/imagenes/loader.gif" alt="Cargando...." title="Cargando...." />
                        <!-- simple file uploading form -->
                        <form id="form_imagen" action="../../includes/ajaxupload.php" method="post" enctype="multipart/form-data">
                            <input id="uploadImage" type="file" accept="image/*" name="image" value="Seleccionar foto"/>&nbsp;&nbsp;
                            <input id="button" type="submit" value="Subir" class="btn btn-warning" style="margin-top:10px;">
                        </form>
                    </div>

                </div>

                <ul role="tablist" class="nav nav-pills nav-justified text-uppercase">
                    <li class="nav-item"><a href="#demo3tab-1" aria-controls="demo3tab-1" role="tab" data-toggle="tab" class="nav-link active">Clases</a></li>
                    <li class="nav-item"><a href="#demo3tab-2" aria-controls="demo3tab-2" role="tab" data-toggle="tab" class="nav-link">E-Mails</a></li>
					<li class="nav-item"><a href="#demo3tab-3" aria-controls="demo3tab-3" role="tab" data-toggle="tab" class="nav-link">Tel&eacute;fonos</a></li>
					<li class="nav-item"><a href="#demo3tab-4" aria-controls="demo3tab-4" role="tab" data-toggle="tab" class="nav-link">Direcci&oacute;n</a></li>
					<li class="nav-item"><a href="#demo3tab-5" aria-controls="demo3tab-5" role="tab" data-toggle="tab" class="nav-link">Escolaridad</a></li>
					
                </ul>
                    <div class="tab-content">
					<div role="tabpanel" id="demo3tab-1" class="tab-pane p-y-2 active fade in">
                        <table data-plugin="DataTable" class="table">
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
                        <table data-plugin="DataTable" class="table">
                            <thead>
                                <tr>
                                    <th>Tipo de correo electrónico</th>
                                    <th>Correo electrónico</th>
                                    <th></th>
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
                                                <a href='../../includes/acciones/maestros/eliminar_email.php?id_email=".$email['id_email']."' >
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
                        <img src="../../media/iconos/icon_add.png" alt="Nuevo" style="float: right;" onclick="toggleEmail();" />
                    </div>
                    <div role="tabpanel" id="demo3tab-3" class="tab-pane p-y-2 fade in">
                        <table data-plugin="DataTable" class="table">
                            <thead>
                            <tr>
                                <th>Tipo de teléfono</th>
                                <th>Teléfono</th>
                                <th></th>
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
                                                <a href='../../includes/acciones/maestros/eliminar_telefono.php?id_telefono=".$telefono['id_telefono']."' >
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
                        <img src="../../media/iconos/icon_add.png" style="float: right;" alt="Nuevo" onclick="toggleTelefono();" />
                    </div>
                    <div role="tabpanel" id="demo3tab-4" class="tab-pane p-y-2 fade in">
                        <?php $direccion = $maestro->getDireccion(); ?>
                        
                            <label>Calle</label>
                            <input type="text" value="<?php echo $direccion['calle']; ?>" class="form-control" readonly />
                        
                            <label>Número</label>
                            <input type="text" value="<?php echo $direccion['numero']; ?>" class="form-control" readonly />
                       
                            <label>Colonia</label>
                            <input type="text" value="<?php echo $direccion['colonia']; ?>" class="form-control" readonly />
                        
                        
                            <label>CP</label>
                            <input type="text" value="<?php echo $direccion['CP']; ?>" class="form-control" />
                        
                        <img src="../../media/iconos/icon_modify.png" style="width: 15px; float: right;" alt="M" onclick="mostrarModificarDireccion()" />
                    </div>
                    <div role="tabpanel" id="demo3tab-5" class="tab-pane p-y-2 fade in">
                        
                            <label class="form_label">T&iacute;tulo</label>
                            <input type="text" class="form-control" value="<?php echo $escolaridad['titulo']; ?>" readonly />
                        
                            <label class="form_label">Egresado de</label>
                            <input type="text" class="form-control" value="<?php echo $escolaridad['egresadode']; ?>" readonly />
                       
                            <label class="form_label">A&ntilde;o</label>
                            <input type="text" class="form-control" value="<?php echo $escolaridad['ano']; ?>" readonly />
                       
                        <img src="../../media/iconos/icon_modify.png" style="width: 15px; float: right;" alt="M" onclick="mostrarModificarEscolaridad()" />
                    </div>
                </div><!--fin tabs-->

                <div id="prompt_email" style="height:230px; width:250px; box-shadow: 2px 2px 10px #5f5f5f;">
                    <label>E-Mail:</label>
                    <input id="emailVal" type="email" class="form-control"  />
                    <label>Tipo:</label>
                    <select id="tipo_emailVal" class="form-control" >
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
                    <input type="button" value="Aceptar"  class="btn btn-primary btn-small" style="float: left; width: 40%; margin: 10px;" onclick="addEmail(this)" />
                    <input type="button" value="Cancelar" class="btn btn-danger btn-small" style="float: right; width: 40%; margin: 10px;" onclick="$(this).parent().fadeOut();"/>
                </div>

                 <div id="prompt_telefono" style="height:230px; width:250px; box-shadow: 2px 2px 10px #5f5f5f;">
                    <label>Teléfono:</label>
                    <input id="telefonoVal" type="tel" class="form-control"  />
                    <label>Tipo:</label>
                    <select id="tipo_telefonoVal" class="form-control"  >
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
                    <input type="button" value="Aceptar"  class="btn btn-primary btn-small" style="float: left; width: 40%; margin: 10px;" onclick="addTelefono()" />
                    <input type="button" value="Cancelar"  class="btn btn-danger btn-small" style="float: right; width: 40%; margin: 10px;" onclick="$(this).parent().fadeOut();"/>
                </div>

                <div id="prompt_modificar_direccion" class="fixed_form" style="box-shadow: 2px 2px 10px #5f5f5f;" >
                    <div id="prompt_modificar_direccion_handle" class="fixed_form_handle">
                        <img src="../../media/iconos/icon_close.gif" alt="Cerrar" onclick="$(this).parent().parent().fadeOut();" />
                    </div>
                    <div class="fixed_form_content">
                        <div class="fixed_form_row">
                            <label>Calle:</label>
                            <input id="calleValMdy" type="text" class="fixed_form_value form-control"  />
                        </div>
                        <div class="fixed_form_row">
                            <label>Número:</label>
                            <input id="numeroValMdy" type="text" class="fixed_form_value form-control"  />
                        </div>
                        <div class="fixed_form_row">
                            <label>Colonia:</label>
                            <select class="form_input form-control" name="coloniaValMdy" id="coloniaValMdy" required >
                                <?php
                                $colonias = Colonia::getColonias();
                                if(is_array($colonias))
                                {
                                    foreach($colonias as $colonia)
                                    {
                                        echo "<option value='".$colonia['id_colonia']."' >".$colonia['nombre']."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="fixed_form_row">
                            <label>CP:</label>
                            <input id="CPValMdy" type="text" class="fixed_form_value form-control"  />
                        </div>
                        <div class="fixed_form_row">
                            <input type="button" id="boton_update" value="Aceptar" class="btn btn-primary btn-block" onclick="updateDireccion(this)" />
                        </div>
                    </div>
                </div>

                <!-- MODIFICAR ESCOLARIDAD -->

                <div id="prompt_modificar_escolaridad" class="fixed_form" style="box-shadow: 2px 2px 10px #5f5f5f;" >
                    <div id="prompt_modificar_direccion_handle" class="fixed_form_handle">
                        <img src="../../media/iconos/icon_close.gif" alt="Cerrar" onclick="$(this).parent().parent().fadeOut();" />
                    </div>
                    <div class="fixed_form_content">
                        <div class="fixed_form_row">
                            <label>Título:</label>
                            <input id="tituloValMdy" type="text" class="fixed_form_value form-control"  />
                        </div>
                        <div class="fixed_form_row">
                            <label>Egresado de:</label>
                            <input id="egresadoDeValMdy" type="text" class="fixed_form_value form-control"  />
                        </div>
                        <div class="fixed_form_row">
                            <label>Año:</label>
                            <input id="anoValMdy" type="text" class="fixed_form_value form-control"  />
                        </div>

                        <div class="fixed_form_row">
                            <input type="button" id="boton_update" value="Aceptar" class="btn btn-primary btn-block" onclick="updateEscolaridad(this)" />
                        </div>
                    </div>
                </div>

                <!-- --------------------- -->
				

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
            <span>NOTA. Puedes dejar los campos vacios y no se hará cambio al valor actual</span>
            <button type="button" class="btn btn-primary" onclick="nuevoRegistroNut()">Aceptar</button>
        </div>
        <!-- Fin dialogo nutrición -->
		

            </div><!--fin trabajo-->
        </div><!--fin principal-->
	    
	      </div>
	    </div>
		</div>
		  </div>
   </div>
   
    <!-- WEB PERLOAD-->
    <div id="preload">
      <ul class="loading">
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>
		
     <script>
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
		
		function asignarFoto(img)
        {
            if(img == "photo_NA.jpg") alert("La foto debe de tener un tamaño no mayor a 400kb y tener una terminación .jpg, .jpeg, .gif o .png");
            $.ajax({
                type: "POST",
                url: "../../includes/acciones/personas/asignar_foto.php",
                data: "id_persona=" + id_maestro + "&imagen=" + img,
                success: function (data)
                {
                    document.location.reload(true);
                }
            });
        }
	</script>
	<script>
	    $("#nuevo_registro_nut").dialog({ autoOpen: false });
	   
	    function mostrarNutricion()
		{
		  $("#nuevo_registro_nut").dialog('open');
		}
	</script>
	<script>
       $("#prompt_modificar_direccion").draggable({ handle: "#prompt_modificar_direccion_handle" });

        function mostrarModificarDireccion()
        {
            $("#calleValMdy").val('<?php echo $direccion['calle']; ?>');
            $("#numeroValMdy").val('<?php echo $direccion['numero']; ?>');
            $("#coloniaValMdy").val('<?php echo $direccion['colonia']; ?>');
            $("#CPValMdy").val('<?php echo $direccion['CP']; ?>');

            $("#prompt_modificar_direccion").fadeIn();
        }

        function mostrarModificarEscolaridad()
        {
            $("#tituloValMdy").val('<?php echo $escolaridad['titulo']; ?>');
            $("#egresadoDeValMdy").val('<?php echo $escolaridad['egresadode']; ?>');
            $("#anoValMdy").val('<?php echo $escolaridad['ano']; ?>');

            $("#prompt_modificar_escolaridad").fadeIn();
        }

        function updateDireccion(boton)
        {
            $(boton).attr('disabled','disabled');

            var calle   = $("#calleValMdy").val();
            var numero  = $("#numeroValMdy").val();
            var colonia = $("#coloniaValMdy").val();
            var CP      = $("#CPValMdy").val();

            $.ajax({
                type: "POST",
                url: "../../includes/acciones/maestros/updateDireccionAJAX.php",
                data: "id_maestro=" + id_maestro + "&calle=" + calle
                    + "&numero=" + numero + "&colonia=" + colonia + "&CP=" + CP,
                success: function (data)
                {
                    document.location.reload(true);
                }
            });
        }

        function updateEscolaridad(boton)
        {
            $(boton).attr('disabled','disabled');

            var titulo      = $("#tituloValMdy").val();
            var egresadoDe  = $("#egresadoDeValMdy").val();
            var ano         = $("#anoValMdy").val();

            $.ajax({
                type: "POST",
                url: "../../includes/acciones/maestros/updateEscolaridadAJAX.php",
                data: "id_maestro=" + id_maestro + "&titulo=" + titulo + "&egresadoDe=" + egresadoDe + "&ano=" + ano,
                success: function (data)
                {
                    document.location.reload(true);
                }
            });
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
                    data: "id_persona=" + id_maestro + "&peso=" + peso + "&talla=" + talla + "&IMC=" + IMC,
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