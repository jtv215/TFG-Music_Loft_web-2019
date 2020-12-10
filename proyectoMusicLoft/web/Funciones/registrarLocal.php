<?PHP

include 'conexion.php';
 
$nombre =$_POST['nombre'];
$correo =$_POST['correo'];
$password =$_POST['password'];
$generosMusicales =$_POST['generosMusicales'];


//valores por defecto
$hombres=0;
$mujeres=0;

$sql= "SELECT * FROM establecimiento WHERE correo='".$correo."' ";
$resul = $conexion -> query($sql);    
$info = $resul -> FETCH_ASSOC();

if(empty($info['correo'])){

$sql2 = "INSERT INTO establecimiento (nombre, contrasena, correo, informacion, hombres, mujeres) 
        values ('" .$nombre. "', '".$password. "', '".$correo. "','".$generosMusicales. "', '".$hombres. "', '".$mujeres. "')";
$result2 = $conexion->query($sql2);

    echo json_encode("OK");
}else{
    echo json_encode("REPETIDO");

}
  
    
?>