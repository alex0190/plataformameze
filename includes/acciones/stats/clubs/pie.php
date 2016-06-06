<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 10/31/14
 * Time: 6:03 PM
 */


include_once("../../../clases/class_lib.php");

$dist = Club::getDistribucion();

$arr = array();
if(is_array($dist))
{
    foreach($dist as $club)
    {
        array_push($arr, array(
            "value" => $club['alumnos'],
            "color" => "#".random_color(),
            "label" => $club['club']
        ));
    }
    echo json_encode($arr);
}
else
{
    echo json_encode(array("value" => 0, "color" => "#FFFFFF"));
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}