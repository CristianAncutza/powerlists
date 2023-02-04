<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$usuario = isset($_GET["texto"]) ? $_GET["texto"] : "";

$query = "select id_usuario, nombre_usuario, nombre, apellido, email, rol from Usuario where nombre_usuario like '%".$usuario."%' and id_usuario != ".$_SESSION["idUsuarioLogueado"].";";

$resultado = mysql_query($query, $conn);

echo "<table border='1'><thead><tr><th>Usuario</th><th>Nombre</th><th>Apellido</th><th>Email</th></tr></thead><tbody>";

while($tabla = mysql_fetch_array($resultado)){
	echo "<tr>";
	echo "<td>".$tabla[1]."</td>";
	echo "<td>".$tabla[2]."</td>";
	echo "<td>".$tabla[3]."</td>";
	echo "<td>".$tabla[4]."</td>";
    echo "<td><span onclick='borrarUsuario(".$tabla[0].",\"".$usuario."\");'>borrar</span></td>";
    if ($tabla[5] == "usuario")
        echo "<td id='permiso".$tabla[0]."'><span onclick='actualizarPermisos(".$tabla[0].",\"administrador\");'>hacer admin</span></td>";
    else
        echo "<td id='permiso".$tabla[0]."'><span onclick='actualizarPermisos(".$tabla[0].",\"usuario\");'>hacer usuario</span></td>";
	echo "</tr>";
}

echo "</tbody></table>";

mysql_close($conn);
?>