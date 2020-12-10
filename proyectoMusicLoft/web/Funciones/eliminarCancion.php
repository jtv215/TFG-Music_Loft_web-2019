<?php
include 'conexion.php';

$id = $_POST['id'];

$sql = "DELETE FROM cancion where id= '".$id."'  ";
$canciones = $conexion->query($sql);

echo "OK";

?>