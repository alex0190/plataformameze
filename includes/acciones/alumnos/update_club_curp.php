<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 10/4/14
 * Time: 11:54 AM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# id_persona
# club
# CURP
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_persona,$id_colegio);

$alumno->setClubDeportivo($club);
$alumno->setCURP($CURP);