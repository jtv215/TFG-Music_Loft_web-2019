<?php
include 'conexion.php';

$idLocal = $_POST['idLocal'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$informacion = $_POST['informacion'];

$consulta= "UPDATE establecimiento set nombre= '".$nombre."', contrasena= '".$password."', informacion= '".$informacion."' where id= '".$idLocal."' ";
$resultado= $conexion -> query($consulta);


echo json_encode("OK");


?>