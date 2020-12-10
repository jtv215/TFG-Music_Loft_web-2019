<?PHP

include 'conexion.php';
       

    $email =$_POST['email'];
    $pass =$_POST['pass'];
    
    
    $sql= "SELECT * FROM establecimiento WHERE correo='".$email."' ";
    $resul = $conexion -> query($sql);    
    $info = $resul -> fetch_array();
  
    if(empty($info[0])){
        
        echo json_encode("noExiste");
    }else{
        echo json_encode($info);
    } 
    
?>