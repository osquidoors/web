<?php

// siempre iniciamos 
session_start();

$inputUsu = $_GET['usuario'];
$inputCla = $_GET['clave'];

$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");

if(! $conexion ) {
    echo "Error en la conexion a MySQL: ".mysqli_error();
    die();
}

$sql = "SELECT * FROM usuario WHERE nombre_usr='$inputUsu' AND password='$inputCla';";
$resultado = mysqli_query($conexion, $sql);
if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
    // existe un registro con ese usuario y clave
    $contador = 0;
    $fila = null;
    while($filas = mysqli_fetch_assoc($resultado)) {
        $contador++;
        $fila = $filas;
        // echo "id: " . $filas["id"]. " - Name: " . $filas["firstname"]. " " . $filas["lastname"]. "<br>";
    }

    if( $contador == 1 ) {
        // solo hay un usuario con esos datos
        $_SESSION['user_id'] = $fila['idUsuario'];
        $tipo = "";
        $destino = "";
        if( is_null( $fila['Docente_idDocente'] ) ) {
            $_SESSION['user_tipo'] = 'Estudiante';
            $_SESSION['user_nombre'] = $fila['nombre_usr'];
            header('Location: ./inicioEstudiante.php');
        }
        
        if( is_null( $fila['Estudiante_rude'] ) ) {
            $_SESSION['user_tipo'] = 'Docente';
            $_SESSION['user_nombre'] = $fila['nombre_usr'];
            header('Location: ./inicioDocente.php');
        }
    } else {
        // dos usuarios con esos datos ???
        echo "error por duplicidad de datos";
        die();
    }
} else {
    header('Location: ./login.php');
}
mysqli_close($conexion);
?>
