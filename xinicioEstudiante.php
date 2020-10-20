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
<form>
Materia: 
<select name="materia" onchange="this.form.submit()">     <!--  select es un combobox  on change enviará el valor del idMateria en cuanto el combobox cambie -->
    <option value="0">Seleccionar materia</option>      <!--  la 1ra opción "Selec..."-->
<?php 
$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");

if(! $conexion ) {
    echo "Error en la conexion a MySQL: ".mysqli_error();
    die();
}

$sql = "SELECT m.* FROM materia_has_estudiante mhe, materia m WHERE mhe.Estudiante_rude=".$_SESSION['rude']." AND mhe.Materia_idMateria=m.idMateria;";
// recuperamos todas las materias del estudiante logueado
$resultado = mysqli_query($conexion, $sql);     //$resultado almacena todas las filas resultantes de la consulta
if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
    while($fila = mysqli_fetch_assoc($resultado)) {     //recorre todas las filas encontradas
        echo '<option value="'.$fila['nombre_mat'].'">'.$fila['nombre_mat'].'</option>';   //Mostramos el nombre de la materia que corresponda al idMateria
    } // while
} // if empty
mysqli_close($conexion);
?>
</select>
</form>
<br/>
<?php
if(isset($_GET["materia"])){
    echo "Materia: ".$_GET["materia"];
}
?>
<br/>
Docente: 
<select name="docente">     <!--  select es un combobox-->
    <option value="0">Seleccionar docente</option>      <!--  la 1ra opción "Selec..."-->
<?php 
if(isset($_GET["materia"])){
    $materia=$_GET["materia"];
    $conexion = mysqli_connect("localhost", "root", "", "mi_prueba");
    if(! $conexion ) {
        echo "Error en la conexion a MySQL: ".mysqli_error();
        die();
    }

    $sql = "SELECT d.nombre_doc, d.app_doc, d.app FROM Docente d, materia_has_docente mhd, materia m WHERE m.nombre_mat='$materia' AND m.idMateria=mhd.Materia_idMateria AND d.idDocente=mhd.Docente_idDocente;";
    
    // recuperamos todas las materias del estudiante logueado
    $resultado = mysqli_query($conexion, $sql);     //$resultado almacena todas las filas resultantes de la consulta
    if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
        while($fila = mysqli_fetch_assoc($resultado)) {     //recorre todas las filas encontradas
            echo '<option value='.$fila['nombre_doc'].'>'.$fila['nombre_doc'].'</option>';   //Mostramos el nombre de la materia que corresponda al idMateria
        } // while
    } // if empty
    mysqli_close($conexion);
}
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