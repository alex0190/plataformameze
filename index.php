<?php
include_once("includes/clases/class_lib.php");
@session_start();
if(!empty($_SESSION['id_persona']))
$usuario = new Persona($_SESSION['id_persona']);
?>
<html>
    <head>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
		<link rel="Shortcut Icon" href="images/logo.ico">
		<title>Sistema Integral Meze</title>

		<!-- Bootstrap Core CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">

		<!-- Plugin CSS -->
		<link rel="stylesheet" href="css/animate.min.css" type="text/css">
		<link rel="stylesheet" type="text/css" href="plugins/assets/css/animations.css">

		<!-- Custom CSS -->
		<link rel="stylesheet" href="css/creative.css" type="text/css">
    </head>

            <?php
			  if(!empty($usuario))
			  {
                switch($usuario->tipo_persona)
				{
                    case 3: include_once("indexAdmin.php"); break;
                    case 2: include_once("indexDocente.php"); break;
                    case 1: include_once("indexAlumno.php"); break;
                    default:  break;
                }
			  }
			  else
				  include_once("indexSuperAdmin.php");
            ?>
</html>
<!-- jQuery -->
    <script src="scripts/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="scripts/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="scripts/jquery.easing.min.js"></script>
    <script src="scripts/jquery.fittext.js"></script>
    <script src="scripts/wow.min.js"></script>

    <!-- JavaScript Plugin-->
    <script src="scripts/creative.js"></script>
	<!---- Other Effects --->
	<script src="plugins/assets/js/backbone.js" type="text/javascript"></script>
	<script src="plugins/assets/js/appear.min.js" type="text/javascript"></script>
	<script src="plugins/assets/js/animations.js" type="text/javascript"></script>

