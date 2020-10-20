<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$idmateria=$_GET["materia"];
$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");
if(! $conexion ) {
    echo "Error en la conexion a MySQL: ".mysqli_error();
    die();
}

$sql = "SELECT d.nombre_doc, d.app_doc, d.app FROM Docente d, materia_has_docente mhd, materia m WHERE m.idMateria=".$idmateria." AND m.idMateria=mhd.Materia_idMateria AND d.idDocente=mhd.Docente_idDocente;";
// recuperamos todas las materias del estudiante logueado
$resultado = mysqli_query($conexion, $sql);     //$resultado almacena todas las filas resultantes de la consulta
if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
    while($fila = mysqli_fetch_assoc($resultado)) {     //recorre todas las filas encontradas
        echo '<option value='.$fila['nombre_doc'].'>'.$fila['nombre_doc'].'</option>';   //Mostramos el nombre de la materia que corresponda al idMateria
    } // while
} // if empty
mysqli_close($conexion);