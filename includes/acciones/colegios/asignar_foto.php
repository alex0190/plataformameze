<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 10/29/14
 * Time: 4:04 PM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# id_colegio
# imagen

$colegio = new Colegio($id_colegio);
echo $colegio->subirImagen($imagen);
?>