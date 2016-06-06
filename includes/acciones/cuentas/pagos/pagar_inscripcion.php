<?php
/**
 * Created by PhpStorm.
 * User: Gustavo
 * Date: 20/03/14
 * Time: 11:36 AM
 */

$id_modulo = 17; // Cuentas - Pagos

include_once("../../../clases/class_lib.php");

extract($_POST);
# id_cuenta
# monto
# id_forma_pago
# comentario

$cuenta = new Cuenta($id_cuenta);
$recibo = Cuenta::generarNuevoRecibo();
$cuenta->agregarPago($monto, $id_forma_pago, $recibo, $comentario);
echo $recibo;