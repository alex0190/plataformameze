<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 12/03/14
 * Time: 05:24 PM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# id_alumno
# id_ciclo_escolar
@session_start();
$id_colegio = $_SESSION['id_colegio'];
if(!is_null($id_alumno))
{
    $alumno = new Alumno($id_alumno,$id_colegio);
    if(!is_null($alumno->id_persona))
    {
        header('Content-Type: application/json');
        echo json_encode($alumno->getInscripcionStatus($id_ciclo_escolar));
    }

}
?>