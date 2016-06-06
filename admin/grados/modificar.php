<?php
include_once("../../includes/clases/class_lib.php");
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$materias = Materia::getLista($id_colegio);
extract($_GET);
#id_grado

if(isset($id_grado))
{
    $grado = new Grado($id_grado);
}
$ciclo_actual = CicloEscolar::getActual($id_colegio);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="../../images/logo.ico">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <title>Sistema Integral MEZE - Modificar Grados</title>
    

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
        <link rel="stylesheet" href="../../estilo/formas.css" />
        <link rel="stylesheet" href="../../estilo/grado.css" />
        <link rel="stylesheet" href="../../estilo/perfiles.css" />
       
        <link rel="stylesheet" href="../../estilo/jquery-ui.min.css" />
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
                  <div class="display-6">Modificar Grado</div>
                  
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
					
						<div class="datos_perfil_seccion">
							<div class="datos_perfil_dato">
								<input type="hidden" id="id_gradoVal" value="<?php echo $grado->id_grado; ?>" />
								<div class="perfil_dato_label">Grado</div>
								<div class="perfil_dato_value" id="gradoVal"><?php echo $grado->grado; ?></div>
								<img src="../../media/iconos/icon_modify.png"
									 style="width: 15px; margin-left: 10px"
									 onclick="modificarClicked()" />
							</div>
							<div class="datos_perfil_dato">
								<div class="perfil_dato_label">Area</div>
								<div class="perfil_dato_value"><?php echo $grado->getArea(); ?></div>
							</div>
						</div>

					

					
						<h3>Materias</h3>
						<label>Ciclo escolar:</label>
						<select id="cicloVal" onchange="nuevoCicloSeleccionado()">
							<?php
								$ciclos = CicloEscolar::getLista($id_colegio);
								if(is_array($ciclos))
								{
									foreach($ciclos as $ciclo)
									{
										echo "<option value='".$ciclo['id_ciclo_escolar']."'>".$ciclo['ciclo_escolar']."</option>";
									}
								}
							?>
						</select>

						<!-- Botón para nueva materia -->
						<button type="button" style="display: block; margin-top: 30px;" class="btn btn-primary" onclick="nuevaMateria()"><span class="glyphicon glyphicon-plus"></span> Nueva</button>

						<table id="tabla_materias" class="table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Materia</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>
								<!-- AJAX. Cargar según el grado y el ciclo escolar -->
							</tbody>
						</table>
					
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

        <!-- Modal form para asignar una nueva materia -->
        <div id="formNuevaMateria" title="Asignar nueva materia" style="box-shadow: 2px 2px 5px #5f5f5f;" >
            <label style="display: block;" >Materias disponibles para grados de <?php echo $grado->getArea(); ?>:</label>
            <select id="nuevaMateriaVal">
                <?php
                    $area = $grado->getAreaObj();
                    $materias = $area->getMaterias();
                    if(is_array($materias))
                    {
                        foreach($materias as $materia)
                        {
                            echo "<option value='".$materia['id_materia']."' >".$materia['materia']."</option>";
                        }
                    }
                ?>
            </select>
            <hr />
            <label style="display: block;" >
                Grupos de <?php echo $grado->grado; ?> de <?php echo $grado->getArea(); ?>
                en este ciclo escolar (<?php echo $ciclo_actual->ciclo; ?>):
            </label>
            <div id="div_asignar_docentes">
                <!-- AJAX -->
            </div>
            <button type="button" onclick="asignarNuevaMateria()" id="boton_agregar_materia">Aceptar</button>
        </div>
        <!-- -------------------------------------- -->

        <script src="../../librerias/jquery.min.js"></script>
        <script src="../../librerias/jquery.validate.min.js"></script>
        <script src="../../librerias/messages_es.js"></script>
        <script src="../../librerias/jquery.dataTables.min.js" ></script>
        <script src="../../librerias/fnAjaxReload.js" ></script>
        <script src="../../librerias/jquery-ui.min.js" ></script>
        <script>
            /** Variables */
            var tabla_materias;
            var form_nueva_materia;

            function modificarClicked()
            {
                var nuevo_nombre = prompt("Nuevo nombre");
                if(nuevo_nombre.length > 0 && nuevo_nombre !== "")
                {
                    if(confirm("Seguro que desea cambiar el nombre del grado a " + nuevo_nombre))
                    {
                        $.ajax({
                            type: "POST",
                            url: "../../includes/acciones/grados/update.php",
                            data: "id_gradoVal=" + $("#id_gradoVal").val() + "&gradoVal=" + nuevo_nombre,
                            success: function (data)
                            {
                                if(data == 1) document.location.reload(true);
                            }
                        });
                    }
                }
            }

            function declararDataTable()
            {
                tabla_materias = $("#tabla_materias").dataTable({
                    "bPaginate":   false,
                    "oLanguage": {
                        "sLengthMenu": "Mostrar _MENU_ materias por página",
                        "sZeroRecords": "No se encontraron materias",
                        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ materias",
                        "sInfoEmpty": "Mostrando 0 a 0 de 0 materias",
                        "sInfoFiltered": "(Encontrados de _MAX_ materias)"
                    },
                    "aoColumns": [
                        {"sWidth":"10%"},{"sWidth":"80%"},{"sWidth":"10%"}
                    ],
                    "bProcessing": true,
                    "sAjaxSource": '../../includes/acciones/grados/JSON_get_materias.php',
                    "fnServerParams": function (aoData)
                    {
                        var grado = $("#id_gradoVal").val();
                        var ciclo = $("#cicloVal").val();

                        aoData.push({ "name": "grado", "value": grado });
                        aoData.push({ "name": "ciclo", "value": ciclo });
                    }
                });
            }

            function nuevoCicloSeleccionado()
            {
                reload();
            }

            function reload()
            {
                tabla_materias.fnReloadAjax();
            }

            function eliminarMateria(id_materia)
            {
                var id_grado    = $("#id_gradoVal").val();
                var grado       = $("#gradoVal").html();
                var ciclo       = $("#cicloVal").val();

                if(confirm("Se eliminarán las clases de esta materia de todos los grupos de " + grado + ". " +
                    "También se perderán las calificaciones y asistencias relacionadas a dichos grupos." +
                    "¿Desea continuar?"))
                {
                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/grados/eliminar_materia.php",
                        data: "id_grado=" + id_grado + "&id_materia=" + id_materia
                            + "&ciclo=" + ciclo,
                        success: function (data)
                        {
                            reload();
                        }
                    });
                }
            }

            function nuevaMateria()
            {
                form_nueva_materia.dialog("open");
                cargarGrupos();
            }

            function cargarGrupos()
            {
                $.ajax({
                    type: "POST",
                    url: "../../includes/acciones/grados/getGruposJSON.php",
                    data: "grado=" + $("#id_gradoVal").val(),
                    dataType: "json",
                    success: function (grupos)
                    {
                        // Llenamos la variable optionsDocentes con el
                        // código HTML de los elementos <option> por cada docente.
                        var optionsDocentes = "";
                        $.ajax({
                            type: "POST",
                            url: "../../includes/acciones/maestros/getJSONDocentesVigentes.php",
                            data: "",
                            dataType: "json",
                            success: function (docentes)
                            {
                                if(docentes.length > 0 && docentes != null)
                                {
                                    for(i in docentes)
                                    {
                                        optionsDocentes += "<option value='"
                                            + docentes[i].id_persona + "'>"
                                            + docentes[i].nombre + "</option>";
                                    }
                                }

                                $("#div_asignar_docentes").html("");
                                if(grupos.length > 0)
                                {
                                    for(i in grupos)
                                    {
                                        $("#div_asignar_docentes").append("<div class='grupo'" +
                                            " data-id_grupo='" + grupos[i].id_grupo + "' >" +
                                            "<div class='grupoNombre' >" + grupos[i].grupo + "</div>" +
                                            "<select class='docenteVal'>"+optionsDocentes+"</select></div>");
                                    }
                                }
                            }
                        });
                    }
                });
            }

            function declararFormaModal()
            {
                form_nueva_materia = $( "#formNuevaMateria" ).dialog({
                    autoOpen: false,
                    height: 300,
                    width: 600,
                    modal: true
                });
            }

            // Click a "Aceptar" ya se asignará la nueva materia al grado,
            // y se crearán las nuevas clases respectivas de cada grupo del grado
            function asignarNuevaMateria()
            {
                if(confirm("¿Están correctos los datos?"))
                {
                    $("#boton_agregar_materia").prop('disabled', true);

                    var nuevasClases = [];
                    $(".grupo").each(function()
                    {
                        var clase = {};
                        clase.id_grupo = $(this).attr('data-id_grupo');
                        clase.id_docente = $(this).children('.docenteVal').val();
                        nuevasClases.push(clase);
                    });

                    $.ajax({
                        type: "POST",
                        url: "../../includes/acciones/grados/agregar_materia.php",
                        data: "id_grado=" + $("#id_gradoVal").val()
                            + "&id_ciclo=" + $("#cicloVal").val()
                            + "&id_materia=" + $("#nuevaMateriaVal").val()
                            + "&nuevasClases=" + JSON.stringify(nuevasClases),
                        success: function (data)
                        {
                            if(data == 1) document.location.reload(true);
                        }
                    });
                }
            }

            /** Document ready */
            declararDataTable();
            declararFormaModal();

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
