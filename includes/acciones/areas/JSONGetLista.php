<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 11/01/2015
 * Time: 01:31 PM
 */

include_once("../../clases/class_lib.php");
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$areas = Area::getLista($id_colegio);
echo json_encode($areas);