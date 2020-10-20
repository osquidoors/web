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
<br/>

Docente: 
<select id="docentes">     <!--  select es un combobox-->
<!-- id es un identificador que utilizaremos para aumnetar contenido al combobox. -->
    <option value="0">Seleccionar docente</option>      <!--  la 1ra opción "Selec..."-->
</selected>
</body>

<!-- jquery es una libreria de javascript -->
<script src="./jquery-3.5.1.min.js"></script>   <!-- jquery es una librería que facilita el uso de funciones de jscript-->
<script type="text/javascript">     //inicio de javascript
$(function(){
    // evento que es llamado cuando cambiamos el combobox materia
    $("#materia").change(function(){  // usamos # porque estamos llamando al id en la linea 15 usamos id="materia" 
        // obtenemos el actual valor seleccionado del combobox (idMateria)
        var materiaSeleccionada = $(this).val();      //en la variable materiaId almacenamos el IdMateria ($(this).val() función de jquery que obtiene el valor de lo seleccionado)
        
        $.ajax({ // hacemos una llamada ajax, una llamada asyncrona (comunicación con el servidor en 2do plano) o ejecutando un proceso de fondo y actualizando valores en tiempo real
            // hacemos una llamada ajax al archivos obtener docente, enviando la variable materia como una variable GET
            url: "obtenerDocente.php?idmateria=" + materiaSeleccionada,
        }).done(function(respuesta) {       //"respuesta" obtiene o almacena el resultado que envía "obtenerDocente.php" que es un texto
            
            $("#docentes option").remove(); // limpiamos el dropdown
            // nuestra llamada es terminada, tenemos los datos retornados
            var docentes = JSON.parse(respuesta);      //JSON hace un parceo de "respuesta" que es un texto a arreglo en javascript
            // hacemos un ciclo similar while a través de los datos retornados
            $.each(docentes, function(codDocente, nom_docente) {       //each = while (mientras haya docentes) --> (idDocente, nombre_doc)
                // a cada opción del combobox le damos value=codDocente y como texto=nom_docente
                $('#docentes').append($('<option>', {value:codDocente, text:nom_docente}));
            });

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