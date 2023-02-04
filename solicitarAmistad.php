<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : "";

$query = "select id_usuario from Usuario where nombre_usuario = '".$usuario."';";

$resultado = mysql_query($query, $conn);

$tabla = mysql_fetch_array($resultado);

date_default_timezone_set('America/Argentina/Buenos_Aires');
$horaActual = date("Y-m-d H:i:s"); 

$query = "insert into Solicitud values (".$tabla[0].",".$_SESSION["idUsuarioLogueado"].",1,'".$horaActual."');";

$resultado = mysql_query($query, $conn);

mysql_close($conn);

header("location:perfilUsuario.php?usuario=".$usuario);
?>