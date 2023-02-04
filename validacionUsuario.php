<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

$query = "select clave, id_usuario, rol from usuario where nombre_usuario = '".$usuario."';";
$resultado = mysql_query($query, $conn);

$usuario_valido = mysql_num_rows($resultado);

if ($usuario_valido > 0){
	$tabla = mysql_fetch_array($resultado);
    if ($password != $tabla[0])
        $usuario_valido = 0;
}

if($usuario != "" && $password != "" && $usuario_valido > 0){
	session_start();
	$_SESSION["usuarioLogueado"] = $usuario;
    $_SESSION["idUsuarioLogueado"] = $tabla[1];
    $_SESSION["rolUsuario"] = $tabla[2];
	header("location: home.php");
    
}
else{
	header("location: signup.html");
}
mysql_close($conn);
?>