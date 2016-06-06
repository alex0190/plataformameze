<?php
/**
 * Created by PhpStorm.
 * User: 
 * Date: 7/08/14
 * Time: 12:05 PM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# id_alumno
# id_grupo
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_alumno,$id_colegio);
$alumno->cambiarGrupo($id_grupo);

echo 1;