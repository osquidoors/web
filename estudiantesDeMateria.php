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
<form id='formularioNotas'>
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

$materia = $_GET['materia'];
$sql = "SELECT n.*, e.nombre_est, e.app_est, e.apm_est FROM notas n, estudiante e WHERE n.Materia_idMateria=$materia AND n.Estudiante_rude=e.rude;";
$resultado = mysqli_query($conexion, $sql);
$cont = 0;
if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
    $idsNota = '';
    while($fila = mysqli_fetch_assoc($resultado)) {
        $promedio = ( $fila['nota1'] + $fila['nota2'] + $fila['nota3'] )/ 3;
        $cont++;
        $idNota = $fila['idNotas'];
        $rude = $fila['Estudiante_rude'];
        $idsNota .= $idNota.'.';
        echo "<tr>";
        echo "    <td>$cont</td>";
        echo "    <td>".$fila["nombre_est"]." ".$fila["app_est"]." ".$fila["apm_est"]."</td>";
        echo "    <td><input type='text' id='$idNota-nota1' name='$idNota-nota1' value=".$fila["nota1"]."></td>";
        echo "    <td><input type='text' id='$idNota-nota2' name='$idNota-nota2' value=".$fila["nota2"]."></td>";
        echo "    <td><input type='text' id='$idNota-nota3' name='$idNota-nota3' value=".$fila["nota3"]."></td>";
        echo "    <td>$promedio</td>";
        echo "</tr>";
    } // while
    echo "<input type='hidden' name='idsNota' value='$idsNota'>";
} // if empty
mysqli_close($conexion);
?>
</table>
<input type="button" id="guardar" value="Guardar notas"/>
</form>
<!-- jquery es una libreria de javascript -->
<script src="./jquery-3.5.1.min.js"></script>   <!-- jquery es una librería que facilita el uso de funciones de jscript-->
<script type="text/javascript">     //inicio de javascript
$(function(){
    $("#guardar").click(function(){
        var formularioNotas = $("#formularioNotas").serializeArray();
        $.ajax ({
            type: 'post',
            url: 'guardarNotas.php',
            dataType : 'json',
            data: formularioNotas,
            success: function(resultado) {
                alert("se guardaron las notas");
                /* 
            type: 'post',
            url: 'guardarNotas.php',
            dataType : 'json',
            data: pasos,
            responseType: "json", */
            }
        });
        return false;

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