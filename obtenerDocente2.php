<?php
/*$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");

if(! $conexion ) {
    echo "Error en la conexion a MySQL: ".mysqli_error();
    die();
}

$sql = "SELECT m.* FROM materia_has_estudiante mhe, materia m WHERE mhe.Estudiante_rude='".$_SESSION['user_id']."' AND mhe.Materia_idMateria=m.idMateria;";
$resultado = mysqli_query($conexion, $sql);
if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
    while($filas = mysqli_fetch_assoc($resultado)) {
        echo '<option value="'.$filas['idMateria'].'">'.$filas['nombre_mat'].'</option>';
    } // while
} // if empty
mysqli_close($conexion); */
$docentes = array(0=>"Seleccionar",1=>"Ximena",2=>"Dania",3=>"Magali");
echo json_encode($docentes);
?>