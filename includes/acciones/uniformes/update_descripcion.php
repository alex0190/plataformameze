<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 2/27/14
 * Time: 6:40 PM
 */

include_once("../../clases/class_lib.php");

extract($_POST);
# id_uniforme
# descripcion

if(!is_null($id_uniforme) || !is_null($descripcion))
{
    $uniforme = new Uniforme($id_uniforme);
    echo $uniforme->setDescripcion($descripcion);
    exit();
}
else
{
    echo "0"; exit();
}