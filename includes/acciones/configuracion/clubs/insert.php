<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 9/30/14
 * Time: 2:50 PM
 */

$id_modulo = 44; // 44 - Configuración - Clubs

include_once("../../../clases/class_lib.php");

extract($_POST);
# nombre

if(Club::insert($nombre) > 0) echo 1;
else echo 0;
?>