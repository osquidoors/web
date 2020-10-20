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
<form>
<table border="1">
<tr>
    <th>N&deg;</th>
    <th>Estudiante</th>
    <th>N1</th>
    <th>N2</th>
    <th>N3</th>
    <th>N4</th>
    <th>Promedio</th>
</tr>
</table>
</form>
</html>
<?php
} else {
    // Redirigimos a login
    header("Location: ./login.php");
}
?>