<?php

include_once("../../clases/class_lib.php");
extract($_POST);
# id_alumno
# alumnoVal
# becaVal
@session_start();
$id_colegio = $_SESSION['id_colegio'];
$alumno = new Alumno($id_alumno,$id_colegio);
$becas = $alumno->getHistorialBecas();

if(is_array($becas))
{
    foreach($becas as $beca)
    {
        echo "
            <tr>
                <td>".$beca['ciclo_escolar']."</td>
                <td>".$beca['usuario']."</td>
                <td>".$beca['beca']."</td>
            </tr>
        ";
    }
}

?>