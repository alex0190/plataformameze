<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 8/20/14
 * Time: 4:31 PM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# grado
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$grado = new Grado($grado);
$ciclo = CicloEscolar::getActual($id_colegio);

$grupos = $grado->getGruposCiclo($ciclo->id_ciclo_escolar);
echo json_encode($grupos);