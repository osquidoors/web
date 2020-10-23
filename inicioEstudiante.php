<?php
// Siempre iniciamos sesion
session_start();

if ( isset( $_SESSION['user_id'] ) ) {      //isset función que verifica la existencia de una variable user_id en $_SESSION (si existe un usuario logueado)
    // estamos logueados correctamente. Podemos mostrar contenido, caso contrario nos vamos a login.php
?>
<html>
<body>
<?php echo "Bienvenido: ".$_SESSION['user_tipo']." - ".$_SESSION['user_nombre'].' ++ '.$_SESSION['rude']; ?>
<br/>
<hr/>
<a href="">Generar boleta</a>
<br/>
<br/>
Consulta nota de una materia:
<br/><br/>
<form>
Materia: 
<select id="materia">     <!--  select es un combobox id es el identificador del combobox-->
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
        echo '<option value="'.$fila['idMateria'].'">'.$fila['nombre_mat'].'</option>';   //Mostramos el nombre de la materia que corresponda al idMateria
    } // while
} // if empty
mysqli_close($conexion);
?>
</select>
</form>
</body>

<!-- jquery es una libreria de javascript -->
<script src="./jquery-3.5.1.min.js"></script>   <!-- jquery es una librería que facilita el uso de funciones de jscript-->
<script type="text/javascript">     //inicio de javascript
$(function(){
    $("#materia").change(function(){
        var materiaSeleccionada = $(this).val();
        $.ajax({
            url: "obtenerNotaDeMateria.php?idmateria="+materiaSeleccionada,
        }).done(function(respuesta) {
            alert(respuesta)
        });
    });
});
</script>   <!-- fin de javascript -->


</html>
<?php
} else {
    // Redirigimos a login
    header("Location: ./login.php");
}
?>