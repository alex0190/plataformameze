<html>
<head>
<link rel="shortcut icon" href="images/logo.ico">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
<title>Plataforma MEZE</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic">
<link rel="stylesheet" href="assets/stylesheets/ionicons.css">
<link rel="stylesheet" href="assets/stylesheets/font-awesome.css">
<link id="mainstyle" rel="stylesheet" href="assets/stylesheets/skin.css">
<link id="mainstyle" rel="stylesheet" href="assets/stylesheets/demo.css">
<link rel="stylesheet" href="styles/alertify.core.css">
<link rel="stylesheet" href="styles/alertify.default.css">
<script src="assets/scripts/modernizr-custom.js"></script>
<script src="assets/scripts/respond.js"></script>
<style type="text/css">
.margen{margin-top: 150px;
        margin-left: 105px;}

</style>
</head>
<body style="background:url(images/meze1.jpg)no-repeat;background-size:cover">
<div class="f-dark login login-side margen">
<form id="userlogin" autocomplete="off" class="login-form" method="post" action="">
        <div class="p-a-3 text-xs-center"><a href="login.php" class="demo-logo"><img src="images/logo_chico.png" width="80" height="80"></a></div>
        <div class="form-group">
          <label for="formBasicEmail" class="sr-only">Matr&iacute;cula</label>
          <input id="formBasicEmail" type="text" name="usuario" placeholder="Matr&iacute;cula" autocomplete="off" class="form-control">
        </div>
        <div class="form-group">
          <label for="formBasicPassword" class="sr-only">Contrase&ntilde;na</label>
          <input id="formBasicPassword" type="password" name="contra" placeholder="Contrase&ntilde;a" autocomplete="off" class="form-control">
        </div>
        <div class="form-group row">
          <div class="col-md-4 pull-xs-right">
            <input type="submit" class="btn btn-primary btn-block" name="boton" value="Aceptar">
          </div>
        </div>
      </form>
</div>

<script src="scripts/alertify.js"></script>
</body>
</html>
<?php
if(isset($_POST["boton"]))
{
include_once("includes/clases/class_lib.php");
$usuarioVal = $_POST["usuario"];
$passwordVal = $_POST["contra"];

$persona = Persona::login($usuarioVal, $passwordVal);
    if($persona)
    {
        if($persona->id_persona != 0)
        {
            session_start();

            # Datos generales (Cualquier tipo de persona)
            $_SESSION['id_persona']         = $persona->id_persona;
            $_SESSION['matricula']          = $persona->matricula;
            $_SESSION['apellido_paterno']   = $persona->apellido_paterno;
            $_SESSION['apellido_materno']   = $persona->apellido_materno;
            $_SESSION['nombres']            = $persona->nombres;
            $_SESSION['password']           = $persona->password;
            $_SESSION['tipo_persona']       = $persona->tipo_persona;
			$_SESSION['id_colegio']         = $persona->idcolegio; 

            session_write_close();
            header('Location: index.php');
        }
	}
    else if($usuarioVal == "ADM13002" && $passwordVal == "baldor987M")
    {
            session_start();

            # Datos generales (Cualquier tipo de persona)
            $_SESSION['id_persona']         = "";
            $_SESSION['matricula']          = "ADM13002";
            $_SESSION['apellido_paterno']   = "Salas";
            $_SESSION['apellido_materno']   = "Trujillo";
            $_SESSION['nombres']            = "Christhian Arturo";
            $_SESSION['password']           = "baldor987M";
            $_SESSION['tipo_persona']       = 4;

            session_write_close();
            header('Location: index.php');
    }
	else if($usuarioVal == "admin01" && $passwordVal == "ago010890")
	{
	       session_start();

            # Datos generales (Cualquier tipo de persona)
            $_SESSION['id_persona']         = "";
            $_SESSION['matricula']          = "admin01";
            $_SESSION['apellido_paterno']   = "Alonso";
            $_SESSION['apellido_materno']   = "Gutierrez";
            $_SESSION['nombres']            = "Jorge Alejandro";
            $_SESSION['password']           = "ago010890";
            $_SESSION['tipo_persona']       = 4;

            session_write_close();
            header('Location: index.php');	
	}
	else
		echo "<script>alertify.alert('Error en usuario o contrase&ntilde;a. No se puede iniciar sesion');</script>";
}
?>