<?php session_start(); ?>
<html>
<head>

<link rel="stylesheet" type="text/css" href="css/estilos_home.css"/>
<title id="title">Bienvenido a PowerLists</title>

<style type="text/css">
#notificaciones {
    display: none;
    width: 400px;
    height: 300px;
    position: absolute;
    background-color: white;
}
</style>
<script type="text/javascript">

function abrirNotificaciones(){
    var notificaciones = document.getElementById("notificaciones");
    notificaciones.style.display = notificaciones.style.display != "block" ? "block" : "none";
}

function cargarPlaylist(idPlaylist){
    var reproductor = parent.document.getElementById('reproductor');
    
    reproductor.src = 'reproductor.php?idPlaylist='+idPlaylist;
}
</script>
</head>

<body>
<div id="main">
<div id="header">

<div id="login" style="color: white;">Bienvenido
<?php echo " <a href='miPerfil.php'>".$_SESSION["usuarioLogueado"]."</a>"; ?> 

<?php  
if ($_SESSION["rolUsuario"] == "administrador")
    echo "<span><a href='admin.php'>Admin</a></span>";
?>

<img class="icono" src="img/notification.png" onclick="abrirNotificaciones();" />

<?php        
$conn = mysql_connect("localhost","root","");                
mysql_select_db("PowerLists",$conn); 

$notificaciones = isset($_GET["notificaciones"]) ? $_GET["notificaciones"] : 0;

$query = "select u.nombre_usuario from Solicitud s inner join Usuario u on u.id_usuario = s.id_usuario_solicitante where id_usuario_solicitado = ".$_SESSION["idUsuarioLogueado"]." and estado = 1;";

$resultado = mysql_query($query, $conn);

if ($notificaciones == 1)
    echo "<div id='notificaciones' style='display: block;'><ul>";
else
    echo "<div id='notificaciones'><ul>";

while ($tabla = mysql_fetch_array($resultado)){
    echo "<li>".$tabla[0]." quiere seguirte <a href='actualizarSolicitud.php?usuario=".$tabla[0]."&respuesta=2'>confirmar</a>/<a href='actualizarSolicitud.php?usuario=".$tabla[0]."&respuesta=0'>rechazar</a></li>";
}

$query = "select id_notificacion, descripcion from Notificacion where id_usuario = ".$_SESSION["idUsuarioLogueado"].";";

$resultado = mysql_query($query, $conn);

while ($tabla = mysql_fetch_array($resultado)){
    echo "<li>".$tabla[1]."<span><a href='eliminarNotificacion.php?idNotificacion=".$tabla[0]."'><img src='img/close-icon.png'/></a></span></li>";
}

echo "</ul></div>";
?>


<a class="icono" href="votaciones.php"><img src="img/votar.png"/></a>

<a class="icono" href="cerrarSesion.php"><img src="img/borrar.png"/></a>

</div>
<a id="homelink" href="home.php"><img src="img/pl_logo2.png" id="logo" alt="powerlist"/></a> 
<span id="title">El sitio web de intercambio de listas!</span>

<div>
<form action="busquedaPlaylist.php" method="post">
<input type="text" name="busqueda" />
<input type="submit" value="Buscar" />
</form>
</div>


	<!-- contenedor -->
<div id="container_left">
	<div id="user_title">
		<h1>Seccion User</h1>
	</div>
<hr/>
<a href="creacionPlaylist.php"><input type="button" value="Crear Playlist" /></a>
<a href="cargaCanciones.php"><input type="button" value="Cargar MP3 +" /></a>
<div>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Genero</th>
                <th>Categoria</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php        
                $conn = mysql_connect("localhost","root","");                
                mysql_select_db("PowerLists",$conn);                
                
                $query = "select p.id_playlist, p.nombre, g.nombre, p.categoria, p.tipo from Playlist p inner join Genero g on g.id_genero = p.id_genero where p.id_usuario_creador = '".$_SESSION["idUsuarioLogueado"]."';";
                
                $resultado = mysql_query($query, $conn);
                
                while($tabla = mysql_fetch_array($resultado)){
                	echo "<tr>";
                	echo "<td><a href='editarPlaylist.php?idPlaylist=".$tabla[0]."&cod=1'>".$tabla[1]."</a></td>";
                	echo "<td>".$tabla[2]."</td>";
                	echo "<td>".$tabla[3]."</td>";
                	echo "<td>".$tabla[4]."</td>";
                	echo "<td><a href='borrarPlaylist.php?idPlaylist=".$tabla[0]."&cod=1'>borrar</a></td>";
                	echo "<td></td>";
                	echo "<td><img src='img/ico_flecha.gif' onclick='cargarPlaylist(".$tabla[0].");' /></td>";
                	echo "</tr>";
                }
                
                $query = "select p.id_playlist, p.nombre, g.nombre, p.categoria, p.tipo from Solicitud s inner join Playlist p on p.id_usuario_creador = s.id_usuario_solicitado inner join Genero g on g.id_genero = p.id_genero where s.estado = 2 and p.tipo = 'compartida' and s.id_usuario_solicitante = ".$_SESSION["idUsuarioLogueado"].";";
                
                $resultado = mysql_query($query, $conn);
                
                while($tabla = mysql_fetch_array($resultado)){
                	echo "<tr>";
                	echo "<td><a href='editarPlaylist.php?idPlaylist=".$tabla[0]."&cod=2'>".$tabla[1]."</a></td>";
                	echo "<td>".$tabla[2]."</td>";
                	echo "<td>".$tabla[3]."</td>";
                	echo "<td>".$tabla[4]."</td>";
                	echo "<td></td>";
                    
                    $query = "select id_playlist from Voto where id_usuario = ".$_SESSION["idUsuarioLogueado"]." and id_playlist = ".$tabla[0].";";
                    
                    $resultado2 = mysql_query($query, $conn);
                    
                    if (mysql_fetch_array($resultado2))
                        echo "<td></td>";
                    else
                        echo "<td><a href='votacionPlaylist.php?idPlaylist=".$tabla[0]."&cod=1'>votar</a></td>";
                    
                	echo "<td><img src='img/ico_flecha.gif' onclick='cargarPlaylist(".$tabla[0].");' /></td>";
                	echo "</tr>";
                }
                
                $query = "select p.id_playlist, p.nombre, g.nombre, p.categoria, p.tipo from PlaylistUsuario pu inner join Playlist p on p.id_playlist = pu.id_playlist inner join Genero g on g.id_genero = p.id_genero where pu.id_usuario = ".$_SESSION["idUsuarioLogueado"].";";
                
                $resultado = mysql_query($query, $conn);
                
                while($tabla = mysql_fetch_array($resultado)){
                    
                	echo "<tr>";
                	echo "<td><a href='editarPlaylist.php?idPlaylist=".$tabla[0]."&cod=2'>".$tabla[1]."</a></td>";
                	echo "<td>".$tabla[2]."</td>";
                	echo "<td>".$tabla[3]."</td>";
                	echo "<td>".$tabla[4]."</td>";
                	echo "<td><a href='borrarPlaylist.php?idPlaylist=".$tabla[0]."&cod=2'>borrar</a></td>";
                    
                    $query = "select id_playlist from Voto where id_usuario = ".$_SESSION["idUsuarioLogueado"]." and id_playlist = ".$tabla[0].";";
                    
                    $resultado2 = mysql_query($query, $conn);
                    
                    if (mysql_fetch_array($resultado2))
                        echo "<td></td>";
                    else
                        echo "<td><a href='votacionPlaylist.php?idPlaylist=".$tabla[0]."&cod=1'>votar</a></td>";
                    
                	echo "<td><img src='img/ico_flecha.gif' onclick='cargarPlaylist(".$tabla[0].");' /></td>";
                	echo "</tr>";
                }
                
                mysql_close($conn);
            ?>
        </tbody>
    </table>
</div>
</div>

<div id="container_right">
	<div id="playlist_title">
		<h1>Seccion Listas</h1>
	</div>
 <hr/>
 <span id="playlist_subtitle">Listas mas populares</span>
 <div>
 <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Genero</th>
                <th>Categoria</th>
                <th>Tipo</th>
                <th>Usuario</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = mysql_connect("localhost","root","");
            mysql_select_db("PowerLists",$conn);
            
            $query = "select p.nombre, g.nombre, p.categoria, p.tipo, u.nombre_usuario, AVG(v.voto) as promedio, p.id_playlist from Voto v inner join Playlist p on p.id_playlist = v.id_playlist inner join Genero g on g.id_genero = p.id_genero inner join Usuario u on u.id_usuario = p.id_usuario_creador group by p.id_playlist order by promedio desc;";
            
            $resultado = mysql_query($query, $conn);
            
            $ranking = 0;
            
            while ($tabla = mysql_fetch_array($resultado)){
                $ranking += 1;
                echo "<tr>";
            	echo "<td>".$tabla[0]."</td>";
            	echo "<td>".$tabla[1]."</td>";
            	echo "<td>".$tabla[2]."</td>";
            	echo "<td>".$tabla[3]."</td>";
            	echo "<td><a href='perfilUsuario.php?usuario=".$tabla[4]."'>".$tabla[4]."</a></td>";
            	echo "<td>".$ranking."</td>";
            	echo "</tr>";
            }
            
            mysql_close($conn);
            ?>
        </tbody>
    </table>
 </div>
</div>
</div>
</body>
</html>