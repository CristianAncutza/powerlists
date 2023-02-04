<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
$apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";

$query = "update Usuario set nombre_usuario = '".$usuario."', nombre = '".$nombre."', apellido = '".$apellido."', email = '".$email."' where id_usuario = ".$_SESSION["idUsuarioLogueado"].";";

$resultado = mysql_query($query, $conn);

$_SESSION["usuarioLogueado"] = $usuario;

mysql_close($conn);

header("location: miPerfil.php");
?>