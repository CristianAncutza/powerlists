<?php session_start(); ?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/estilos_busqueda.css"/>
</head>
<body>
    <div id="header">
    <a id="homelink" href="home.php"><img src="img/pl_logo2.png" id="logo" alt="powerlist"/></a> 
    <span id="title">El sitio web de intercambio de playlists!</span>
    </div>
<div id="container_left">    
        <div id="user_title">
        <h1>Perfil de usuario</h1>
        </div>
    <hr/>
<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$usuario = isset($_GET["usuario"]) ? $_GET["usuario"] : "";
echo "Perfil del usuario: ".$usuario."<br/>";

$query = "select estado from Solicitud s inner join Usuario u on u.id_usuario = s.id_usuario_solicitado  where u.nombre_usuario = '".$usuario."' and s.id_usuario_solicitante = '".$_SESSION["idUsuarioLogueado"]."';";

$resultado = mysql_query($query, $conn);

$filas = mysql_num_rows($resultado);

if ($filas){
    $tabla = mysql_fetch_array($resultado);
    $estado = $tabla[0];
    if ($estado == 2){
        echo "Ya lo sigues!";
    }
    else{
        echo "Solicitud Enviada";   
    }    
}
else{
    echo "<a href='solicitarAmistad.php?usuario=".$usuario."'><input type='button' value='Seguir' /></a>";
}

echo "<table border='1'><thead><tr><th>Nombre</th><th>Genero</th><th>Categoria</th><th>Tipo</th></tr></thead><tbody>";

$query = "select p.nombre, g.nombre, p.categoria, p.tipo from Playlist p inner join Genero g on g.id_genero = p.id_genero inner join Usuario u on u.id_usuario = p.id_usuario_creador where u.nombre_usuario = '".$usuario."' and p.tipo <> 'privada';";
          
$resultado = mysql_query($query, $conn);
            
while($tabla = mysql_fetch_array($resultado)){
	echo "<tr>";
	echo "<td>".$tabla[0]."</td>";
	echo "<td>".$tabla[1]."</td>";
	echo "<td>".$tabla[2]."</td>";
	echo "<td>".$tabla[3]."</td>";
	echo "</tr>";
}

echo "</tbody></table>";

mysql_close($conn);
?>
</div>
</body>
</html>
