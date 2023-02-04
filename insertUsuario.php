<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$usuario = $_POST["usuario"];
$password = $_POST["password"];
$cpassword = $_POST["cpassword"];

$query = "select max(id_usuario) from usuario;";
$resultado = mysql_query($query, $conn);
$filas = mysql_fetch_array($resultado);

$query = "select nombre_usuario from usuario where nombre_usuario = '".$usuario."';";
$resultado = mysql_query($query, $conn);

$usuarios_existentes = mysql_num_rows($resultado);

if($usuarios_existentes  > 0)
{
    mysql_close($conn);
    header("location: signup.html");
}
else{
	$_SESSION["usuarioLogueado"] = $usuario;
    $_SESSION["rolUsuario"] = "usuario";
	$id_usuario = $filas[0] + 1;
    $_SESSION["idUsuarioLogueado"] = $id_usuario;
	$insert= "insert into usuario(id_usuario,nombre_usuario, clave, rol) values	(".$id_usuario.",'".$usuario."','".$password."','usuario');";
	$resultado = mysql_query($insert, $conn);
    mysql_close($conn);	
	header("location: home.php");
}	
?>