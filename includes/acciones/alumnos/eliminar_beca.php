<?php
/** Created by 
 * gus@yozki.net
 * @yozki
 */

$id_modulo = 10; // Becas - Nueva

include_once("../../clases/class_lib.php");

extract($_GET);
# id_alumno
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_alumno,$id_colegio);

$id_ciclo_actual = CicloEscolar::getActual($id_colegio)->id_ciclo_escolar;
if($alumno->quitarBecasCiclo($id_ciclo_actual))
{
    header('Location: ../../../admin/becas/lista.php');
}
else
{
    header('Location: ../../../admin/becas/lista.php');
}
?>