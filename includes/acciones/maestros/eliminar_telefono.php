<?php

include_once("../../clases/class_lib.php");
extract($_GET);
# id_telefono

$telefono = new Telefono($id_telefono);
$id_persona = $telefono->id_persona;

if($telefono->eliminar())
{
    header('Location: ../../../admin/maestros/perfil.php?id_maestro='.$id_persona);
}
else
{
    header('Location: ../../../admin/maestros/perfil.php?id_maestro='.$id_persona.'&error=2');
}
?>