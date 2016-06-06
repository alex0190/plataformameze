<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 11/3/14
 * Time: 6:03 PM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# idcolegio
# telefono

$colegio = new Colegio($idcolegio);
$colegio->updateTelefono($telefono);
?>