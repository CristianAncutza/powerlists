<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$texto = $_GET["texto"];

$query = "select titulo, id_track from Track where titulo like '%".$texto."%';";

$resultado = mysql_query($query, $conn);

echo "<table border='1'><thead><tr><th></th><th>titulo</th><th></th></tr></thead><tbody>";

while ($tabla = mysql_fetch_array($resultado)){
    echo "<tr>";
    echo "<td><input type='checkbox' value='".$tabla[0]."' /></td>";
    echo "<td>".$tabla[0]."</td>";
    echo "<td><img src='img/ico_flecha.gif' onclick='cargarCancion(".$tabla[1].");' /></td>";
    echo "</tr>";
}

echo "</tbody></table>";
echo "<input type='button' value='Agregar' onclick='agregar();'/>";
?>