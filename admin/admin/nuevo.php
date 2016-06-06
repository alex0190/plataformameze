<?php
$id_modulo = 1; // Administradores - Nuevo
include_once("../../includes/clases/class_lib.php");
$colegio = Colegio::getLista();
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <title>Sistema Integral Meze - Nuevo Administrador</title>
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

    <style>
	.table{border-collapse:separate;
	      border-radius: 15px;
	      border: 4px solid #CCC;
		  margin: 15px;
          padding: 15px;}
	</style>
       
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
         <script src="../../librerias/messages_es.js"></script>    
        <script>
            $(document).ready(function ()
            {
                asignarReglasValidacion();
                $("#forma_nuevo_administrador").tabs();
            });

            function asignarReglasValidacion()
            {
                $('#forma_nuevo_administrador').validate({
                    rules:
                    {
                        "apellido_paternoVal": { required: true },
                        "nombresVal": { required: true }
                    },
                    ignore: ""
                });
            }

            function submitForma()
            {
                if($('#forma_nuevo_administrador').valid())
                {
                    if(confirm("¿Desea agregar un administrador?"))
                    {
                        $("#boton_aceptar").attr('disabled','disabled');

                        var permisos = [];
                        $(".permiso input").each(function()
                        {
                            if($(this).is(':checked')) permisos.push($(this).val());
                        });

                        var nombres             = $("#nombresVal").val();
                        var apellido_paterno    = $("#apellido_paternoVal").val();
                        var apellido_materno    = $("#apellido_maternoVal").val();
                        var sexo                = $("#sexoVal").val();
						var idcolegio           = $("#idcolegioVal").val();

                        $.ajax({
                            type: "POST",
                            url: "../../includes/acciones/administradores/insert.php",
                            data: "nombres=" + nombres + "&apellido_paterno=" + apellido_paterno
                                + "&apellido_materno=" + apellido_materno + "&sexo=" + sexo + "&idcolegio=" + idcolegio,
                            async: false,
                            success: function (data)
                            {
								if(data != "error")
                                {
									id_administrador = data;
                                    $.ajax({
                                        type: "POST",
                                        url: "../../includes/acciones/administradores/update_permisos.php",
                                        data: "id_persona=" + id_administrador + "&permisos=" + JSON.stringify(permisos),
                                        success: function (data)
                                        {
                                            alert("Administrador agregado");
                                            window.location.reload();
                                        }
                                    });
                                }
								else
								  alert("Error. No se pudo agregar al administrador");
                            }
                        });
                    }
                }
            }

            function toggle_seleccion(caller)
            {
                var checked = $(caller).is(":checked");
                $(".permiso").each().prop("checked", checked);
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
			  <br>Super Administrador
			  </div></a></li>
        </ul>
       
        <ul class="nav">
          <li class="nav-item"><a href="../../index.php" class="nav-link"> <i class="icon ion-home"></i>
              <div class="menu-block-label">
                 Inicio
              </div></a></li>
         
          <!--li.header colegios-->
          <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-ios-book"></i>
              <div class="menu-block-label">Colegios</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="index.php" class="nav-link">Ver Todos</a></li>
              <li class="nav-item"><a href="nuevo.php" class="nav-link">Nuevo</a></li>
            </ul>
          </li>
          <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-gear-b"></i>
              <div class="menu-block-label">Administradores</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="../administradores/index.php" class="nav-link">Ver Todos</a></li>
              <li class="nav-item"><a href="../administradores/nuevo.php" class="nav-link">Nuevo</a></li>
              
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
                  <div class="display-6">Registrar Administrador</div>
                  
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
                    <li class="nav-item"><a href="#demo3tab-1" aria-controls="demo3tab-1" role="tab" data-toggle="tab" class="nav-link active">Datos</a></li>
                    <li class="nav-item"><a href="#demo3tab-2" aria-controls="demo3tab-2" role="tab" data-toggle="tab" class="nav-link">Permisos</a></li>
                  </ul>
                  <div class="tab-content">
                    <div role="tabpanel" id="demo3tab-1" class="tab-pane p-y-2 active fade in">
                      <form autocomplete="off" method="post" action="#" id="forma_nuevo_administrador">
                    <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="formBasicLastName" class="form-form-control-label">Apellido Paterno</label>
                        <input name="apellido_paternoVal" id="apellido_paternoVal" type="text" placeholder="Apellido Paterno" autocomplete="off" class="form-control" required>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="formBasicLastName" class="form-form-control-label">Apellido Materno</label>
                        <input name="apellido_maternoVal" id="apellido_maternoVal" required type="text" placeholder="Apellido Materno" autocomplete="off" class="form-control">
                      </div>
                    </div>
					<div class="row">
					<div class="form-group col-sm-6">
                      <label for="formBasicFirstName" class="form-form-control-label">Nombre(s)</label>
                      <input name="nombresVal" id="nombresVal" type="text" placeholder="Nombre(s)" autocomplete="off" class="form-control" required>
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
                    <div class="form-group">
                      <label class="form-form-control-label">Colegio</label>
                      <div>
                      <select data-plugin="selectpicker" class="form-control" name="idcolegioVal" id="idcolegioVal">
                       <?php
								   for($i = 0; $i < count($colegio); $i++)
								   {
									   echo "<option value='".$colegio[$i]['IDColegio']."' >".$colegio[$i]['Nombre']."</option>";
								   }
                       ?>
                      </select>
                      </div>
                    </div>
                    
                    </div>
                    <div role="tabpanel" id="demo3tab-2" class="tab-pane p-y-2 fade">
                       <?php include_once("include_permisos.php"); ?>
                    </div>
					<div class="form-group">
                      <button type="button" class="btn btn-primary" id="boton_aceptar" value="Aceptar" onclick="submitForma();">Aceptar</button>
                    </div>
                  </form>
				  <?php
                    if(isset($error))
                    {
                        switch($error)
                        {
                            case 1: echo "<div class='error'>Faltaron datos de llenar.</div>"; break;
                            case 2: echo "<div class='error'>Error de base de datos.</div>"; break;
                            default: break;
                        }
                    }
                    ?>
                  </div>
                </div>
                <!-- END TAB 3-->
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
    <script>
        function toggle_seleccion(caller)
        {
            var checked = $(caller).prop('checked');
            $(".permiso").children('input').each(function(){
                $(this).prop('checked', checked);
            });

        }
    </script>
</html>