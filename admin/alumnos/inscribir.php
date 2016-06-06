<?php
$id_modulo = 7; // Alumnos - Inscribir

include_once("../../includes/clases/class_lib.php");


$tipos_tutor = Tutor::getTipos();
$ocupaciones = Tutor::getOcupaciones();
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8" />
    <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <title>Sistema Integral Meze - Inscribir Alumno</title>
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
        <link rel="stylesheet" href="../../estilo/formas_extensas.css" />
        <link rel="stylesheet" href="../../estilo/inscribir_alumno.css" />
		
        <!--<script src="../../scripts/jquery.js" type="text/javascript"></script>-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
		<!--<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>-->
        <script src="../../librerias/messages_es.js"></script>    
        <script>
            var tutor_string = "" +
                "<div class='tutor' >" +
                    "<img src='../../media/imagenes/tutor.gif' class='imagen_tutor' />" +
                    "<div class='tutor_info_div_sm' >" +
                        "<label>Tipo de tutor</label>" +
                        "<?php
                        echo "<select class='tipo_tutor'>";
                        if(is_array($tipos_tutor))
                        {
                            foreach($tipos_tutor as $tipo)
                            {
                                echo "<option value='".$tipo['id_tipo_tutor']."' >".$tipo['tipo_tutor']."</option>";
                            }
                        }
                        echo "</select>";
                        ?>" +
                    "</div>" +
                    "<div class='tutor_info_div_lg' >" +
                        "<label>Nombre</label>" +
                        "<input type='text' class='nombreTutor' />" +
                    "</div>" +
                    "<div class='tutor_info_div_md' >" +
                        "<label>Tel&eacute;fonos</label>" +
                        "<input type='text' class='telefonosTutor' />" +
                    "</div>" +
                    "<div class='tutor_info_div_md' >" +
                        "<label>Celular</label>" +
                        "<input type='text' class='celularTutor' />" +
                    "</div>" +
                    "<div class='tutor_info_div_md' >" +
                        "<label>Calle</label>" +
                        "<input type='text' class='calleTutor' />" +
                    "</div>" +
                    "<div class='tutor_info_div_sm' >" +
                        "<label>N&uacute;mero</label>" +
                        "<input type='text' class='numeroTutor' />" +
                    "</div>" +
                    "<div class='tutor_info_div_lg' >" +
                        "<label>Colonia</label>" +
                        "<input type='text' class='coloniaTutor' />" +
                    "</div>" +
                    "<div class='tutor_info_div_sm' >" +
                        "<label>CP</label>" +
                        "<input type='text' class='CPTutor' />" +
                    "</div>" +
                    "<img src='../../media/iconos/copy.png' alt='X' class='img_eliminar_tutor' onclick='copiarDireccion($(this).parent());'/>" +
                    "<div class='tutor_info_div_lg' >" +
                        "<label>Ocupaci&oacute;n</label>" +
                        "<?php
                            echo "<select class='ocupacionTutor'>";
                            if(is_array($ocupaciones))
                            {
                                foreach($ocupaciones as $ocupacion)
                                {
                                    echo "<option value='".$ocupacion['id_tutor_ocupacion']."' >".$ocupacion['ocupacion']."</option>";
                                }
                            }
                            echo "</select>";
                        ?>" +
                    "</div>" +
                    "<div class='tutor_info_div_lg' >" +
                        "<label>Lugar de trabajo</label>" +
                        "<input type='text' class='lugarTrabajoTutor' />" +
                    "</div>" +

                    "<img src='../../media/iconos/close.png' alt='X' class='img_eliminar_tutor' onclick='$(this).parent().remove();'/>" +
                "</div>";

            $(document).ready(function ()
            {
                asignarReglasValidacion();
                $("#forma_nuevo_alumno").tabs();
                cargarSubtipos();
            });

            function copiarDireccion(tutor)
            {
                var calle   = $("#calleVal").val();
                var numero  = $("#numeroVal").val();
                var colonia = $("#coloniaVal option:selected").text();
                var CP      = $("#CPVal").val();

                $(tutor).find('.calleTutor').val(calle);
                $(tutor).find('.numeroTutor').val(numero);
                $(tutor).find('.coloniaTutor').val(colonia);
                $(tutor).find('.CPTutor').val(CP);
            }

            function asignarReglasValidacion()
            {
                $('#forma_nuevo_alumno').validate({
                    ignore: "",
                    rules:
                    {
                        "apellido_paternoVal": { required: true },
                        "nombresVal": { required: true },
                        "grupoVal": { required: true }
                    }
                })
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
                var id_ciclo = $("#cicloVal").val();
                var id_grado = $("#gradoVal").val();

                $.post("../../includes/acciones/grupos/print_select_grupos.php", { id_ciclo:id_ciclo, id_grado: id_grado }, function (data)
                {
                    $("#grupoVal").html(data);
                });
            }

            function enviarFormulario()
            {
                var forma = $("#forma_nuevo_alumno");

                 /** Datos del usuario */
                var nombres     = $("#nombresVal").val();
                var paterno     = $("#apellido_paternoVal").val();
                var materno     = $("#apellido_maternoVal").val();
                var sexo        = $("#sexoVal").val();
                var ciclo       = $("#cicloVal").val();
                var area        = $("#areaVal").val();
                var grado       = $("#gradoVal").val();
                var grupo       = $("#grupoVal").val();

                /** Lista de familiares y tutores */
                var tutores = [];
                $(".tutor").each(function(){
                    var tutor = {};
                    tutor.id_tipo_tutor = $(this).find('.tipo_tutor').val();
                    tutor.nombres       = $(this).find('.nombreTutor').val();
                    tutor.calle         = $(this).find('.calleTutor').val();
                    tutor.numero        = $(this).find('.numeroTutor').val();
                    tutor.colonia       = $(this).find('.coloniaTutor').val();
                    tutor.CP            = $(this).find('.CPTutor').val();
                    tutor.telefonos     = $(this).find('.telefonosTutor').val();
                    tutor.celular       = $(this).find('.celularTutor').val();
                    tutor.ocupacion     = $(this).find('.ocupacionTutor').val();
                    tutor.lugarTrabajo  = $(this).find('.lugarTrabajoTutor').val();
                    tutores.push(tutor);
                });

                /** Otra información */
                var calle   = $("#calleVal").val();
                var numero  = $("#numeroVal").val();
                var colonia = $("#coloniaVal").val();
                var CP      = $("#CPVal").val();

                var club    = $("#clubVal").val();
                var CURP    = $("#curpVal").val();

                /** Beca */
                var beca_tipo = $("#becaTipoVal").val();
                var beca_subtipo = $("#becaSubtipoVal").val();
                var beca_porcentaje = $("#becaPorcentaje").val();

                /** Papeleria entregada */
                var papeleria_entregada = [];
                $("tr.documento").each(function(){
                    if($(this).find('.original').prop('checked') ||  $(this).find('.copia').prop('checked'))
                    {
                        var documento = {};
                        documento.id_documento = $(this).children('.id_documento').val();
                        if($(this).find('.original').prop('checked')) documento.original = 1;
                            else documento.original = 0;
                        if($(this).find('.copia').prop('checked')) documento.copia = 1;
                            else documento.copia = 0;
                        papeleria_entregada.push(documento);
                    }
                });

                if(forma.valid())
                {
                    $("#boton_aceptar").attr('disabled','disabled');

                    var parametros = "nombres=" + nombres + "&apellido_paterno=" + paterno + "&apellido_materno=" + materno
                        + "&area=" + area + "&sexo=" + sexo + "&grado=" + grado + "&grupo=" + grupo + "&calle=" + calle
                        + "&numero=" + numero + "&colonia=" + colonia + "&CP=" + CP
                        + "&tutores=" + JSON.stringify(tutores) + "&club=" + club + "&CURP=" + CURP + "&beca_tipo="
                        + beca_tipo + "&beca_subtipo=" + beca_subtipo + "&beca_porcentaje=" + beca_porcentaje
                        + "&id_ciclo_escolar=" + ciclo + "&papeleria_entregada=" + JSON.stringify(papeleria_entregada)

                    $("#boton_aceptar").attr('disabled', 'disabled');
                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/alumnos/insert.php",
                        data: parametros,
                        success: function (data)
                        {
                            if(data)
                            {
                                alert("Alumno inscrito");
                                if(confirm("¿Desea imprimir la información"))
                                {
                                    window.location.href = "../../includes/acciones/alumnos/print_inscripcion.php?id_alumno=" + data;
                                }
                                else
                                {
                                    window.location.href = "../../admin/alumnos/index.php";
                                }
                            }
                            else
                            {
                                alert("Error: " + data);
                            }
                        }
                    });
                }
            }

            function nuevoTutor()
            {
                $("#div_tutores").append(tutor_string);
            }

            function cargarSubtipos()
            {
                var id_tipo = $("#becaTipoVal").val();
                $.post("../../includes/acciones/becas/load_subtipos.php", {id_tipo:id_tipo}, function (data)
                {
                    $("#becaSubtipoVal").html(data);
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
                  <div class="display-6">Inscribir Alumno</div>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>

		<div class="container-fluid">
        <div class="panel-wrapper">
		
          
              <div class="panel">
                <div class="panel-body">
                  <ul role="tablist" class="nav nav-pills nav-justified text-uppercase">
                    <li class="nav-item"><a href="#demo3tab-1" aria-controls="demo3tab-1" role="tab" data-toggle="tab" class="nav-link active">Datos del alumno</a></li>
                    <li class="nav-item"><a href="#demo3tab-2" aria-controls="demo3tab-2" role="tab" data-toggle="tab" class="nav-link">Familia / Tutores</a></li>
					<li class="nav-item"><a href="#demo3tab-3" aria-controls="demo3tab-3" role="tab" data-toggle="tab" class="nav-link">Otra Informaci&oacute;n</a></li>
					<li class="nav-item"><a href="#demo3tab-4" aria-controls="demo3tab-4" role="tab" data-toggle="tab" class="nav-link">Beca</a></li>
					<li class="nav-item"><a href="#demo3tab-5" aria-controls="demo3tab-5" role="tab" data-toggle="tab" class="nav-link">Papeleria</a></li>
                  </ul>
                  <div class="tab-content">
                    <div role="tabpanel" id="demo3tab-1" class="tab-pane p-y-2 active fade in">
					<form autocomplete="off" method="post" action="#" id="forma_nuevo_alumno">
                    <div class="row">
                      <div class="form-group col-sm-4">
                        <label for="formBasicFirstName" class="form-form-control-label">Nombres</label>
                        <input name="nombresVal" id="nombresVal" type="text" placeholder="Nombres" autocomplete="off" class="form-control" required>
                      </div>
                      <div class="form-group col-sm-4">
                        <label for="formBasicLastName" class="form-form-control-label">Apellido Paterno</label>
                        <input name="apellido_paternoVal" id="apellido_paternoVal" type="text" placeholder="Apellido Paterno" autocomplete="off" class="form-control">
                      </div>
					  <div class="form-group col-sm-4">
					    <label for="formBasicLastName" class="form-form-control-label">Apellido Materno</label>
                        <input name="apellido_maternoVal" id="apellido_maternoVal" type="text" placeholder="Apellido Materno" autocomplete="off" class="form-control">
					  </div>
                    </div>
					<div class="row">
					<div class="form-group col-sm-3">
                      <label for="formBasicCalle" class="form-form-control-label">Calle</label>
                      <input name="calleVal" id="calleVal" type="text" placeholder="Calle" autocomplete="off" class="form-control">
                    </div>
					<div class="form-group col-sm-3">
                      <label for="formBasicNumber" class="form-form-control-label">N&uacute;mero</label>
                      <input name="numeroVal" id="numeroVal" type="text" placeholder="N&uacute;mero" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group col-sm-3">
                      <label class="form-form-control-label">Colonia</label>
                      <div>
                      <select data-plugin="selectpicker" class="form-control" name="coloniaVal" id="coloniaVal">
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
                    </div>
					<div class="form-group col-sm-3">
                      <label for="formBasicCP" class="form-form-control-label">C.P.</label>
                      <input name="CPVal" id="CPVal" type="text" placeholder="C.P." autocomplete="off" class="form-control">
                    </div>
					</div>
					<div class="row">
					<div class="form-group col-sm-6">
                      <label for="formBasicCURP" class="form-form-control-label">CURP</label>
                      <input name="curpVal" id="curpVal" type="text" placeholder="CURP" autocomplete="off" class="form-control">
                    </div>
                    <div class="form-group col-sm-6">
                      <label class="form-form-control-label">Sexo</label>
                      <div>
                      <select data-plugin="selectpicker" class="form-control" id="sexoVal" name="sexoVal">
                       <option value="M">M</option>
                       <option value="F">F</option>
                       <option value="N/A">N/A</option>
                      </select>
                      </div>
                    </div>
                    </div>
					<div class="row">
					 <div class="form-group col-sm-3">
                      <label class="form-form-control-label">Ciclo Escolar</label>
                      <div>
                      <select data-plugin="selectpicker" class="form-control" name="cicloVal" id="cicloVal" required onchange="loadGrupos();">
                       <?php
                                    $ciclos_proximos = CicloEscolar::getListaProximos($_SESSION['id_colegio']);
                                    if(is_array($ciclos_proximos))
                                    {
                                        foreach($ciclos_proximos as $ciclo)
                                        {
                                            echo "<option value='".$ciclo['id_ciclo_escolar']."' >".$ciclo['ciclo']."</option>";
                                        }
                                    }
                       ?>
                      </select>
                      </div>
                     </div>
					 <div class="form-group col-sm-3">
                      <label class="form-form-control-label">Area</label>
                      <div>
                      <select data-plugin="selectpicker" class="form-control" name="areaVal" id="areaVal" required onchange="loadGrados();">
					  
                       <?php
					                $areas = Area::getLista($_SESSION['id_colegio']);
                                    foreach($areas as $area)
                                    {
                                        echo "<option value='".$area['id_area']."' >".$area['area']."</option>";
                                    }
                       ?>
                      </select>
                      </div>
                     </div>
					 <div class="form-group col-sm-3">
                      <label class="form-form-control-label">Grado</label>
                      <div>
                      <select  class="form-control" name="gradoVal" id="gradoVal" required onchange="loadGrupos();">
                      <!-- AJAX -->
                      </select>
                      </div>
                     </div>
					 <div class="form-group col-sm-3">
                      <label class="form-form-control-label">Grupo</label>
                      <div>
                      <select  class="form-control" name="grupoVal" required id="grupoVal">
                      <!-- AJAX -->
                      </select>
                      </div>
                     </div>
					</div>
					</div>
                    <div role="tabpanel" id="demo3tab-2" class="tab-pane p-y-2 fade"><!--TUTORES-->
                       <div id="tab-datos_tutores" class="aTab" >
                            <div id="div_tutores">
                                <!-- Dinámico -->
                            </div>
                            <div id="boton_nuevo_tutor" onclick="nuevoTutor();">
                                <img src="../../media/iconos/icon_add.png" alt="+" />
                                <div style="margin: 7px 0; overflow: auto;">Agregar</div>
                            </div>
                        </div>
                    </div>
					<div role="tabpanel" id="demo3tab-3" class="tab-pane p-y-2 fade"><!--Otra informacion-->
					<div class="row">
					<div class="form-group col-sm-6">
                      <label class="form-form-control-label">Club</label>
                      <div>
                      <select data-plugin="selectpicker" class="form-control" name="clubVal" id="clubVal">
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
                     </div>
					</div>
					</div>
					<div role="tabpanel" id="demo3tab-4" class="tab-pane p-y-2 fade"><!--Beca-->
					<div class="row">
					<div class="form-group col-sm-4">
                      <label class="form-form-control-label">Tipo</label>
                      <div>
                      <select data-plugin="selectpicker" class="form-control" name="becaTipoVal" id="becaTipoVal" onchange="cargarSubtipos();">
                       <?php
                                    $tipos_beca = Beca::getTipos();
                                    if(is_array($tipos_beca))
                                    {
                                        foreach($tipos_beca as $tipo)
                                        {
                                            echo "<option value='".$tipo['id_tipo_beca']."'>".$tipo['tipo_beca']."</option>";
                                        }
                                    }
                       ?>
                      </select>
                      </div>
                     </div>
					 <div class="form-group col-sm-4">
                      <label class="form-form-control-label">Subtipo</label>
                      <div>
                      <select  class="form-control" name="becaSubtipoVal" id="becaSubtipoVal">
                       <!--AJAX-->
                      </select>
                      </div>
                     </div>
					 <div class="form-group col-sm-4">
                        <label for="formBasicPtje" class="form-form-control-label">Porcentaje de beca</label>
                        <input name="becaPorcentaje" id="becaPorcentaje" type="text" placeholder="Porcentaje de beca" autocomplete="off" class="form-control">
                      </div>
					</div>
					</div>
					<div role="tabpanel" id="demo3tab-5" class="tab-pane p-y-2 fade"><!--Papeleria-->
					 <table id="tab-papeleria" class="table">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th style="width: 120px" >Original</th>
                                    <th>Copia</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $papeleria = Documento::getLista();
                            if(is_array($papeleria))
                            {
                                foreach($papeleria as $documento)
                                {
                                    $id_documento   = $documento['id_documento'];
                                    $documento      = $documento['documento'];
                                    echo "
                                        <tr class='documento' >
                                            <input type='hidden' class='id_documento' value='".$id_documento."' />
                                            <td>".$documento."</td>
                                            <td><input type='checkbox' class='original' value='".$id_documento."' /></td>
                                            <td><input type='checkbox' class='copia' value='".$id_documento."' /></td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
					</div>
					<div class="form-group">
                      <button type="button" class="btn btn-primary" onclick="enviarFormulario();" id="boton_aceptar">Aceptar</button>
                    </div>
                  </form>
				 
                  </div>
				   <!-- END COTENT-->
                </div>
               
              </div>
              <!-- END PANEL-->
          
            <!-- END COL-->
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
				  
    <!-- Lib -->
    <script src="../../ssets/scripts/lib/jquery-1.11.3.min.js"></script>
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