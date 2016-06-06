<?php
/** Created by 
 * gus@yozki.net
 * @yozki
 */

$id_modulo = 21; // Cuentas - Nuevo pago

include_once("../../../clases/class_lib.php");

extract($_POST);
# id_concepto

$concepto = new Concepto($id_concepto);
echo $concepto->monto_sugerido;