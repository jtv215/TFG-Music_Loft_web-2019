<?php
/*Cuando se esta en local*/

define('hostname','localhost');
define('username','root');
define('password','');
define('database','bd_musicLoft');

/*Cuando se este usando servidor Cloud descomentar*/
/*
define('hostname','db');
define('username','root');
define('password','1234');
define('database','bd_musicLoft');
*/
global $conexion;
$conexion = new mysqli(hostname,username,password,database,3306);
if ($conexion->connect_error)
{
	
  die("Connection failed: " . $conexion->connect_error);
}
?>