<?php
include 'conexion.php';

$idLocal = $_POST['idLocal'];

$sql = "select * from cancion where idLocal= '".$idLocal."' ";
$canciones = $conexion->query($sql);

while($fila=$canciones -> FETCH_ASSOC()){
	$producto[] = array_map('utf8_encode',$fila);

}

echo json_encode($producto);

?>