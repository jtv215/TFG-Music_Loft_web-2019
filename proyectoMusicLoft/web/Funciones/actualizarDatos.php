<?php
include 'conexion.php';

$id = $_POST['id'];
$texto = $_POST['texto'];
$nombreColumna = $_POST['nombreColumna'];

$sql = "UPDATE cancion SET $nombreColumna  = '".$texto."'  where id= '".$id."'  ";
$canciones = $conexion->query($sql);

echo "OK";

?>