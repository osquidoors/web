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
<select id="curso">     <!--  select es un combobox id es el identificador del combobox-->
    <option value="0">Seleccionar curso</option>      <!--  la 1ra opción "Selec..."-->
<?php 
$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");

if(! $conexion ) {
    echo "Error en la conexion a MySQL: ".mysqli_error();
    die();
}

$sql = "SELECT c.* FROM docente_has_curso dhc, curso c WHERE dhc.Docente_idDocente=".$_SESSION['docente']." AND dhc.Curso_idCurso=c.idCurso;";
// recuperamos las cursos del docente logueado
$resultado = mysqli_query($conexion, $sql);     //$resultado almacena todas las filas resultantes de la consulta
if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
    while($fila = mysqli_fetch_assoc($resultado)) {     //recorre todas las filas encontradas
        echo '<option value="'.$fila['idCurso'].'">'.$fila['nombre_curso'].'</option>';   //Mostramos el nombre de la materia que corresponda al idMateria
    } // while
} // if empty
mysqli_close($conexion);
?>
</select>
</form>

<!-- jquery es una libreria de javascript -->
<script src="./jquery-3.5.1.min.js"></script>   <!-- jquery es una librería que facilita el uso de funciones de jscript-->
<script type="text/javascript">     //inicio de javascript
$(function(){
    // evento que es llamado cuando cambiamos el combobox materia
    $("#curso").change(function(){  // usamos # porque estamos llamando al id en la linea 15 usamos id="materia" 
        // obtenemos el actual valor seleccionado del combobox (idMateria)
        var cursoSeleccionado = $(this).val();      //en la variable cursoSeleccionado almacenamos el IdCurso ($(this).val() función de jquery que obtiene el valor de lo seleccionado)
        location.href = './estudiantesDeCurso.php?curso='+cursoSeleccionado;
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