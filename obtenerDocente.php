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
$combobox  = '<br/>Docente: ';
$combobox .= '<select id="materia">';
$combobox .= '<option value="1">Seleccionar Docente</option>';
$combobox .= '<option value="2">Ximena</option>';
$combobox .= '<option value="3">Dania</option>';
$combobox .= '<option value="4">Magali</option>';
$combobox .= '</selected>';
echo $combobox;
?>