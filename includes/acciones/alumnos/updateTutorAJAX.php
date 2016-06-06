<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 13/05/14
 * Time: 01:14 PM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# datos (JSON)
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$datos = str_replace('\"','"', $datos);
$datos = json_decode($datos);

$alumno = new Alumno($datos->id_alumno,$id_colegio);
echo $alumno->updateTutor($datos->id_tipo_tutor, $datos->nombre, $datos->calle, $datos->numero,
    $datos->colonia, $datos->CP, $datos->telefonos, $datos->celular,0,"");