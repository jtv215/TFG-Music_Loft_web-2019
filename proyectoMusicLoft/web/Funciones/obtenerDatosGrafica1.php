<?php
include 'conexion.php';

$idLocal = $_POST['idLocal'];

$consulta= "SELECT * from cancion where idLocal= '".$idLocal."' ORDER BY  cast(contador as unsigned) DESC LIMIT 5";
$resultado= $conexion -> query($consulta);

while($fila=$resultado -> fetch_array()){
	$producto[] = array_map('utf8_encode',$fila);
	
}

echo json_encode($producto);
$resultado -> close();

?>