<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$voto = $_POST["voto"];
$idPlaylist = $_GET["idPlaylist"];
$cod = $_GET["cod"];

if ($cod == 1)
    $query = "insert into Voto values(".$idPlaylist.", ".$_SESSION["idUsuarioLogueado"].", ".$voto.");";
else
    $query = "update Voto set voto = ".$voto." where id_playlist = ".$idPlaylist." and id_usuario = ".$_SESSION["idUsuarioLogueado"].";";

$resultado = mysql_query($query, $conn);

mysql_close($conn);

header("location:home.php");
?>