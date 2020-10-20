<?php
// creamos un arreglo para retornar la respuesta
$docentes = array();    //almacenará todos los campos de docente
$docentes[] = "Seleccionar docente"; // lo primero que agregamos es el texto Seleccionar Docente

if(isset($_GET['idmateria'])){
    $idmateria=$_GET['idmateria'];
    $conexion = mysqli_connect("localhost", "root", "", "mi_prueba");
    if(! $conexion ) {
        echo "Error en la conexion a MySQL: ".mysqli_error();
        die();
    }

    $sql = "SELECT d.idDocente, d.nombre_doc, d.app_doc, d.app FROM Docente d, materia_has_docente mhd, materia m WHERE m.idMateria='$idmateria' AND m.idMateria=mhd.Materia_idMateria AND d.idDocente=mhd.Docente_idDocente;";
    // echo $sql; die();
    // recuperamos todos los docentes que dictan una determinada materia
    $resultado = mysqli_query($conexion, $sql);     //$resultado almacena todas las filas resultantes de la consulta
    if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
        while($fila = mysqli_fetch_assoc($resultado)) {     //recorre todas las filas encontradas
            //$docentes[ $fila['idDocente'] ] = $fila['nombre_doc']; //docentes[idDocente] = nombre_doc
            $docentes[ $fila['idDocente'] ] = $fila['nombre_doc'].' '.$fila['app_doc']; 
        } // while
    } // if empty
    mysqli_close($conexion);
}
echo json_encode($docentes);    //json_encode es una función de PHP que convierte el arreglo $docentes en comprensible a javascript
?>