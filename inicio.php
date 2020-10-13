<?php
// Siempre iniciamos sesion
session_start();

if ( isset( $_SESSION['user_id'] ) ) {
    // estamos logeados correctamente. Podemos mostrar contenido, caso contrario nos vamos a login.php
?>
<html>
<body>
<?php echo "Bienvenido: ".$_SESSION['user_tipo']." - ".$_SESSION['user_nombre'];?>

<?php 
$conexion = mysqli_connect("localhost", "root", "", "mi_prueba");

if(! $conexion ) {
    echo "Error en la conexion a MySQL: ".mysqli_error();
    die();
}

$sql = "SELECT * FROM materia_has_estudiante WHERE Estudiante_rude='".$_SESSION['user_id']."'";
echo $sql; die();
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
            $_SESSION['user_nombre'] = $fila['nombre_est'].' '.$fila['app_est'].' '.$fila['apm_est'];
            header('Location: ./inicioEstudiante.php');
        }
        
        if( is_null( $fila['Estudiante_rude'] ) ) {
            $_SESSION['user_tipo'] = 'Docente';
            $_SESSION['user_nombre'] = $fila['nombre_doc'].' '.$fila['app_doc'].' '.$fila['app'];
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

Materia: 
<select name="materia">
   <option value="0">Please Select Option</option>
   <option value="PHP">PHP</option>
   <option value="ASP">ASP</option>
</select>

<?php 
  }
?>

</body>
</html>
<?php
} else {
    // Redirigimos a login
    header("Location: ./login.php");
}
?>