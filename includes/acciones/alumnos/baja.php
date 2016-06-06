<?php
/** Created by 
 * gus@yozki.net
 * @yozki
 */

$id_modulo = 37; // Alumnos - Baja

include_once("../../clases/class_lib.php");

extract($_POST);
# id_persona

$alumno = new Alumno($id_persona);
if($alumno->darBaja()) echo 1;
else echo 0;