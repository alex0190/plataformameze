<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 9/30/14
 * Time: 3:00 PM
 */

$id_modulo = 45; // 45 - Configuración - Colonias

include_once("../../../clases/class_lib.php");

$colonias = Colonia::getColonias();

$json = array();

if(is_array($colonias))
{
    foreach($colonias as $colonia)
    {
        $temp = array();
        array_push($temp, $colonia['nombre']);
        array_push($json, $temp);
    }
}

echo json_encode(array("aaData" => $json));
?>