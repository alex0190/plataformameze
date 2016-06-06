<?php
/**
 * Created by 
 * gus@yozki.net
 * @yozki
 */


include_once("../../../clases/class_lib.php");
extract($_POST);
# metodo
# id_tema

if(Metodo::insert($metodo, $id_tema)) echo 1;
else echo 0;