<?php

$id_modulo = 1; // Administradores - Nuevo

include_once("../../clases/class_lib.php");

extract($_POST);
# apellido_paterno
# apellido_materno
# nombres
# sexo
# idcolegio

if(!isset($apellido_paterno) || !isset($nombres))
{
    echo "error";
    exit();
}
else
{
    echo Administrador::insert($apellido_paterno, $apellido_materno, $nombres, $sexo, $idcolegio);
}
?>