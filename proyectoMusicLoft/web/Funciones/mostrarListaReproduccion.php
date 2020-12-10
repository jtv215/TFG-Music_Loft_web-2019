<?php
include 'conexion.php';

$idLocal = $_POST['idLocal'];
$sql= "SELECT * from cancion where idLocal= '".$idLocal."' ORDER BY  cast(precioTotal as unsigned) DESC";
$canciones = $conexion->query($sql);



echo "
<table>
<tr>    
    <th>Titulo</th>
    <th>Artista</th>   
    <th>Puntos</th>
   
</tr>
";

while($fila=$canciones -> fetch_array()){
    echo "
    <tr>        
        <td id='titulo' data-id_cancion='".$fila["id"]."'>   ".$fila["titulo"]."</td>
        <td id='artista' data-id_cancion='".$fila["id"]."'>  ".$fila["artista"]."</td>        
        <td id='precio' data-id_cancion='".$fila["id"]."'>   ".$fila["precioTotal"]."</td>       
     </tr>";
    }
    echo "</table> </div>";


	


?>