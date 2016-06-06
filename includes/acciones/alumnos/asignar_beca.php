<?php
$id_modulo = 10; // Becas - Nueva

include_once("../../clases/class_lib.php");

extract($_POST);
# id_alumnoVal
# alumnoVal
# becaVal
# tipoVal
# subtipoVal
# cicloVal
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_alumnoVal,$id_colegio);
if($alumno->asignarBeca($becaVal, $subtipoVal, $cicloVal))
{
    header('Location: ../../../admin/becas/lista.php');
}
else
{
    header('Location: ../../../admin/becas/nueva.php');
}
?>