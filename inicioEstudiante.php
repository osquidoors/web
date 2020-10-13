<?php
// Siempre iniciamos sesion
session_start();

if ( isset( $_SESSION['user_id'] ) ) {
    // estamos logeados correctamente. Podemos mostrar contenido, caso contrario nos vamos a login.php
?>
<html>
<body>
<?php echo "Bienvenido: ".$_SESSION['user_tipo']." - ".$_SESSION['user_nombre'];?>
<br/>
<hr/>
Materia: 
<select name="materia">
    <option value="0">Seleccionar materia</option>
<?php 
$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");

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
mysqli_close($conexion);
?>
</select>

</body>
</html>
<?php
} else {
    // Redirigimos a login
    header("Location: ./login.php");
}
?>