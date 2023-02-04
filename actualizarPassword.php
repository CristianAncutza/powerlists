<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$passAnterior = isset($_POST["passAnterior"]) ? $_POST["passAnterior"] : "";
$passActual = isset($_POST["passActual"]) ? $_POST["passActual"] : "";
$confirmaPassActual = isset($_POST["confirmaPassActual"]) ? $_POST["confirmaPassActual"] : "";

$query = "select clave from Usuario where id_usuario = ".$_SESSION["idUsuarioLogueado"].";";

$resultado = mysql_query($query, $conn);

$tabla = mysql_fetch_array($resultado);

if ($tabla[0] != $passAnterior){
    mysql_close($conn);
    header("location: miPerfil.php?error=1");
}
else {
    $query = "update Usuario set clave = '".$passActual."' where id_usuario = ".$_SESSION["idUsuarioLogueado"].";";
    
    $resultado = mysql_query($query, $conn);
    
    mysql_close($conn);    
    header("location: miPerfil.php");
}
?>