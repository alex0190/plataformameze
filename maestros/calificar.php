<?php
include_once("../includes/clases/class_lib.php");
@session_start();
$maestro = new Maestro($_SESSION['id_persona']);
if(isset($_GET['id_grupo'])) $grupo = new Grupo($_GET['id_grupo']);
$materias = $grupo->getClasesMaestro($maestro->id_persona);
$grado = new Grado($grupo->id_grado);
$area = new Area($grado->id_area);
$no_parciales = $area->no_parciales;
$no_materias = count($materias);
$alumnos = $grupo->getAlumnos();
$usuario = new Persona($_SESSION['id_persona']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<link rel="shortcut icon" href="../images/logo.ico">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
        <title>Sistema Integral Meze - Calificar</title>
		
		<!-- lib-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic">
   
    <!-- Theme-->
    <!-- Concat all lib & plugins css-->
    <link id="mainstyle" rel="stylesheet" href="../assets/stylesheets/theme-libs-plugins.css">
    <link id="mainstyle" rel="stylesheet" href="../assets/stylesheets/skin.css">

    <!-- Demo only-->
    <link id="mainstyle" rel="stylesheet" href="../assets/stylesheets/demo.css">

    <!-- This page only-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries--><!--[if lt IE 9]>
    <script src="assets/scripts/lib/html5shiv.js"></script>
    <script src="assets/scripts/lib/respond.js"></script><![endif]-->
    <script src="../assets/scripts/lib/modernizr-custom.js"></script>
    <script src="../assets/scripts/lib/respond.js"></script>
		
		<script src="../plugins/assets/js/appear.min.js" type="text/javascript"></script>
		<script src="../plugins/assets/js/animations.js" type="text/javascript"></script>
        <link rel="stylesheet" href="../estilo/general.css" />
        <link rel="stylesheet" href="../estilo/calificar.css" />
        <link rel="stylesheet" href="../estilo/formas_extensas.css" />
        <style>
            #boton_aceptar
            {
                margin: 20px 0;
            }
        </style>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    </head>
    <body class="stellar">

    <!-- #SIDEMENU-->
    <div class="mainmenu-block">
      <!-- SITE MAINMENU-->
      <nav class="menu-block">
        <ul class="nav">
          <li class="nav-item mainmenu-user-profile"><a href="#">
              <div class="circle-box"><img src="../media/fotos/<?php echo $usuario->foto; ?>" alt="">
                <div class="dot dot-success"></div>
              </div>
              <div class="menu-block-label"><b><?php if(isset($_SESSION['nombres'])) echo $_SESSION['nombres'] ; ?></b>
			  <br>Maestro
			  </div></a></li>
        </ul>
       
        <ul class="nav">
          <li class="nav-item"><a href="../index.php" class="nav-link"> <i class="icon ion-home"></i>
              <div class="menu-block-label">
                 Inicio
              </div></a></li>
         
          <!--li.header colegios-->
          <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-ios-people"></i>
              <div class="menu-block-label">Grupos</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="grupos.php" class="nav-link">Lista</a></li>
             
            </ul>
          </li>
          <li class="menu-block-has-sub nav-item"><a href="#" class="nav-link"> <i class="icon ion-ios-paper-outline"></i>
              <div class="menu-block-label">Asignar Tareas</div></a>
            <ul class="nav menu-block-sub">
              <li class="nav-item"><a href="asignarTareas.php" class="nav-link">Tareas</a></li>
              
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
            <li class="nav-item"><a href="../login.php" class="nav-link"><i class="icon ion-android-exit"></i></a></li>
           
          
            
           <li class="nav-item"><a href="../login.php" class="nav-link close-mobile-nav js-close-mobile-nav"><i class="icon ion-close"></i></a></li>
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
                  <div class="display-6"><?php echo "Calificaciones de ".$grupo->getGrado()." ".$grupo->grupo." de ".$area->area; ?></div>
                  
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
               

                
                    <label for="parcialVal" class="form_label">Parcial</label>
                    <select id="parcialVal" name="parcialVal" class="form_input" onChange='parcialCambiado()'>
                        <?php
                            for($i = 1; $i <= $no_parciales; $i++)
                            {
                                echo "<option value='".$i."' >".$i."</option>";
                            }
                        ?>
                    </select>
                <br><br>

                <div class="responsive-nav">

                    <table id="tabla_calificaciones" class="table">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Alumno</th>
                                <?php
                                if(is_array($materias))
                                {
                                    foreach($materias as $materia)
                                    {
                                        echo "<th>".$materia['materia']."</th>";
                                    }
                                }
                                ?>
                                <th>Promedio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(is_array($alumnos))
                            {
                                foreach($alumnos as $alumno)
                                {
                                    $alu = $alumno['id_alumno'];
                                    echo "
                                        <tr class='cali_row' >
                                            <td>".$alumno['apellido_paterno']." ".$alumno['nombres']."</td>";
                                    foreach($materias as $materia)
                                    {
                                        $cla = $materia['id_clase'];
                                        echo "<td>
                                            <input
                                                class='calificacion'
                                                data-alu='".$alu."'
                                                data-cla='".$cla."'
                                                onkeyup='validarCal(this)' />
                                        </td>";
                                    }
                                    echo "
                                            <td class='promedio'></td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

                <button id="boton_aceptar" onClick="aceptarClicked()" class="btn btn-primary" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button>

            </div><!--area_trabajo-->
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
    <script src="../assets/scripts/lib/jquery-1.11.3.min.js"></script>
    <script src="../assets/scripts/lib/jquery-ui.js"></script>
    <script src="../assets/scripts/lib/tether.min.js"></script>

    <!-- Theme js-->
    <!-- Concat all plugins js-->
    <script src="../assets/scripts/theme/theme-plugins.js"></script>
    <script src="../assets/scripts/theme/main.js"></script>
    <!-- Below js just for this demo only-->
    <script src="../assets/scripts/demo/demo-skin.js"></script>
    <script src="../assets/scripts/demo/bar-chart-menublock.js"></script>
    </body>
    <script>
        var id_grupo = <?php echo $grupo->id_grupo; ?>;

        function calificacionCambiada(caller)
        {
            var original = caller.defaultValue;
            var nuevo = $(caller).val();

            if (isNaN(nuevo) || nuevo < 0 || nuevo > 10) $(caller).val(0);

            if (original.length == 0) caller.className = caller.className + " insert";
            else caller.className = caller.className + " update";
        }

        function parcialCambiado()
        {
            $.ajax({
                type: "POST",
                url: "../includes/acciones/calificaciones/JSONgetCalificaciones.php",
                data: "id_grupo=" + id_grupo + "&parcial=" + $("#parcialVal").val(),
                dataType: 'json',
                success: function (data)
                {
                    var calificaciones = data;
                    llenarTabla(calificaciones);
                }
            });
        }

        function aceptarClicked()
        {
            if(confirm("¿Desea actualizar los cambios?"))
            {
                var parcial = $("#parcialVal").val();
                var calificaciones = [];

                $(".calificacion").each(function(){
                    var calTMP = {};

                    calTMP.calificacion = $(this).val();
                    calTMP.alumno       = $(this).attr('data-alu');
                    calTMP.clase        = $(this).attr('data-cla');

                    if(calTMP.calificacion > 0 && !calTMP.calificacion.isEmptyObject && !isNaN(calTMP.calificacion))
                        calificaciones.push(calTMP);
                });

                $.ajax({
                    type: "POST",
                    url: "../includes/acciones/calificaciones/update.php",
                    data: "parcial=" + parcial + "&calificaciones=" + JSON.stringify(calificaciones),
                    success: function (data)
                    {
						if(data == 1)
                        {
                            alert("Datos actualizados.");
                            parcialCambiado();
                        }
                        else alert("Error.");
                    }
                });
            }
        }

        function llenarTabla(calificaciones)
        {
            limpiarTabla();
            // Por cada clase
            $.each(calificaciones, function(i, obj){

                var id_clase = obj.id_clase;
                var calis = obj.calificaciones;

                // Cada calificación
                $.each(calis, function(j, obj2){
                    var id_alumno = obj2.alumno;
                    var calificacion = obj2.calificacion;

                    $('input[data-alu='+id_alumno+'][data-cla='+id_clase+']').val(calificacion);
                });
            });

            calcularPromedios();
        }

        function limpiarTabla()
        {
            $(".calificacion").each(function(){ $(this).val(""); });
            $(".promedio").each(function(){ $(this).html(""); });
        }

        function validarCal(caller)
        {
            var calTMP = $(caller).val();
            if(calTMP < 0) $(caller).val(0);
            if(calTMP > 100) $(caller).val(100);
            if(isNaN(calTMP)) $(caller).val("");

            calcularPromedios();
        }

        function calcularPromedios()
        {
            $(".cali_row").each(function(){
                var promedio = 0;
                var periodos = 0;
                $(this).find('.calificacion').each(function(){
                    if($(this).val() > 0) periodos = periodos + 1;
                    promedio += $(this).val() * 1.0;
                });
                if(periodos > 0) $(this).children('.promedio').html((promedio / periodos).toFixed(2));
            });
        }

        /** Document ready */
        parcialCambiado();

    </script>
</html>