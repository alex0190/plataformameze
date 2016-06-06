<?php

include("../../clases/class_lib.php");
extract($_POST);
# id_alumno
# telefono
# tipo_telefono
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_alumno,$id_colegio);
if ($alumno->agregarTelefono($telefono, $tipo_telefono)) echo 1; else echo 0;