<?php
include 'conexion.php';

//$idLocal = 1;

$idLocal = $_POST['idLocal'];

$consulta= "SELECT * from cancion where idLocal= '".$idLocal."' ORDER BY  cast(precioTotal as unsigned) DESC LIMIT 1";
$resultado= $conexion -> query($consulta);

$idCancion='';
$contador= '';
while($fila=$resultado -> fetch_array()){
	$producto[] = array_map('utf8_encode',$fila);
	$idCancion = $fila['id'];
	$contador= $fila['contador'];
}


//incrementar contador en cancion
$contador++;

$sql = "UPDATE cancion SET contador = '".$contador."' where id= '".$idCancion."'  ";
$cancion = $conexion->query($sql);

echo json_encode($producto);
$resultado -> close();

?>