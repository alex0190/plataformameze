<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 21/08/14
 * Time: 05:33 PM
 */


include_once("../../clases/class_lib.php");
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$docentes = Maestro::getListaVigentes($id_colegio);
echo json_encode($docentes);