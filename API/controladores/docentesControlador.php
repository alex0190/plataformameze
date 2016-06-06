<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 28/07/2015
 * Time: 07:56 PM
 */

class docentesControlador
{
    public function procesar($metodo, $verbo, $argumentos)
    {
        switch ($metodo) {
            case "GET":
                return $this->getDocentes();
                break;
            default:
                break;
        }
        return 404;
    }

    public function getDocentes()
    {
        return DocenteModelo::getLista();
    }
}