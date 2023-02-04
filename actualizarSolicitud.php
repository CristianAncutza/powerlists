<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$estado = $_GET["respuesta"];
$usuario = $_GET["usuario"];

$query = "select id_usuario from Usuario where nombre_usuario = '".$usuario."';";

$resultado = mysql_query($query, $conn);

$tabla = mysql_fetch_array($resultado);

$query = "update Solicitud set estado = ".$estado." where id_usuario_solicitado = ".$_SESSION["idUsuarioLogueado"]." and id_usuario_solicitante = ".$tabla[0].";";

$resultado = mysql_query($query, $conn);

$query = "select max(id_notificacion) from Notificacion;";

$resultado = mysql_query($query, $conn);

$filas = mysql_fetch_array($resultado);

$estadoDesc = $estado == 0 ? "rechaz&ocute;" : "confirm&oacute;";

$query = "insert into Notificacion values (".($filas[0] + 1).", ".$tabla[0].", '".$_SESSION["usuarioLogueado"]." ".$estadoDesc." su solicitud');";

$resultado = mysql_query($query, $conn);

mysql_close($conn);

header("location:home.php");
?>