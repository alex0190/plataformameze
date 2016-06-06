<?php
/** Created by 
 * gus@yozki.net
 * @yozki
 */

$id_modulo = 35; // Maestros - Modificar

include_once("../../clases/class_lib.php");

extract($_POST);
# apellido_materno
# id_maestro

$maestro = new Maestro($id_maestro);
if($maestro->setApellidoMaterno($apellido_materno)) echo 1;
else echo 0;