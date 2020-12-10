<?php
include 'conexion.php';

$idCancion = $_POST['idCancion'];
$titulo = $_POST['titulo'];
$artista = $_POST['artista'];
$foto = $_POST['foto'];
$precio = $_POST['precio'];

$consulta= "UPDATE cancion set titulo= '".$titulo."', artista= '".$artista."', foto= '".$foto."', precio= '".$precio."' where id= '".$idCancion."' ";
$resultado= $conexion -> query($consulta);


echo json_encode("OK");


?>