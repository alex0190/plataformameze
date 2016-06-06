<?php

include_once("../../clases/class_lib.php");
extract($_POST);
# id_alumno
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_alumno,$id_colegio);
if(!is_null($alumno))
{
    echo json_encode($alumno);
}
else
{
    echo "error";
}
?>