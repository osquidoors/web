<?php

// siempre iniciamos 
session_start();

$usuario = $_GET['usuario'];
$clave = $_GET['clave'];

$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");

if(! $conexion ) {
    echo "Error en la conexion a MySQL: ".mysqli_error();
    die();
}

$sql = "SELECT * FROM usuario WHERE nombre_usr='$usuario' AND password='$clave';";
$resultado = mysqli_query($conexion, $sql);     //$resultado es un arreglo que almacena el registro
if ( !empty($resultado) && mysqli_num_rows($resultado) > 0 ) {
    // existe un registro con ese usuario y clave
    $fila = mysqli_fetch_assoc($resultado);     //recupera la fila que cumpla con los datos
        $_SESSION['user_id'] = $fila['idUsuario'];      //guardamos una variable (user_id) en la sesión que almacenará el idUsuario
        if( is_null( $fila['Docente_idDocente'] ) ) {   //si idDocente es nulo
            $_SESSION['rude'] = $fila['Estudiante_rude'];
            $_SESSION['user_tipo'] = 'Estudiante';
            $_SESSION['user_nombre'] = $fila['nombre_usr'];
            header('Location: ./inicioEstudiante.php');
        }
        
        if( is_null( $fila['Estudiante_rude'] ) ) {
            $_idDocente = $fila['Docente_idDocente'];
            $sql = "SELECT * FROM docente WHERE idDocente='$_idDocente'";
            $resultadoDocente = mysqli_query($conexion, $sql);
            $filaDocente = mysqli_fetch_assoc($resultadoDocente);
            $_SESSION['docente'] = $_idDocente;
            $_SESSION['user_tipo'] = 'Docente';
            $_SESSION['user_nombre'] = $filaDocente['nombre_doc'].' '.$filaDocente['app_doc'].' '.$filaDocente['apm_doc'];
            header('Location: ./inicioDocente.php');
        }
    

} else {
    header('Location: ./login.php');
}
mysqli_close($conexion);
?>
