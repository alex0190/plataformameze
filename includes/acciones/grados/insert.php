<?php

include_once("../../clases/class_lib.php");
extract($_POST);
# grado
# area
# materias[]

@session_start();
$id_colegio = $_SESSION['id_colegio'];

$materias = json_decode($materias);
$ciclo_actual = CicloEscolar::getActual($id_colegio);

if(!isset($grado) || !isset($area))
{
    return 0;
    exit();
}
else
{
    if(Grado::insert($ciclo_actual->id_ciclo_escolar, $area, $grado, $materias, $id_colegio))
    {
        return 1;
        exit();
    }
}
?>