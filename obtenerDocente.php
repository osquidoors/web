<?php
if(isset($_GET['idmateria'])){
    $conexion = mysqli_connect("localhost", "root", "", "mi_prueba");
    if(! $conexion ) {
        echo "Error en la conexion a MySQL: ".mysqli_error();
        die();
    }

    // creamos un arreglo para retornar la respuesta
    $docentesDeMateria = array();    //almacenará todos los campos de docente
    $docentesDeMateria[] = "-- Seleccionar docente --"; // lo primero que agregamos

    $id_materia=$_GET['idmateria'];
    $sql = "SELECT d.* FROM materia_has_docente mhd, docente d WHERE mhd.Materia_idMateria=$id_materia AND mhd.Docente_idDocente=d.idDocente;";
    // echo $sql; die();
    $resultado = mysqli_query($conexion, $sql);
    if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
        while($fila = mysqli_fetch_assoc($resultado)) {
            $docentesDeMateria[ $fila['idDocente'] ] = $fila['nombre_doc'].' '.$fila['app_doc'].' '.$fila['apm_doc'];
        } // while
    } // if empty
    mysqli_close($conexion);
}
echo json_encode($docentesDeMateria);    //json_encode es una función de PHP que convierte el arreglo $docentes en comprensible a javascript
?>