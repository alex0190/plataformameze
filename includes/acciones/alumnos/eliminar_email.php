<?php

include_once("../../clases/class_lib.php");
extract($_GET);
# id_email

$email = new Email($id_email);
$id_persona = $email->id_persona;

if($email->eliminar())
{
    header('Location: ../../../admin/alumnos/perfil.php?id_alumno='.$id_persona);
    exit();
}
else
{
    header('Location: ../../../admin/alumnos/perfil.php?id_alumno='.$id_persona);
    exit();
}