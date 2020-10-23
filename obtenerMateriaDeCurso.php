<?php
session_start();
// creamos un arreglo para retornar la respuesta
$materiasDeDocente = array();    //almacenará todos los campos de docente
$materiasDeDocente[] = "-- Seleccionar materia --"; // lo primero que agregamos es el texto Seleccionar Docente

if(isset($_GET['idcurso'])){
    $conexion = mysqli_connect("localhost", "root", "", "mi_prueba");
    if(! $conexion ) {
        echo "Error en la conexion a MySQL: ".mysqli_error();
        die();
    }

    $id_curso=$_GET['idcurso'];
    $id_docente = $_SESSION['docente'];
    $sql = "SELECT m.* FROM materia_has_docente mhd, materia m WHERE mhd.Curso_idCurso=$id_curso AND mhd.Docente_idDocente=$id_docente AND mhd.Materia_idMateria=m.idMateria;";
    // echo $sql; die();
    $resultado = mysqli_query($conexion, $sql);
    if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
        while($fila = mysqli_fetch_assoc($resultado)) {
            $materiasDeDocente[ $fila['idMateria'] ] = $fila['nombre_mat']; 
        } // while
    } // if empty
    mysqli_close($conexion);
}
echo json_encode($materiasDeDocente);    //json_encode es una función de PHP que convierte el arreglo $docentes en comprensible a javascript
?>