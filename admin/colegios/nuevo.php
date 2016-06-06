<?php
$id_modulo = 1; // Administradores - Nuevo
include_once("../../includes/clases/class_lib.php");
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <title>Sistema Integral Meze - Nuevo Colegio</title>
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


       
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
         <script src="../../librerias/messages_es.js"></script>    
    
        
		<style type="text/css">
    .margen{ margin-top: 20px;
		     margin-left: 90px;}
    </style>

		
		<script>
            $(document).ready(function ()
            {
                asignarReglasValidacion();
                $("#forma_nuevo_colegio").tabs();
            });

            function asignarReglasValidacion()
            {
                $('#forma_nuevo_colegio').validate({
                    rules:
                    {
                        "colegioVal": { required: true },
                        "ciudadVal": { required: true },
						"direccionVal": { required: true },
						"telefonoVal": { required: true },
                    },
                    ignore: ""
                });
            }

            function submitForma()
            {
                if($('#forma_nuevo_colegio').valid())
                {
                    if(confirm("¿Desea agregar un colegio?"))
                    {
                        $("#boton_aceptar").attr('disabled','disabled');

                        var nombre              = $("#colegioVal").val();
                        var ciudad              = $("#ciudadVal").val();
                        var direccion           = $("#direccionVal").val();
                        var telefono            = $("#telefonoVal").val();
						var estado              = $("#estadoVal").val();
						
			            var parametros = "nombre=" + nombre + "&ciudad=" + ciudad + "&direccion=" 
						+ direccion + "&telefono=" + telefono + "&estado=" + estado 

                        $.ajax({
                            type: "POST",
                            url: "../../includes/acciones/colegios/insert.php",
                            data: parametros,
                            /*async: false,*/
                            success: function (data)
                            {
                                if(data != "error")
                                {
								   id_colegio = data;
								    $.ajax({
                                        type: "POST",
                                        url: "../../includes/acciones/areas/insert.php",
                                        data: "idcolegio=" + id_colegio,
                                        success: function (data)
                                        {
                                           alert("Colegio agregado");
                                           window.location.reload();
										}
									});
                                }
								else
								   alert("Error no se pudo agregar el colegio");
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
              <li class="nav-item"><a href="../admin/index.php" class="nav-link">Ver Todos</a></li>
              <li class="nav-item"><a href="../admin/nuevo.php" class="nav-link">Nuevo</a></li>
              
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
                  <div class="display-6">Registrar Colegio</div>
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
		 
		<div class="container-fluid">
        <div class="row panel-wrapper js-grid-wrapper">
		 
		 
        <div class="col-md-6 js-grid js-sizer">
             <div class="panel">
                <div class="panel-body">
                  <ul role="tablist" class="nav nav-pills nav-justified text-uppercase">
                    <li class="nav-item"><a href="#demo3tab-1" aria-controls="demo3tab-1" role="tab" data-toggle="tab" class="nav-link active">Nuevo</a></li>
                    
                  </ul>
                  <div class="tab-content">
                    <div role="tabpanel" id="demo3tab-1" class="tab-pane p-y-2 active fade in">
                      <form autocomplete="off" method="post" action="#" id="forma_nuevo_colegio">
                    <div class="row">
                      <div class="form-group col-sm-6">
                        <label for="formBasicFirstName" class="form-form-control-label">Colegio</label>
                        <input name="colegioVal" id="colegioVal" type="text" placeholder="Colegio" autocomplete="off" class="form-control" required>
                      </div>
                      <div class="form-group col-sm-6">
                        <label for="formBasicLastName" class="form-form-control-label">Ciudad</label>
                        <input name="ciudadVal" id="ciudadVal" required type="text" placeholder="Ciudad" autocomplete="off" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-form-control-label">Estado</label>
                      <div>
                      <select data-plugin="selectpicker" class="form-control" id="estadoVal" name="estadoVal">
                      <option value="Aguscalientes">Aguascalientes</option>
                                    <option value="Baja California Norte">Baja California Norte</option>
                                    <option value="Baja California Sur">Baja California Sur</option>
                                    <option value="Campeche">Campeche</option> 
                                    <option value="Coahuila">Coahuila</option>
                                    <option value="Colima">Colima</option>
                                    <option value="Chiapas">Chiapas</option>
                                    <option value="Chihuahua">Chihuahua</option>
                                    <option value="Distrito Federal">Distrito Federal</option>
                                    <option value="Durango">Durango</option>
                                    <option value="Guanajuato">Guanajuato</option>
                                    <option value="Guerrero">Guerrero</option>
                                    <option value="Hidalgo">Hidalgo</option>
                                    <option value="Jalisco">Jalisco</option>
                                    <option value="México">M&eacute;xico</option>
                                    <option value="Michoacán">Michoac&aacute;n</option>
                                    <option value="Morelos">Morelos</option>
                                    <option value="Nayarit">Nayarit</option>
                                    <option value="Nuevo León">Nuevo Le&oacute;n</option>
                                    <option value="Oaxaca">Oaxaca</option>
                                    <option value="Puebla">Puebla</option>
                                    <option value="Querétaro">Quer&eacute;taro</option>
                                    <option value="Quintana Roo">Quintana Roo</option>
                                    <option value="San Luis Potosí">San Luis Potos&iacute;</option>
                                    <option value="Sinaloa">Sinaloa</option>
                                    <option value="Sonora">Sonora</option>
                                    <option value="Tabasco">Tabasco</option>
                                    <option value="Tamaulipas">Tamaulipas</option>
                                    <option value="Tlaxcala">Tlaxcala</option>
                                    <option value="Veracruz">Veracruz</option>
                                    <option value="Yucatán">Yucat&aacute;n</option>
                                    <option value="Zacatecas">Zacatecas</option>
                        
                      </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="formBasicEmail" class="form-form-control-label">Direcci&oacute;n</label>
                      <textarea placeholder="Direcci&oacute;n del colegio" name="direccionVal" id="direccionVal" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="formBasicPassword" class="form-form-control-label">Telefono</label>
                      <input name="telefonoVal" id="telefonoVal" type="text" placeholder="Telefono" autocomplete="off" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <button type="button" class="btn btn-primary" id="boton_aceptar" value="Aceptar" onclick="submitForma();">Aceptar</button>
                    </div>
                  </form>
                    </div>
                    
                  </div>
                </div>
                <!-- END TAB 3-->
              </div>

              <!-- END PANEL-->
            </div>
            <!-- END COL-->		
			<div class="col-md-6 js-grid">
			  
			   <img src="../../images/logo grande.png" width="300" height="500" class="margen">
			  
			</div>
         </div>
        </div>		 
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
