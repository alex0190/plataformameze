<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 10/4/14
 * Time: 3:45 PM
 */

$id_modulo = 47; // 47 - Configuración - Ocupaciones

include_once("../../../clases/class_lib.php");


$ocupaciones = Tutor::getOcupaciones();

$json = array();

if(is_array($ocupaciones))
{
    foreach($ocupaciones as $ocupacion)
    {
        $temp = array();
        array_push($temp, $ocupacion['ocupacion']);
        array_push($json, $temp);
    }
}

echo json_encode(array("aaData" => $json));
?>