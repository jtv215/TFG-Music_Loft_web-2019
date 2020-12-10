<?php
include 'conexion.php';

$idCancion = $_POST['idCancion'];

$consulta= "SELECT * from cancion where id= '".$idCancion."' ";
$resultado= $conexion -> query($consulta);

while($fila=$resultado -> FETCH_ASSOC()){
	$producto[] = array_map('utf8_encode',$fila);
	
}

echo json_encode($producto);
$resultado -> close();

?>