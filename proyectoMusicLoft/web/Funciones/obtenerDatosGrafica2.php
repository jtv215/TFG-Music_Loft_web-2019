<?php
include 'conexion.php';

$idLocal = $_POST['idLocal'];

$consulta= "SELECT * from establecimiento where id= '".$idLocal."' ";
$resultado= $conexion -> query($consulta);

while($fila=$resultado -> fetch_array()){
	$producto[] = array_map('utf8_encode',$fila);
	
}

echo json_encode($producto);
$resultado -> close();

?>