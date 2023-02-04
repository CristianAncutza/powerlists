<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$idTrack = $_GET["idTrack"];
$track = isset($_GET["texto"]) ? $_GET["texto"] : "";
$titulo = isset($_GET["titulo"]) ? $_GET["titulo"] : "";

$query = "delete from PlaylistTrack where id_track = ".$idTrack.";";

$resultado = mysql_query($query, $conn);

$query = "delete from Track where id_track = ".$idTrack.";";

$resultado = mysql_query($query, $conn);

mysql_close($conn);

unlink("mp3/".$titulo);

header("location: buscaTracks.php?texto=".$track);
?>