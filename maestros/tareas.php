<?php
@session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8" />
	<title></title>
	<link rel="stylesheet" href="../css/bootstrap.css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/flick/jquery-ui.css">
	</head>
<body>
<div id="principal" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2" style="margin-top:50px;">
<div id="area_trabajo">
						<section class="col-md-6">
							 <label>Fecha de entrega</label>
							<input type="text" id="fecha_entregaVal" class="form-control"  /><br><br>
							<label class="col-md-offset-6">Clase</label>
							<select id="id_claseVal" class="form-control col-md-offset-6">
								<!-- [GET] API/clases -->
							</select><br><br>
							<label class="col-md-offset-6">Descripción</label>
							<textarea id="descripcionVal" class="form-control col-md-offset-6" ></textarea><br><br>
							<button onclick="asignarTarea()" class="btn btn-primary col-md-offset-11" style="margin-bottom:10px;"><span class="glyphicon glyphicon-plus"></span> Asignar</button>
                            <div id="panel_imagen">
                                <!-- loader.gif -->
                                <img style="display:none" id="loader" src="../media/imagenes/loader.gif" alt="Cargando...." title="Cargando...." />
                                <!-- simple file uploading form -->
                                <form id="form_imagen" action="../includes/ajaxuploadTareas.php" method="post" enctype="multipart/form-data">
                                    <input id="uploadImage" type="file" accept="image/*,application/pdf" name="image" value="Seleccionar foto"/><br><br>
                                    <input id="button" type="submit" value="Subir" class="btn btn-warning">
                                </form>
                            </div>
						 </section>
					</div><!--area_trabajo-->
					<section class="row" id="tareasContent">
						<!--- getTareas();---->
					</section>
</div>
</body>
</html>
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/bootstrap.js" type="text/javascript"></script>
<script src="../plugins/assets/js/appear.min.js" type="text/javascript"></script>
<script src="../plugins/assets/js/animations.js" type="text/javascript"></script>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
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

    var Tarea = {
        section: function(estatus){
            var data;
            data = $("<section/>");
             if(estatus  ==  "1")
                data.addClass("btn-success col-md-4 col-lg-4").css("height","200px");
            else
                data.addClass("btn-warning col-md-4 col-lg-4").css("height","200px");;

            return data;
        },
        fecha_encargo : function(fecha_encargo){
            return $("<h6/>").text("Fecha de encargo: "+fecha_encargo)
        },
        clase : function(claseName){
            return $("<h3/>").text(claseName)
        },
        description: function(descContent){
            return $("<article/>").text(descContent)
        },
		fecha_entrega: function(fecha_entrega){
			return $("<h6/>").text(fecha_entrega)
		}
		
    }
	$(document).ready(function () {
		$.datepicker.setDefaults($.datepicker.regional["es"]);
		$("#fecha_entregaVal").datepicker({
			firstDay: 1,
            dateFormat: 'yy-mm-dd',
            onSelect: function(dateText) {
                cargarTareasFecha();
            }
		});
	});

    function cargarTareasFecha()
    {
        var fecha_entrega = $("#fecha_entregaVal").val();
        $.ajax({
            url: "../API/tareas/fecha/" + fecha_entrega,
            type:"GET",
            dataType: "JSON",
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Basic " + btoa('<?php echo $_SESSION['matricula']; ?>' +":"+ '<?php echo $_SESSION['password'] ?>'));
            }
        }).done(function(data){
            var $content;
            $("#tareasContent").empty();
            $.each(data,function(i,o){
                $content =  Tarea.section(this.completada);
                -					$("#tareasContent").append($content);
                -					$($content).append(Tarea.fecha_encargo(this.fecha_encargo),Tarea.clase(this.materia),Tarea.description(this.descripcion),Tarea.fecha_entrega(this.fecha_entrega));
            });
            console.log(data);
        }).fail(function(error,status){
            console.log(error);
            console.log(status);
        });
    }

    cargarClases();
    getTareas();

    function getTareas()
	{
		$.ajax({
			url: "../API/tareas",
			type:"GET",
			dataType: "JSON",
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Basic " + btoa('<?php echo $_SESSION['matricula']; ?>' +":"+ '<?php echo $_SESSION['password'] ?>'));
            }
		}).done(function(data){
				var $content;
				$("#tareasContent").empty();
				$.each(data,function(i,o){
					$content =  Tarea.section(this.completada);		
-					$("#tareasContent").append($content);		
-							$($content).append(Tarea.fecha_encargo(this.fecha_encargo),Tarea.clase(this.materia),Tarea.description(this.descripcion),Tarea.fecha_entrega(this.fecha_entrega));
				});
				console.log(data);
			}).fail(function(error,status,statusText){
				console.log(error);
				console.log(status);
				console.log(statusText);
			});
	}

    function cargarClases()
    {
        $.ajax({
            type: "GET",
            url: "../API/clases",
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Basic " + btoa('<?php echo $_SESSION['matricula']; ?>' +":"+ '<?php echo $_SESSION['password'] ?>'));
            },
            success: function (data) {
                jQuery.each(data, function () {
                    $("#id_claseVal").append("<option value='" + this.id_clase + "'>" + this.descripcion + "</option>");
                });
            }
        });
    }

    function asignarTarea()
    {
        var id_clase = $("#id_claseVal").val();
        var descripcion = $("#descripcionVal").val();
        var fecha_entrega = $("#fecha_entregaVal").val();
        $.ajax({
            type: "POST",
            url: "../API/tareas",
            beforeSend: function (xhr) {
                xhr.setRequestHeader("Authorization", "Basic " + btoa('<?php echo $_SESSION['matricula']; ?>' +":"+ '<?php echo $_SESSION['password'] ?>'));
            },
            data: "id_clase=" + id_clase + "&descripcion=" + descripcion + "&fecha_entrega=" + fecha_entrega,
            success: function (data)
            {
                alert("Tarea asignada.");
				getTareas();
            }
        });
    }
</script>