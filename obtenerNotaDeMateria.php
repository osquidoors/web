<?php
// siempre iniciamos 
session_start();
$notas = '';
if(isset($_GET['idmateria'])){
    $_idmateria = $_GET['idmateria'];
    $_rude = $_SESSION['rude'];
    $conexion = mysqli_connect("localhost", "root", "", "mi_prueba");
    if(! $conexion ) {
        echo "Error en la conexion a MySQL: ".mysqli_error();
        die();
    }

    $sql = "SELECT * FROM notas WHERE Materia_idMateria=$_idmateria AND Estudiante_rude=$_rude;";

    $resultado = mysqli_query($conexion, $sql);
    if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
        while($fila = mysqli_fetch_assoc($resultado)) {
            $notas = 'Nota 1er='.$fila['nota1'].' - Nota 2do='.$fila['nota2'].' - Nota 3er='.$fila['nota3'];
        } // while
    } // if empty
    mysqli_close($conexion);
}
echo $notas;
?>