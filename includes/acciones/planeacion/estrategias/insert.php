<?php
/**
 * Created by 
 * gus@yozki.net
 * @yozki
 */


include_once("../../../clases/class_lib.php");
extract($_POST);
# estrategia
# id_tema

if(Estrategia::insert($estrategia, $id_tema)) echo 1;
else echo 0;