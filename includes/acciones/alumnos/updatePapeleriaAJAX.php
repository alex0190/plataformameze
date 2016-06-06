<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 9/05/14
 * Time: 11:31 AM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# id_alumno
# papeleria
@session_start();
$id_colegio = $_SESSION['id_colegio'];

$papeleria = str_replace('\"','"', $papeleria);
$papeleria = json_decode($papeleria);

$alumno = new Alumno($id_alumno,$id_colegio);
echo $alumno->setPapeleria($papeleria);
?>