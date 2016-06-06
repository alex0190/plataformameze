<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 12/11/14
 * Time: 9:09 PM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# id_persona
# peso
# talla
# IMC

@session_start();
$id_colegio = $_SESSION['id_colegio'];
$persona = new Persona($id_persona,$id_colegio);
$persona->nuevoRegistroNutricion($peso, $talla, $IMC);
