<?php
include 'conexion.php';

$idCancion = $_POST['idCancion'];
$precioTotal=0;
$escuchado=1;

$sql = "UPDATE cancion SET precioTotal = $precioTotal, escuchado = $escuchado WHERE id = '".$idCancion."' ";
$cancionModificada = $conexion->query($sql);

?>