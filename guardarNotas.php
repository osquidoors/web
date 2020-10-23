<?php
// Siempre iniciamos sesion
session_start();

if(isset($_POST['idsNota'])){

    $conexion = mysqli_connect("localhost", "root", "", "mi_prueba");
    if(! $conexion ) {
        echo "Error en la conexion a MySQL: ".mysqli_error();
        die();
    }

    $idsNota = substr($_POST['idsNota'], 0, -1);
    $idsNota = explode( '.', $idsNota );

    foreach ($idsNota as $idNota) {
        $nota1 = $_POST["$idNota-nota1"];
        $nota2 = $_POST["$idNota-nota2"];
        $nota3 = $_POST["$idNota-nota3"];
        $sql = "UPDATE notas SET nota1='$nota1', nota2='$nota2', nota3='$nota3' WHERE idNotas='$idNota';";
        $conexion->query($sql);
    }
    mysqli_close($conexion);
}
echo json_encode('ok');    //json_encode es una función de PHP que convierte el arreglo $docentes en comprensible a javascript
?>