<?php
include 'conexion.php';


	/*Recoge del formulario*/
	$idLocal = $_POST['idLocal'];
	$titulo = $_POST['titulo'];
	$artista = $_POST['artista'];	
	$foto = $_POST['foto'];
	$tipo = $_POST['tipo'];
	$nombreFichero = $_POST['nombreFichero'];



	/*rellenar los atributos que faltan por defecto*/	
	$precio=5;
	$precioTotal=0;
	$cantidadSeleccionada=0;
	$escuchado=0;
	$contador=0;
	
	
	/*imprimir datos*/
	/*
	echo "titulo: ".$titulo."<br>";
	echo "artista: ".$artista."<br>";
	echo "foto: ".$foto."<br>";
	echo "precio: ".$precio."<br>";
	echo "precioTotal: ".$precioTotal."<br>";
	echo "cantidad seleccionada: ".$cantidadSeleccionada."<br>";
	echo "Escuchado: ".$escuchado."<br>";
	echo "tipo: ".$tipo."<br>";
	echo "NombreFichero: ".$nombreFichero."<br>";
	echo "audio: ".$nombreCancion."<br>";
	echo "video: ".$nombreVideo."<br>";
	*/

	$sql = "Insert into cancion (idLocal, titulo, artista, foto, precio, precioTotal,cantidadSeleccionada,escuchado,tipo,nombreFichero,contador) values 
	('$idLocal', '$titulo', '$artista','$foto', '$precio', '$precioTotal', '$cantidadSeleccionada', $escuchado, '$tipo','$nombreFichero','$contador')";
	$resultado= $conexion -> query($sql);

	echo json_encode("OK");

?>