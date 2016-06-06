<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 31/03/14
 * Time: 02:25 PM
 */


include_once("../../clases/class_lib.php");
extract($_POST);
# id_alumno
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_alumno,$id_colegio);
$ciclos = $alumno->getCiclosInscrito();

if(is_array($ciclos))
{
    foreach($ciclos as $ciclo)
    {
        echo "<option value='".$ciclo['id_ciclo_escolar']."' >".$ciclo['ciclo_escolar']."</option>";
    }
}
?>