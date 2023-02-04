<?php session_start(); ?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/estilos_busqueda.css"/>

<script type="text/javascript">

function filtroGenero(){
    var genero = document.getElementById('genero');
    var generoPlaylist = document.getElementById('generoPlaylist');
    generoPlaylist.style.visibility = genero.checked ? 'visible' : 'hidden';     
}

function filtroTipo(){
    var tipo = document.getElementById('tipo');
    var tipoPlaylist = document.getElementById('tipoPlaylist');
    tipoPlaylist.style.visibility = tipo.checked ? 'visible' : 'hidden'; 
}

function filtroCategoria(){
    var categoria = document.getElementById('categoria');
    var categoriaPlaylist = document.getElementById('categoriaPlaylist');
    categoriaPlaylist.style.visibility = categoria.checked ? 'visible' : 'hidden';     
}
</script>
</head>
<body>
        <div id="header">
    <a id="homelink" href="home.php"><img src="img/pl_logo2.png" id="logo" alt="powerlist"/></a> 
    <span id="title">El sitio web de intercambio de playlists!</span>
    </div>
<div id="container_left">    
    <div id="formulario">

        <div id="user_title">
        <h1>Seccion Busqueda</h1>
        </div>
    <hr/>
    
    <form action="#" method="post">
        <input type="text" name="busqueda" />
        <input type="submit" value="Buscar" /><br/>
        <input type="checkbox" id="genero" name="genero" value="genero" onchange="filtroGenero();" />Genero 
            <select id="generoPlaylist" name="generoPlaylist" style="visibility: hidden;">
                <option value="Rock">Rock</option>
                <option value="Dance">Dance</option>
                <option value="Pop">Pop</option>
                <option value="Salsa">Salsa</option>
                <option value="Cumbia">Cumbia</option>
            </select><br/>
        <input type="checkbox" id="categoria" name="categoria" value="categoria" onchange="filtroCategoria();" />Categoria
        <input type="text" id="categoriaPlaylist" name="categoriaPlaylist" style="visibility: hidden;"/><br/>
        <input type="checkbox" id="tipo" name="tipo" value="tipo" onchange="filtroTipo();" />Tipo
            <select id="tipoPlaylist" name="tipoPlaylist" style="visibility: hidden;">
                <option value="publica">Publica</option>
                <option value="compartida">Compartida</option>
            </select><br/>
    </form>
    </div>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Genero</th>
                <th>Categoria</th>
                <th>Tipo</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
        <?php            
            $conn = mysql_connect("localhost","root","");
            mysql_select_db("powerlists",$conn);
            
            $texto = isset($_POST["busqueda"]) ? $_POST["busqueda"] : "";
            $genero = isset($_POST["genero"]) ? $_POST["genero"] : "";
            $generoPlaylist = isset($_POST["generoPlaylist"]) ? $_POST["generoPlaylist"] : "";
            $categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : "";
            $categoriaPlaylist = isset($_POST["categoriaPlaylist"]) ? $_POST["categoriaPlaylist"] : "";
            $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
            $tipoPlaylist = isset($_POST["tipoPlaylist"]) ? $_POST["tipoPlaylist"] : "";
            
            $query = "select p.id_playlist, p.nombre, g.nombre, p.categoria, p.tipo, u.nombre_usuario from Playlist p inner join Genero g on g.id_genero = p.id_genero inner join Usuario u on u.id_usuario = p.id_usuario_creador where p.nombre like '%".$texto."%' and p.tipo <> 'privada' and p.id_usuario_creador <> ".$_SESSION["idUsuarioLogueado"]." and not exists (select 1 from Solicitud s where s.id_usuario_solicitado = p.id_usuario_creador and s.id_usuario_solicitante = ".$_SESSION["idUsuarioLogueado"]." and s.estado = 2 and p.tipo = 'compartida') and not exists(select 1 from PlaylistUsuario pu where pu.id_playlist = p.id_playlist and pu.id_usuario = ".$_SESSION["idUsuarioLogueado"].")";
            
            if ($genero)
                $query .= " and g.nombre = '".$generoPlaylist."'";
            if ($categoria)
                $query .= " and p.categoria like '%".$categoriaPlaylist."%'";
            if ($tipo)
                $query .= " and p.tipo = '".$tipoPlaylist."'";
            $query .= ";";
            
            $resultado = mysql_query($query, $conn);
            
            while($tabla = mysql_fetch_array($resultado)){
            	echo "<tr>";
            	echo "<td><a href='editarPlaylist.php?idPlaylist=".$tabla[0]."&cod=2'>".$tabla[1]."</a></td>";
            	echo "<td>".$tabla[2]."</td>";
            	echo "<td>".$tabla[3]."</td>";
            	echo "<td>".$tabla[4]."</td>";
            	echo "<td><a href='perfilUsuario.php?usuario=".$tabla[5]."'>".$tabla[5]."</a></td>";
                if ($tabla[4] == "publica")
            	   echo "<td><a href='copiarPlaylist.php?idPlaylist=".$tabla[0]."'>copiar</a></td>";
                    
            	echo "</tr>";
            }
                            
            mysql_close($conn);
        ?>
        </tbody>
    </table>
</div>
</body>
</html>

