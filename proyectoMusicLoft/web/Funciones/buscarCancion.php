<?php
include 'conexion.php';

$texto = $_POST['texto'];

echo $texto;

$sql = "select * from cancion where  titulo like '".$texto."%'  OR artista LIKE '".$texto."%' ";
$canciones = $conexion->query($sql);

if(!empty($texto)){


    $sql2 = "select * from cancion where titulo like '".$texto."%'  OR artista LIKE '".$texto."%' ";
    $canciones2 = $conexion->query($sql2);
    while($fila=$canciones2 -> FETCH_ASSOC()){
        $producto[] = array_map('utf8_encode',$fila);
    
    }
    
    echo json_encode($producto);

}


*/
?>