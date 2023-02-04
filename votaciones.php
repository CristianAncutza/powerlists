<?php session_start();?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/estilos_votaciones.css"/>
    <title id="title">Bienvenido a PowerLists</title>
</head>
<body>
<div id="header">
<a id="homelink" href="home.php"><img src="img/pl_logo2.png" id="logo" alt="powerlist"/></a> 
<span id="title">El sitio web de intercambio de playlists!</span>
</div>

<div id="container_left">
    <div id="user_title">
        <h1>Seccion Votaciones</h1>
    </div>
    <hr/>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Genero</th>
                <th>Categoria</th>
                <th>Tipo</th>
                <th>Voto</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = mysql_connect("localhost","root","");
            mysql_select_db("PowerLists",$conn);
            
            $query = "select p.nombre, g.nombre, p.categoria, p.tipo, v.voto, p.id_playlist from Voto v inner join Playlist p on p.id_playlist = v.id_playlist inner join Genero g on g.id_genero = p.id_genero where v.id_usuario = ".$_SESSION["idUsuarioLogueado"].";";
            
            $resultado = mysql_query($query, $conn);
            
            while ($tabla = mysql_fetch_array($resultado)){
                echo "<tr>";
            	echo "<td>".$tabla[0]."</td>";
            	echo "<td>".$tabla[1]."</td>";
            	echo "<td>".$tabla[2]."</td>";
            	echo "<td>".$tabla[3]."</td>";
            	echo "<td>".$tabla[4]."</td>";
                echo "<td><a href='votacionPlaylist.php?idPlaylist=".$tabla[5]."&cod=2'>cambiar voto</a></td>";
            	echo "</tr>";
            }
            
            mysql_close($conn);
            ?>
        </tbody>
    </table>
</div>
</body>
</html>