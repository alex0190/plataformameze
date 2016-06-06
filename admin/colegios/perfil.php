

<?php
$id_modulo = 1; // Administradores - Nuevo
include_once("../../includes/clases/class_lib.php");
@session_start();
$usuario = new Persona($_SESSION['id_persona']);
$id_colegio = $_GET["id_colegio"];

$colegio = new Colegio($id_colegio);
$ciudad     = $colegio->getCiudad();
$estado     = $colegio->getEstado();
$nombre     = $colegio->getNombre();
$direccion  = $colegio->getDireccion();
$telefono   = $colegio->getTelefono();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <title>Sistema Integral Meze - Colegio</title>
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
    <link rel="stylesheet" href="../../estilo/perfil_alumno.css" />
    <link rel="stylesheet" href="../../estilo/fixed_form.css" />
    <link rel="stylesheet" href="../../estilo/perfiles.css" />
         
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
                  <div class="display-6">Perfil del Colegio</div>
                  
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
                <div id="profile_picture">
                    <div id="profile_picture_inner">
                       <img src="../../media/imglogo/<?php echo $colegio->imagen; ?>" alt="N/A" id="foto_maestro" />
					</div>
                </div>

                <!-- Datos del perfil. CSS: perfiles.css -->
                <div class="datos_perfil" >
                    <div class="datos_perfil_seccion" >
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Colegio:</div>
                            <div class="perfil_dato_value"><?php for($i=0;$i<count($nombre);$i++)echo $nombre[$i]['Nombre']; ?>
                            <img src="../../media/iconos/icon_modify.png"
                                 ALT="M" onClick="cambiarNombreClicked()" style="width: 15px" title="Cambiar nombre" />
                                 
                             </div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Ciudad:</div>
                            <div class="perfil_dato_value"><?php for($i=0;$i<count($ciudad);$i++)echo $ciudad[$i]['Ciudad']; ?></div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Estado:</div>
                            <div class="perfil_dato_value"><?php for($i=0;$i<count($estado);$i++)echo $estado[$i]['Estado']; ?></div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Direccion:</div>
                            <div class="perfil_dato_value"><?php for($i=0;$i<count($direccion);$i++)echo $direccion[$i]['Direccion']; ?>
                            <img src="../../media/iconos/icon_modify.png"
                                 ALT="M" onClick="cambiarDireccionClicked()"
                                 style="width: 15px" title="Cambiar Direccion" />
                            </div>
                         </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label">Telefono:</div>
                            <div class="perfil_dato_value"><?php for($i=0;$i<count($telefono);$i++)echo $telefono[$i]['Telefono']; ?>
                            <img src="../../media/iconos/icon_modify.png"
                                 ALT="M" onClick="cambiarTelefonoClicked()"
                                 style="width: 15px" title="Cambiar Telefono" />
                            </div>
                         </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label"></div>
                            <div class="perfil_dato_value">
                           
                            </div>
                         </div>
                         <div class="datos_perfil_dato">
                            <div class="perfil_dato_label"></div>
                            <div class="perfil_dato_value">
                           
                            </div>
                         </div>
                        
                         
                     </div>
                       <div class="datos_perfil_seccion" >
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label"></div>
                           
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label"></div>
                            <div class="perfil_dato_value">
                               
                            </div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label"></div>
                            <div class="perfil_dato_value">
                               
                               
                            </div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label"></div>
                            <div class="perfil_dato_value">
                              
                            </div>
                        </div>
                        <div class="datos_perfil_dato">
                            <div class="perfil_dato_label"></div>
                            <div class="perfil_dato_value">
                               
                              
                            </div>
                        </div>
                        
                    </div>
                   </div>
                
                <img 
                    id="qr_code"
                    alt ="<?php echo $id_colegio; ?>" 
                    src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?php echo $id_colegio; ?>&chld=L|0"  
                />
           
                <div id="panel_imagen">
                    <!-- loader.gif -->
                    <img style="display:none" id="loader" src="../../media/imagenes/loader.gif" alt="Cargando...." title="Cargando...." />
                    <!-- simple file uploading form -->
                    <form id="form_imagen" action="../../includes/ajaxuploadColegios.php" method="post" enctype="multipart/form-data">
                        
                        <input id="uploadImage" type="file" name="image"/><br>
                        <input id="button" type="submit" value="Subir" class="btn btn-warning">
                    </form>
                </div>                
              </div>
            </div>
			  </div>
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

   <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="../../librerias/fnAjaxReload.js" ></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script src="../../librerias/jquery.form.js"></script>
        <script>
       
	    /** Cosas del Ajax image loader */
		var id_colegio = <?php echo $id_colegio; ?>;
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
            if(img == "photo_NA.jpg") alert("La foto debe de tener un tamaño no mayor a 400kb y tener una terminación .png");
            $.ajax({
                type: "POST",
                url: "../../includes/acciones/colegios/asignar_foto.php",
                data: "id_colegio=" + id_colegio + "&imagen=" + img,
                success: function (data)
                {
                    document.location.reload(true);
                }
            });
        }

        function cambiarNombreClicked()
        {
            var nuevosNombre = prompt("Nuevo Nombre","");
            if(nuevosNombre !== null)
            {
                if(nuevosNombre.length > 2)
                {
                    if(confirm("¿Seguro que desea cambiar el nombre del colegio a: " + nuevosNombre))
                    {
                        $.post("../../includes/acciones/colegios/cambiar_nombre.php", {idcolegio:id_colegio, nombre:nuevosNombre}, function (data)
                        {
                            document.location.reload(true);
                        });
                    }
                }
            }
        }
		
		function cambiarDireccionClicked()
        {
            var nuevoDireccionNuevo = prompt("Direccion Nueva", "");
            if(nuevoDireccionNuevo !== null)
            {
                if(nuevoDireccionNuevo.length > 2)
                {
                    if(confirm("¿Seguro que desea cambiar la direccion del colegio a: " + nuevoDireccionNuevo))
                    {
                        $.post("../../includes/acciones/colegios/cambiar_direccion.php", {idcolegio:id_colegio, direccion:nuevoDireccionNuevo}, function (data)
                        {
                            document.location.reload(true);
                        });
                    }
                }
            }
        }

        function cambiarTelefonoClicked()
        {
            var nuevoTelefonoNuevo = prompt("Telefono", "");
            if(nuevoTelefonoNuevo !== null)
            {
                if(nuevoTelefonoNuevo.length > 2)
                {
                    if(confirm("¿Seguro que desea cambiar el telefono del colegio a: " + nuevoTelefonoNuevo))
                    {
                        $.post("../../includes/acciones/colegios/cambiar_telefono.php", {idcolegio:id_colegio, telefono:nuevoTelefonoNuevo}, function (data)
                        {
                            document.location.reload(true);
                        });
                    }
                }
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
