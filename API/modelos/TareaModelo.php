<?php

class TareaModelo
{
    public function __construct($id_tarea)
    {

    }

    public static function getLista()
    {
        $query = 'SELECT tarea.*, materia.materia, IF(fecha_entrega > fecha_encargo, true, false) AS completada FROM tarea
            JOIN clase ON clase.id_clase = tarea.id_clase
            JOIN materia ON materia.id_materia = clase.id_materia';
        return APIDatabase::select($query);
    }

    public static function getListaPendientes()
    {
        $query = "SELECT id_tarea, clase.id_clase, descripcion, fecha_encargo, IF(fecha_entrega = 0, 'N/A', fecha_entrega) AS fecha_entrega, materia,
            materia.materia, IF(fecha_entrega > fecha_encargo, true, false) AS completada FROM tarea
            JOIN clase ON clase.id_clase = tarea.id_clase
            JOIN materia ON materia.id_materia = clase.id_materia
            WHERE tarea.id_clase IN (SELECT clase.id_clase FROM alumno_grupo
            JOIN clase ON clase.id_grupo = alumno_grupo.id_grupo
            JOIN materia ON clase.id_materia = materia.id_materia
            WHERE fecha_entrega >= CURDATE())";
        return APIDatabase::select($query);
    }

    public static function getListaFecha($fecha)
    {
        $query = "SELECT id_tarea, clase.id_clase, descripcion, fecha_encargo, IF(fecha_entrega = 0, 'N/A', fecha_entrega) AS fecha_entrega, materia,
            materia.materia, IF(fecha_entrega > fecha_encargo, true, false) AS completada FROM tarea
            JOIN clase ON clase.id_clase = tarea.id_clase
            JOIN materia ON materia.id_materia = clase.id_materia
            WHERE tarea.id_clase IN (SELECT clase.id_clase FROM alumno_grupo
            JOIN clase ON clase.id_grupo = alumno_grupo.id_grupo
            JOIN materia ON clase.id_materia = materia.id_materia
            WHERE fecha_entrega = '$fecha') ";
        return APIDatabase::select($query);
    }

    public static function addTarea($id_clase, $descripcion, $fecha_entrega)
    {
        $query = "INSERT INTO tarea VALUES(null, $id_clase, '$descripcion', NOW(), '$fecha_entrega');";
        echo $query;
        $id_tarea = APIDatabase::insert($query);
        return new self($id_tarea);
    }
}