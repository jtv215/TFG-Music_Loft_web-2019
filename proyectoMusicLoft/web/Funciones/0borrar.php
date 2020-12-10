<?PHP

include 'conexion.php';
   
   $nombre='prueba';
   $correo='prueba@prueba';
   $contrasena=123;
   $sexo='hombre';
   
   
	$sql= "select * FROM usuario where correo ='".$correo."'";
	$resultado = $conexion -> query($sql); 
	$info = $resultado -> fetch_array();
	echo json_encode($info);
	
	if(empty($info)){

	$sql = "Insert into usuario (nombre, correo, contrasena, sexo) 
        values ('".$nombre."', '".$correo."', '".$contrasena."','".$sexo."')";
	$result = $conexion->query($sql);

    echo json_encode("OK");
	}else{
    echo json_encode("REPETIDO");
	}
	
	

  
    
?>