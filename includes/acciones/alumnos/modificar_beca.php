<?php
/** Created by 
 * gus@yozki.net
 * @yozki
 */

$id_modulo = 10; // Becas - Nueva

include_once("../../clases/class_lib.php");

extract($_POST);
# id_alumnoVal
# id_ciclo_escolar
# id_subtipoVal // Viejo
# subtipoVal // Nuevo
# becaVal
# cicloVal
@session_start();
$id_colegio = $_SESSION['id_colegio'];
print_r($_POST);

$alumno = new Alumno($id_alumnoVal,$id_colegio);
if($alumno->quitarBeca($id_ciclo_escolar, $id_subtipoVal))
{
    if($alumno->asignarBeca($becaVal, $subtipoVal, $cicloVal))
    {
        header('Location: ../../../admin/becas/lista.php');
    }
    else
    {
        header('Location: ../../../admin/becas/nueva.php?error=1');
    }
}
else
{
    header('Location: ../../../admin/becas/modificar.php?id_alumno='.$id_alumnoVal.'&error=2');
}
?>