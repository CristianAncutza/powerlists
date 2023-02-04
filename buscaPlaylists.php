<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$playlist = isset($_GET["texto"]) ? $_GET["texto"] : "";

$query = "select p.id_playlist, p.nombre, g.nombre, p.categoria, p.tipo from Playlist p inner join Genero g on g.id_genero = p.id_genero where p.nombre like '%".$playlist."%';";

$resultado = mysql_query($query, $conn);

echo "<table border='1'><thead><tr><th>Titulo</th><th>Genero</th><th>Categoria</th><th>Tipo</th></tr></thead><tbody>";

while($tabla = mysql_fetch_array($resultado)){
    echo "<tr>";
    echo "<td>".$tabla[1]."</td>";
    echo "<td>".$tabla[2]."</td>";
    echo "<td>".$tabla[3]."</td>";
    echo "<td>".$tabla[4]."</td>";
    echo "<td><span onclick='borrarPlaylist(".$tabla[0].",\"".$playlist."\");'>borrar</span></td>";
    echo "</tr>";
}

echo "</tbody></table>";

mysql_close($conn);
?>