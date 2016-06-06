<?php

include_once("../../clases/class_lib.php");

$idcolegio = $_POST['idcolegio'];
$areas[0]['area'] = 'Kinder';
$areas[1]['area'] = 'Primaria';
$areas[2]['area'] = 'Secundaria';
$areas[3]['area'] = 'Bachillerato';
$areas[4]['area'] = 'Ingenieria';
$areas[0]['prefijo'] = 'KIN';
$areas[1]['prefijo'] = 'PRI';
$areas[2]['prefijo'] = 'SEC';
$areas[3]['prefijo'] = 'BCH';
$areas[4]['prefijo'] = 'ING';
$areas[0]['parciales'] = 5;
$areas[1]['parciales'] = 5;
$areas[2]['parciales'] = 5;
$areas[3]['parciales'] = 3;
$areas[4]['parciales'] = 3;

for($i = 0; $i < count($areas); $i++)
{
  $resultado = Area::insert($areas[$i]['area'], $areas[$i]['prefijo'], $areas[$i]['parciales'], $idcolegio);
}
echo $resultado;
exit();

?>