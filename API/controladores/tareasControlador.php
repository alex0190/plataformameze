<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 20/07/2015
 * Time: 08:32 PM
 */

class tareasControlador
{
    public function procesar($metodo, $verbo, $argumentos)
    {
        switch($metodo)
        {
            case "GET":
                $persona = PersonaModelo::getPersonaPorCredenciales($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
                switch($persona->tipo_persona)
                {
                    case 1:                         // ALUMNOS
                        $alumno = new AlumnoModelo($persona->id_persona);
                        switch($verbo)
                        {
                            case "pendientes":
                                return $alumno->getTareasPendientes();
                                break;
                            case "fecha":
                                return $alumno->getTareasFecha($argumentos[0]);
                                break;
                            default:
                                return $alumno->getTareas();
                                break;
                        }
                        break;
                    case 2:                         // DOCENTES
                        $docente = new DocenteModelo($persona->id_persona);
                        switch($verbo)
                        {
                            case "pendientes":
                                return $docente->getTareasPendientes();
                                break;
                            case "fecha":
                                return $docente->getTareasFecha($argumentos[0]);
                                break;
                            default:
                                return $docente->getTareas();
                                break;
                        }
                        break;
                    case 3:                         // ADMINISTRADORES
                        switch($verbo)
                        {
                            case "pendientes":
                                return TareaModelo::getListaPendientes();
                                break;
                            case "fecha":
                                return TareaModelo::getListaFecha($argumentos[0]);
                                break;
                            default:
                                return TareaModelo::getLista();
                                break;
                        }
                        break;
                    default:
                        return 401;
                }
                break;
            case "POST":
                return $this->asignarTarea();
                break;
            default:
                return 401;
                break;
        }
        return 404;
    }

    public function asignarTarea()
    {
        TareaModelo::addTarea($_POST['id_clase'], $_POST['descripcion'], $_POST['fecha_entrega']);
    }
}