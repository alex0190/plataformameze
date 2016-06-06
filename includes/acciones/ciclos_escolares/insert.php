<?php
$id_modulo = 15; // Ciclos escolares - Nuevo

include_once("../../clases/class_lib.php");

extract($_POST);
# fecha_inicio  : 'yy-mm-dd'
# fecha_fin     : 'yy-mm-dd'

@session_start();
$id_colegio = $_SESSION['id_colegio'];

if(CicloEscolar::insert($fecha_inicio, $fecha_fin, $id_colegio)) echo 1;
else echo 0;
?>