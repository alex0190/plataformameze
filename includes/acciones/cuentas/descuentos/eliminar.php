<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 9/01/14
 * Time: 02:44 PM
 */

$id_modulo = 39; // Cuentas - Descuento

include_once("../../../clases/class_lib.php");

extract($_POST);
# id_descuento

$descuento = new Descuento($id_descuento);

if(is_null($descuento->fecha_utilizacion))
{
    if($descuento->eliminar()) echo 1;
    else echo 0;
}
else echo 2;