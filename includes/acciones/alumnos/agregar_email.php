<?php

include("../../clases/class_lib.php");
extract($_POST);
# id_alumno
# email
# tipo_email
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_alumno,$id_colegio);
if ($alumno->agregarEmail($email, $tipo_email)) echo 1; else echo 0;
?>