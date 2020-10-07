<?php

// siempre iniciamos 
session_start();

$inputUsu = $_GET['usuario'];
$inputCla = $_GET['clave'];

$conexion = new mysqli("localhost", "root", "", "mi_prueba");

if ($conexion->connect_errno) {
    echo "Error en la conexion a MySQL: ".$conexion->connect_error;
    exit();
}

$sql = "SELECT * FROM usuario WHERE usuario='$inputUsu' AND clave='$inputCla';";
$resultados = $conexion->query( $sql );
if ($resultados->num_rows > 0) {
    // existe un registro con ese usuario y clave
    $contador = 0;
    $fila = null;
    while($filas = $result->fetch_assoc()) {
        $contador++;
        $fila = $filas;
        // echo "id: " . $filas["id"]. " - Name: " . $filas["firstname"]. " " . $filas["lastname"]. "<br>";
    }

    if( $contador == 1 ) {
        // solo hay un usuario con esos datos
        $_SESSION['user_id'] = $fila['id'];
        // redireccionamos a:
        header('Location: ./inicio.php');
    } else {
        // dos usuarios con esos datos ???
        echo "error por duplicidad de datos";
        die();
    }

    // limpiamos los resultados
    $resultados -> free_result();

}

$resultados->close();
$conexion->close();
?>
