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
<select id="materia">
<!-- id es un identificador que utilizaremos para recuperar el valor seleccionado. 
onchange es una funcion que al ver que se cambio el valor del combobox llamara a la funcion obtenerDocentes -->
    <option value="0">Seleccionar materia</option>
<?php 
$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");

if(!$conexion ) {
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

<br/>
Docente:
<select id="docentes">
<!-- id es un identificador que utilizaremos para recuperar el valor seleccionado. 
onchange es una funcion que al ver que se cambio el valor del combobox llamara a la funcion obtenerDocentes -->
    <option value="0">Seleccionar docente</option>
</selected>
</body>

<script src="./jquery-3.5.1.min.js"></script>
<script type="text/javascript">  
$(function(){
    // evento que es llamado cuando cambiamos el combobox materia
    $("#materia").change(function(){  // usamos # porque estamos llamando al id
        // obtenemos el actual valor selccionado de la materia
        var materiaId = $(this).val();
        $.ajax({
            // hacemos una llamada ajax al archivos obtener docente, enviando la mariable materia como una variable GET
            url: "obtenerDocente2.php?materia=" + materiaId,
        }).done(function(respuesta) {
            // limpiamos el dropdown
            $("#docentes option").remove();
            // nuestra llamada es terminada, tenemos los datos retornados
            data = JSON.parse(respuesta);
            // loop through our returned data and add an option to the select for each province returned
            $.each(data, function(i, item) {
                $('#docentes').append($('<option>', {value:i, text:item}));
            });

        });
    });
});
</script>
</html>
<?php
} else {
    // Redirigimos a login
    header("Location: ./login.php");
}
?>