<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 20/07/2015
 * Time: 08:32 PM
 */

class ciclosControlador
{
    public function procesar($metodo, $verbo, $argumentos)
    {
        switch($metodo)
        {
            case "GET":
                switch($verbo)
                {
                    default:
                        return $this->getCiclos();
                        break;
                }
                break;
            case "POST":
                break;
            default:
                break;
        }
        return 404;
    }

    protected function getCiclos()
    {
        return CicloEscolarModelo::getLista();
    }
}