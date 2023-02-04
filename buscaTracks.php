<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$track = isset($_GET["texto"]) ? $_GET["texto"] : "";

$query = "select titulo, id_track from Track where titulo like '%".$track."%';";

$resultado = mysql_query($query, $conn);

echo "<table border='1'><thead><tr><th>Titulo</th></tr></thead><tbody>";

while($tabla = mysql_fetch_array($resultado)){
	echo "<tr>";
	echo "<td>".$tabla[0]."</td>";
    echo "<td><span onclick='borrarTrack(".$tabla[1].",\"".$tabla[0]."\",\"".$track."\");'>borrar</span></td>";
	echo "</tr>";
}

echo "</tbody></table>";

mysql_close($conn);
?>