<?php

include_once("../../clases/class_lib.php");
extract($_POST);
# id_persona
# passwordVal
# password2Val

@session_start();
$id_colegio = $_SESSION['id_colegio'];

if(!isset($passwordVal) || !isset($password2Val)) { echo 0; exit(); }
if((strlen($passwordVal) == 0) || strlen($password2Val) == 0) { echo 0; exit(); }

$persona = new Persona($id_persona,$id_colegio);

if($persona->cambiarPassword($passwordVal))
{
    echo 1; exit();
}
else
{
    echo 0; exit();
}