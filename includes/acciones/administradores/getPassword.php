<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 9/30/14
 * Time: 6:38 PM
 */

$id_modulo = 1; // Administradores - Nuevo

include_once("../../clases/class_lib.php");

extract($_POST);
# id_administrador

$administrador = new Administrador($id_administrador);
if($administrador->tipo_persona == 1 || $administrador->tipo_persona == 2)
{
    echo "*******";
}
else
{
    echo $administrador->password;
}
?>