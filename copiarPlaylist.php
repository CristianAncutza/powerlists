<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$idPlaylist = $_GET["idPlaylist"];

$query = "insert into PlaylistUsuario values(".$idPlaylist.",".$_SESSION["idUsuarioLogueado"].");";

$resultado = mysql_query($query, $conn);

mysql_close($conn);

header("location:busquedaPlaylist.php");
?>