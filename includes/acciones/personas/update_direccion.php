<?php
/** Created by 
 * gus@yozki.net
 * @yozki
 */

$id_modulo = 7; // Alumnos - Inscribir

include_once("../../clases/class_lib.php");

extract($_POST);
# id_alumno
# calle
# numero
# colonia
# CP
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_persona,$id_colegio);
$alumno->setDireccion($calle, $numero, $colonia, $CP);