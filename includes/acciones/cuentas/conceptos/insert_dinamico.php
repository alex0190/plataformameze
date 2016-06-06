<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 12/30/14
 * Time: 9:05 PM
 */

$id_modulo = 49; // 49 - Cuentas - Dinámicas

include_once("../../../clases/class_lib.php");


extract($_POST);
# concepto
# montos (JSON)

$montos = json_decode($montos);

Concepto::insert($concepto, $montos);
?>