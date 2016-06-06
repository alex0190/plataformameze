<?php
/**
 * Created by PhpStorm.
 * User: Yozki
 * Date: 28/07/2015
 * Time: 07:28 PM
 */

require_once("PersonaModelo.php");

class DocenteModelo extends PersonaModelo
{
    public static function getDocentePorCredenciales($matricula, $password)
    {
        $query = "SELECT * FROM persona WHERE matricula = '$matricula' AND password = '$password' AND tipo_persona = 2 LIMIT 1";
        $res = APIDatabase::select($query);
        $usuario = new PersonaModelo($res[0]['id_persona']);
        return $usuario;
    }

    public function getClases()
    {
        $query = "SELECT clase.*, CONCAT(grado.grado, '-', grupo.grupo, ' ', materia.materia) AS descripcion
            FROM clase
            JOIN grupo ON clase.id_grupo = grupo.id_grupo
            JOIN grado ON grupo.id_grado = grado.id_grado
            JOIN materia ON clase.id_materia = materia.id_materia
            WHERE clase.id_clase IN (SELECT id_clase FROM clase
            WHERE id_maestro = $this->id_persona)";
        return APIDatabase::select($query);
    }

    public function getTareas()
    {
        $query = "SELECT tarea.*, materia.materia, IF(fecha_entrega > fecha_encargo, true, false) AS completada FROM tarea
            JOIN clase ON clase.id_clase = tarea.id_clase
            JOIN materia ON materia.id_materia = clase.id_materia
            JOIN (SELECT id_clase FROM clase
            WHERE id_maestro = $this->id_persona) clases ON clases.id_clase = clase.id_clase";
        return APIDatabase::select($query);
    }

    public function getTareasFecha($fecha)
    {
        $query = "SELECT tarea.*, materia.materia, IF(fecha_entrega > fecha_encargo, true, false) AS completada FROM tarea
            JOIN clase ON clase.id_clase = tarea.id_clase
            JOIN materia ON materia.id_materia = clase.id_materia
            JOIN (SELECT id_clase FROM clase
            WHERE id_maestro = $this->id_persona) clases ON clases.id_clase = clase.id_clase
            WHERE fecha_entrega = '$fecha'";
        return APIDatabase::select($query);
    }

    public function getTareasPendientes()
    {
        $query = "SELECT tarea.*, materia.materia, IF(fecha_entrega > fecha_encargo, true, false) AS completada FROM tarea
            JOIN clase ON clase.id_clase = tarea.id_clase
            JOIN materia ON materia.id_materia = clase.id_materia
            JOIN (SELECT id_clase FROM clase
            WHERE id_maestro = $this->id_persona) clases ON clases.id_clase = clase.id_clase
            WHERE fecha_entrega >= CURDATE()";
        return APIDatabase::select($query);
    }

    public function getLista()
    {
        $query = "SELECT * FROM persona WHERE tipo_persona = 2";
        return APIDatabase::select($query);
    }
}