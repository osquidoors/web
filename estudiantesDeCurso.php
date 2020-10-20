<?php
// Siempre iniciamos sesion
session_start();

if ( isset( $_SESSION['user_id'] ) ) {      //isset función que verifica la existencia de una variable user_id en $_SESSION (si existe un usuario logueado)
    // estamos logueados correctamente. Podemos mostrar contenido, caso contrario nos vamos a login.php
?>
<html>
<body>
<?php echo "Bienvenido: ".$_SESSION['user_tipo']." - ".$_SESSION['user_nombre'];?>
<br/>
<hr/>
<?php 
// recuperar el nombre del curso
?>
<form>
<table border="1">
<tr>
    <th>N&deg;</th>
    <th>Estudiante</th>
    <th>Nota Tri1</th>
    <th>Nota Tri2</th>
    <th>Nota Tri3</th>
    <th>Promedio</th>
</tr>
<?php
$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");

if(! $conexion ) {
    echo "Error en la conexion a MySQL: ".mysqli_error();
    die();
}

$_idCurso = $_GET['curso'];
$sql = "SELECT * FROM estudiante WHERE Curso_idCurso='$_idCurso';";
// recuperamos las cursos del docente logueado
$resultado = mysqli_query($conexion, $sql);     //$resultado almacena todas las filas resultantes de la consulta
$cont = 0;
if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
    while($fila = mysqli_fetch_assoc($resultado)) {     //recorre todas las filas encontradas
        $cont++;
        $_identificador = $fila['rude'];
        echo "<tr>";
        echo "    <td>$cont</td>";
        echo "    <td>".$fila["nombre_est"]." ".$fila["app_est"]." ".$fila["apm_est"]."</td>";
        echo "    <td><input type='text' id='$_identificador-t1'></td>";
        echo "    <td><input type='text' id='$_identificador-t2'></td>";
        echo "    <td><input type='text' id='$_identificador-t3'></td>";
        echo "    <td>Prom</td>";
        echo "</tr>";
    } // while
} // if empty
mysqli_close($conexion);
?>
</table>
<input type="submit" value="Guardar notas"/>
</form>
</html>
<?php
} else {
    // Redirigimos a login
    header("Location: ./login.php");
}
?>