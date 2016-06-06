<?php
/** Created by 
 * gus@yozki.net
 * @yozki
 */

$id_modulo = 7; // Alumnos - Inscribir

include_once("../../includes/clases/class_lib.php");

extract($_POST);
# id_alumno
# id_grupo
@session_start();
$id_colegio = $_SESSION['id_colegio'];

$alumno = new Alumno($id_alumno,$id_colegio);
if($alumno->inscribirEnGrupo($id_grupo)) echo 1;
else echo 2;
?>