<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim();
//localhost
//$db = new mysqli('127.0.0.1:3306', 'root', 'root', 'bd_musicLoft');

//$db = new mysqli('localhost', 'root', '', 'bd_musicLoft');

/*si usa servidor Cloud*/
//$db = new mysqli('db', 'root', '1234', 'bd_musicLoft');



$app->get(
	'/prueba',
	function () {
		$result='hola22';
		echo "hola";
	}
);
$app->get(
	'/cancion',
	function () use ($app, $db){
		$result[]= getCancion(1,$db);
		echoResponse(200, $result);
		
	}
);
//****************Login*************************// 

$app->post(
	'/login',
	function () use ($app, $db) {

		//desencripta el fichero que esta en formato JSON
		$json = $app->request->getBody();
		$data = json_decode($json, true);

		$correo = $data['correo'];
		$contrasena = $data['contrasena'];

		//Obtener datos del usuario
		$sql = "SELECT * FROM usuario WHERE correo = '" . $correo . "' && contrasena = '" . $contrasena . "' ";
		$resultado = $db->query($sql);
		$info = $resultado->FETCH_ASSOC();

		if (empty($info)) {

			$result = array(
				'status' => 'error',
				'code' => 404,
				'message' => 'Email o password incorrecto'
			);

			echoResponse(404, $result);
		} else {
			$idUsuario = $info['id'];
			$token = generarToken($idUsuario, $db);
			header("auth-token:" . $token);

			$result = array(
				"status" => 'success',
				'code' => 200,
				"id" => $info['id'],
				"nombre" => $info['nombre'],
				"correo" => $info['correo'],
				"contrasena" => $info['contrasena'],
				"sexo" => $info['sexo']
			);
			echoResponse(200, $result);
		}
	}
);


//****************Login empleado*************************// 
$app->post(
	'/loginEmpleado',
	function () use ($app, $db) {

		//desencripta el fichero que esta en formato JSON
		$json = $app->request->getBody();
		$data = json_decode($json, true);

		$correo = $data['correo'];
		$contrasena = $data['contrasena'];

		//Obtener datos del usuario
		$sql = "SELECT * FROM empleado WHERE correo = '" . $correo . "' && contrasena = '" . $contrasena . "' ";
		$resultado = $db->query($sql);
		$info = $resultado->FETCH_ASSOC();

		if (empty($info)) {

			$result = array(
				'status' => 'error',
				'code' => 404,
				'message' => 'Email o password incorrecto'
			);

			echoResponse(404, $result);
		} else {
			$idUsuario = $info['id'];
			$token = generarTokenEmpleado($idUsuario, $db);
			header("auth-token:" . $token);

			$result = array(
				"status" => 'success',
				'code' => 200,
				"id" => $info['id'],
				"idLocal" => $info['idLocal'],
				"nombre" => $info['nombre'],
				"correo" => $info['correo'],
				"contrasena" => $info['contrasena'],
				"sexo" => $info['sexo']
			);
			echoResponse(200, $result);
		}
	}
);
//****************Registrarse*************************// 
$app->post('/registrarse', function () use ($app, $db) {

	$json = $app->request->getBody();
	$data = json_decode($json, true);

	$nombre = $data['nombre'];
	$correo = $data['correo'];
	$contrasena = $data['contrasena'];
	$sexo = $data['sexo'];

	$info = buscarUsuario($correo, $db);

	if (empty($info)) {

		insertarUsuario($nombre, $correo, $contrasena, $sexo, $db);
		$info = buscarUsuario($correo, $db);

		$result = array(
			'status' => 'success',
			'code' => 200,
			"id" => $info['id'],
			"nombre" => $info['nombre'],
			"correo" => $info['correo'],
			"contrasena" => $info['contrasena'],
			"sexo" => $info['sexo']
		);

		echoResponse(200, $result);
	} else {
		$result = array(
			'status' => 'error',
			'code' => 404,
			'message' => 'Usuario esta repetido'
		);

		echoResponse(404, $result);
	}
});


//****************CargarCanciones*************************// 
$app->get('/cargarCanciones/:idEstablecimiento', 'authenticate', function ($idEstablecimiento) use ($app,$db) {


	$consulta = "select * from cancion where idLocal = '" . $idEstablecimiento . "' ORDER BY cast(precioTotal as unsigned) DESC  ";
	$resultado = $db->query($consulta);
	
	while ($fila = $resultado->FETCH_ASSOC()) {
		$producto[] = array_map('utf8_encode', $fila);
	}

	
	
	//mirar el token del usuario
	$headers = apache_request_headers();
	$token = $headers['Authorization']; 
	$usuario = getUsaurioPorToken($token,$db);

	crearNuevaCuentaUsuario($idEstablecimiento,$usuario,$db);

	echoResponse(200,$producto);
	$resultado->close();
});

//****************Cargar Lista CodigoQR*************************// 
$app->get('/cargarlistaCodigoQR/:idEstablecimiento', 'authenticate', function ($idEstablecimiento) use ($app,$db) {


	$consulta = "select * from codigoqr where idLocal = '" . $idEstablecimiento . "' ORDER BY cast(precio as unsigned) ASC  ";
	$resultado = $db->query($consulta);
	
	while ($fila = $resultado->FETCH_ASSOC()) {
		$producto[] = array_map('utf8_encode', $fila);
	}

	echoResponse(200,$producto);
	$resultado->close();
});

//****************Cargar Establecimientos*************************// 
$app->get('/cargarEstablecimientos', 'authenticate', function () use ($db) {

	$consulta = "select * from establecimiento";
	$resultado = $db->query($consulta);

	while ($fila = $resultado->FETCH_ASSOC()) {
		
		$Establecimientos[] = array_map('utf8_encode', $fila);
		
	}
	echoResponse(200,$Establecimientos);

	$resultado->close();
});


//****************get Monedas Usuario*************************// 
$app->get('/getPuntosUsuario/:idEstablecimiento', 'authenticate', function ($idEstablecimiento) use ($app, $db) {

	$json = $app->request->getBody();
	$data = json_decode($json, true);

	$headers = apache_request_headers();
	$token = $headers['Authorization']; 
	$usuario = getUsaurioPorToken($token,$db);	
	$monedas = getMonedas($usuario['id'],$idEstablecimiento,$db);

	if($monedas==null){
		$result = array(
			'status' => 'error',
			'code' => 404,
			'message' => 'El usuario no tiene cuenta en el local'	
		);
		echoResponse(404,$result);


	}else{
		$result = array(
			'status' => 'success',
			'code' => 200,		
			"monedas" => $monedas['monedasVirtuales']		
		);
		echoResponse(200,$result);
	}

});


//****************Votar Canción*************************// 
$app->get('/votarCancion/:idEstablecimiento/:idCancion', 'authenticate', function ($idEstablecimiento,$idCancion) use ($app, $db) {
/*
	$json = $app->request->getBody();
	$data = json_decode($json, true);
*/
	//$idEstablecimiento = $data['idEstablecimiento'];
	//$idCancion = $data['idCancion'];


	$headers = apache_request_headers();
	$token = $headers['Authorization']; 
	$usuario = getUsaurioPorToken($token,$db);	
	$monedas = getMonedas($usuario['id'],$idEstablecimiento,$db);
	$cancion = getCancion($idCancion,$db);	

	
	if($cancion['precio']<=$monedas['monedasVirtuales']){

		$sumaprecioTotal = $cancion['precio'] + $cancion['precioTotal'];
		$sumacantidadSeleccionada = $cancion['cantidadSeleccionada'] + 1;

		$consulta = "UPDATE cancion SET precioTotal =" . $sumaprecioTotal .
		 ", cantidadSeleccionada =" . $sumacantidadSeleccionada .
		 " where id =" . $idCancion;

		$resultado = $db->query($consulta);

		$cancion=getCancion($idCancion,$db);

		//sumar contador, canciones más votadas
		$idCancion= $cancion['id'];
		$sumaContador= $cancion['contador']+1;
		$consulta3 = "UPDATE cancion SET contador =" . $sumaContador . " where id =" . $idCancion;
		$resultado = $db->query($consulta3);

		//sumar contador hombres y mujeres que usan más la aplicación

		$sexo= $usuario['sexo'];
		$idEstablecimiento = $cancion['idLocal'];

		$Establecimiento = getEstablecimientos($cancion, $db);
		

		if($sexo=='hombre'){
			$contadorhombres= $Establecimiento['hombres']+1;
			$consulta4 = "UPDATE establecimiento SET hombres =" . $contadorhombres . " where id =" . $idEstablecimiento;
			$resultado = $db->query($consulta4);

		}else if($sexo == 'mujer'){
			$contadormujeres= $Establecimiento['mujeres']+1;
			$consulta5 = "UPDATE establecimiento SET mujeres =" . $contadormujeres . " where id =" . $idEstablecimiento;
			$resultado = $db->query($consulta5);


		}




		
		$monedas = getRestarMonedasUsuario($monedas,$cancion,$db);

		echoResponse(200,$cancion);
		
	}else{

		echoResponse(400,$cancion);
		
	}


});

//****************Add puntos*************************// 
$app->get('/addPuntos/:idEstablecimiento/:codigoQr', 'authenticate', function ($idEstablecimiento,$codigoQr) use ($app, $db) {

	$headers = apache_request_headers();
	$token = $headers['Authorization'];	
	$validar = comprobarCodigoQR($codigoQr,$db);
	//????
	//no hace falta pasarle el idEstablecimiento
	//hay que coger el iddelEstablecimiento del mismo codigo QR

	if($validar==true){

		$usuario = getUsaurioPorToken($token,$db);
		$infoCodigo = getcodigoQr($codigoQr,$db);
		//$getUsuLocal =  getUsuLocal($usuario, $idEstablecimiento, $db);
		$addpuntos = addPuntosUsuario($usuario,$infoCodigo,$idEstablecimiento
		,$db);

		$getUsuLocalUpdate =  getUsuLocal($usuario, $idEstablecimiento, $db);

		$result = array(
			'status' => 'success',
			'code' => 200,			
			'monedas' => $getUsuLocalUpdate['monedasVirtuales']
		);

		$eliminarCodigo = eliminarCodigo($infoCodigo,$db);


		echoResponse(200,$result);
	}else{

		$result = array(
			'status' => 'error',
			'code' => 404,
			'message' => 'El código no existe'	
		);
		echoResponse(404,$result);
	}
});


//****************Actualizar Código QR*************************// 
$app->get('/actualizarCodigoQR/:idCodigoQR/:codigoQr', 'authenticate', function ($idCodigoQR,$codigoQr) use ($app, $db) {


	$headers = apache_request_headers();
	//$token = $headers['Authorization'];	
	
	

	
		$consult = "UPDATE codigoqr SET codQR = '" . $codigoQr . "' where id = '" . $idCodigoQR . "' ";
		$result = $db->query($consult);

		$infoCodigo = getCodigo($idCodigoQR,$db);

		echoResponse(200,$infoCodigo);
		


});


$app->run();





function getEstablecimientos($cancion,$db){


	$idEstablecimiento= $cancion['idLocal'];
	
	$sql = "select * FROM establecimiento where id = '" . $idEstablecimiento . "' ";
	$resultado = $db->query($sql);	
	$info = $resultado->FETCH_ASSOC();
	return $info;

}


/*********************** USEFULL FUNCTIONS **************************************/

function insertarUsuLocal($idEstablecimiento,$usuario ,$db)
{	
	$monedas=0;
	$sql = "Insert into usulocal (idLocal, idUsuario,monedasVirtuales) 
        values ('" . $idEstablecimiento . "', '" . $usuario . "', '" . $monedas . "')";
	$resultado = $db->query($sql);
}

function crearNuevaCuentaUsuario($idEstablecimiento,$usuario,$db)
{
	$idusuario= $usuario['id'];
	
	$sql = "select * FROM usulocal where idLocal = '" . $idEstablecimiento . "' && idUsuario= '" . $idusuario . "'";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();

	if(empty($info)){
		insertarUsuLocal($idEstablecimiento,$idusuario ,$db);
	}

	return $info;
}


function generarToken($idUsuario, $db)
{
	$token = bin2hex(random_bytes(64));

	//*Comprobar que el token no este usado y si esta usado generar otro token*/

	$consult = "UPDATE usuario SET token = '" . $token . "' where id = '" . $idUsuario . "' ";
	$result = $db->query($consult);
	return $token;
}

function generarTokenEmpleado($idUsuario, $db)
{
	$token = bin2hex(random_bytes(64));

	//*Comprobar que el token no este usado y si esta usado generar otro token*/

	$consult = "UPDATE empleado SET token = '" . $token . "' where id = '" . $idUsuario . "' ";
	$result = $db->query($consult);
	return $token;
}

function buscarUsuario($correo, $db)
{
	$sql = "select * FROM usuario where correo = '" . $correo . "' ";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();
	return $info;
}

function getUsaurioPorToken($token, $db)
{
	$sql = "select * FROM usuario where token = '" . $token . "' ";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();
	return $info;
}
function getRestarMonedasUsuario($monedas,$cancion,$db)
{	
	$result = $monedas['monedasVirtuales']-$cancion['precio'];
	$idMonedas = $monedas['id'];

	$consulta = "UPDATE usulocal SET monedasVirtuales = '". $result ."' where id = '" .$idMonedas."' ";
	$resultado = $db->query($consulta);
	

	$sql = "select * FROM usulocal where id ='" . $idMonedas. "' ";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();

	return $info;
}

function getCancion($idCancion, $db)
{
	$sql = "select * FROM cancion where id ='" . $idCancion . "'";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();
	return $info;
}

function getMonedas($idUsuario, $idLocal, $db)
{
	$sql = "select * FROM usulocal where idLocal ='" . $idLocal . "' && idUsuario = '".$idUsuario."'  ";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();
	return $info;
}
function comprobarCodigoQR($codigoQR, $db)
{
	$sql = "select * FROM codigoqr where codQR ='" . $codigoQR . "'";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();

	
	if(empty($info)){
		$info = false;
	}else{
		$info = true;
	}

	return $info;
}

function addPuntosUsuario($usuario, $infoCodigo, $idEstablecimiento,$db)
{	
	$puntosUsuario = getUsuLocal($usuario,$idEstablecimiento, $db);
	$sumarPuntos = $puntosUsuario['monedasVirtuales'] + $infoCodigo['precio'];
	$consulta = "UPDATE usulocal SET monedasVirtuales =" . $sumarPuntos ." where id =" . $puntosUsuario['id'];
	$resultado = $db->query($consulta);

	return true;
}

function  eliminarCodigo($infoCodigo,$db){
	$vacio="";
	$idCodigoQR = $infoCodigo['id'];
	$consult = "UPDATE codigoqr SET codQR = '" . $vacio . "' where id = '" . $idCodigoQR . "' ";
	$resultado = $db->query($consult);

	return true;
}

function getUsuLocal($usuario, $idEstablecimiento, $db)
{
	$sql = "select * FROM usulocal where idUsuario ='" . $usuario['id'] . "' && idLocal = '" . $idEstablecimiento. "' ";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();

	return $info;
}


function getcodigoQr($codigoQR,$db)
{
	$sql = "select * FROM codigoqr where codQR ='" . $codigoQR . "'";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();
	return $info;
}

function insertarUsuario($nombre, $correo, $contrasena, $sexo, $db)
{
	$sql = "Insert into usuario (nombre, correo, contrasena, sexo) 
        values ('" . $nombre . "', '" . $correo . "', '" . $contrasena . "','" . $sexo . "')";
	$resultado = $db->query($sql);
}


function buscartoken($token)
{
	$db = new mysqli('localhost', 'root', '', 'bd_musicloft');

	$sql = "select * FROM usuario where token = '" . $token . "' ";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();

	if(empty($info)){
	$sql = "select * FROM empleado where token = '" . $token . "' ";
	$resultado = $db->query($sql);
	$info = $resultado->FETCH_ASSOC();
	}

	return $info;
}

function echoResponse($status_code, $response)
{
	$app = \Slim\Slim::getInstance();
	$app->status($status_code);
	// setting response content type to json
	$app->contentType('application/json');

	echo json_encode($response);
}



function authenticate(\Slim\Route $route)
{
	// Getting request headers
	$headers = apache_request_headers();
	$response = array();
	$app = \Slim\Slim::getInstance();

	// Verifying Authorization Header
	if (isset($headers['Authorization'])) {


		$token = $headers['Authorization']; //El token que se recibe de la cabecera	
		$tokenbd = buscartoken($token); //token de la base de datos

		if (!($token == $tokenbd['token'])) {
			$response["error"] = true;
			$response["message"] = "Acceso denegado. Token inválido";
			echoResponse(401, $response);
			$app->stop();
		} else {
			//procede utilizar el recurso o metodo del llamado
		}
	} else {
		// api key is missing in header
		$response["error"] = true;
		$response["message"] = "Falta token de autorización";
		echoResponse(400, $response);

		$app->stop();
	}

}
