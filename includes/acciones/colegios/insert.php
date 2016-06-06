<?php

include_once("../../clases/class_lib.php");

$nombre = $_POST['nombre'];
$ciudad = $_POST['ciudad'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$estado = $_POST['estado'];

if(!isset($nombre) || !isset($ciudad) || !isset($direccion) || !isset($telefono))
{
    echo "error";
    exit();
}
else
{
    $resultado = Colegio::insert($ciudad, $estado, $nombre, $direccion, $telefono);
	echo $resultado;
	exit();
}
?>