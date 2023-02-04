<?php session_start(); ?>
<html>
<head>
     <link rel="stylesheet" type="text/css" href="css/estilos_busqueda.css"/>
<style type="text/css">
#tabs div{
    float:left;
    border: 1px solid black;
    cursor: pointer;
}

#usuarios {
    display: block;
}

#playlists {
    display: none;
}

#tracks {
    display: none;
}
</style>
<script type="text/javascript">
function menu(tab){
    var usuarios = document.getElementById("usuarios");
    var playlists = document.getElementById("playlists");
    var tracks = document.getElementById("tracks");
    
    usuarios.style.display = tab == 'usuarios' ? 'block' : 'none';
    playlists.style.display = tab == 'playlists' ? 'block' : 'none';
    tracks.style.display = tab == 'tracks' ? 'block' : 'none';
}

function getXMLHTTP() { 
	var xmlhttp=false;	
	try{
		xmlhttp=new XMLHttpRequest();
	}
	catch(e){		
		try{			
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
                xmlhttp=false;
			}
		}
	}
	return xmlhttp;
}

function buscaUsuario(){
    var texto = document.getElementById('usuario').value;
	var strURL="buscaUsuarios.php?texto="+texto;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
				   document.getElementById('usuariosTabla').innerHTML=req.responseText; 					
                } else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}

function actualizarPermisos(idUsuario, rol){
	var strURL="actualizarPermisos.php?IdUsuario="+idUsuario+"&Rol="+rol;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
				   document.getElementById('permiso'+idUsuario).innerHTML=req.responseText; 					
                } else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}

function borrarUsuario(idUsuario, usuario) {
	var strURL="borrarUsuario.php?IdUsuario="+idUsuario+"&texto="+usuario;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
				   document.getElementById('usuariosTabla').innerHTML=req.responseText; 					
                } else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}

function buscaPlaylist() {	
    var texto = document.getElementById('playlist').value;
	var strURL="buscaPlaylists.php?texto="+texto;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
				   document.getElementById('playlistsTabla').innerHTML=req.responseText; 					
                } else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}

function borrarPlaylist(idPlaylist, playlist) {
	var strURL="borrarPlaylist.php?idPlaylist="+idPlaylist+"&cod=3&texto="+playlist;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
				   document.getElementById('playlistsTabla').innerHTML=req.responseText; 					
                } else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}

function buscaTracks() {	
    var texto = document.getElementById('track').value;
	var strURL="buscaTracks.php?texto="+texto;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
				   document.getElementById('tracksTabla').innerHTML=req.responseText; 					
                } else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}

function borrarTrack(idTrack, titulo, track) {
	var strURL="borrarTrack.php?idTrack="+idTrack+"&titulo="+titulo+"&texto="+track;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
				   document.getElementById('tracksTabla').innerHTML=req.responseText; 					
                } else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}
</script>
</head>
<body>
  <div id="header">
    <a id="homelink" href="home.php"><img src="img/pl_logo2.png" id="logo" alt="powerlist"/></a> 
    <span id="title">El sitio web de intercambio de playlists!</span>
    </div>
<div id="container_left">    
        <div id="user_title">
        <h1>Seccion de Administrador</h1>
        </div>
    <hr/>
    <div id="tabs">
        <div id="tabUsuarios" onclick="menu('usuarios');">Usuarios</div>
        <div id="tabPlaylist" onclick="menu('playlists');">Playlists</div>
        <div id="tabTracks" onclick="menu('tracks');">Tracks</div>
    </div>
    <div id="usuarios">
        <div>
            <input type="text" id="usuario" />
            <input type="button" value="Buscar" onclick="buscaUsuario();" />
            <div id="usuariosTabla">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php            
                        $conn = mysql_connect("localhost","root","");
                        mysql_select_db("powerlists",$conn);
                        
                        $query = "select id_usuario, nombre_usuario, nombre, apellido, email, rol from Usuario where id_usuario != ".$_SESSION["idUsuarioLogueado"].";";
                        
                        $resultado = mysql_query($query, $conn);
                        
                        while($tabla = mysql_fetch_array($resultado)){
                        	echo "<tr>";
                        	echo "<td>".$tabla[1]."</td>";
                        	echo "<td>".$tabla[2]."</td>";
                        	echo "<td>".$tabla[3]."</td>";
                        	echo "<td>".$tabla[4]."</td>";
                            echo "<td><span onclick='borrarUsuario(".$tabla[0].",\"\");'>borrar</span></td>";
                            if ($tabla[5] == "usuario")
                                echo "<td id='permiso".$tabla[0]."'><span onclick='actualizarPermisos(".$tabla[0].",\"administrador\");'>hacer admin</span></td>";
                            else
                                echo "<td id='permiso".$tabla[0]."'><span onclick='actualizarPermisos(".$tabla[0].",\"usuario\");'>hacer usuario</span></td>";
                        	echo "</tr>";
                        }
                        
                        mysql_close($conn);
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="playlists">
        <div>
            <input type="text" id="playlist" />
            <input type="button" value="Buscar" onclick="buscaPlaylist();"/>
            <div id="playlistsTabla">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Titulo</th>
                            <th>Genero</th>
                            <th>Categoria</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php            
                        $conn = mysql_connect("localhost","root","");
                        mysql_select_db("powerlists",$conn);
                        
                        $query = "select p.id_playlist, p.nombre, g.nombre, p.categoria, p.tipo from Playlist p inner join Genero g on g.id_genero = p.id_genero;";
                        
                        $resultado = mysql_query($query, $conn);
                        
                        while($tabla = mysql_fetch_array($resultado)){
                        	echo "<tr>";
                        	echo "<td>".$tabla[1]."</td>";
                        	echo "<td>".$tabla[2]."</td>";
                        	echo "<td>".$tabla[3]."</td>";
                        	echo "<td>".$tabla[4]."</td>";
                            echo "<td><span onclick='borrarPlaylist(".$tabla[0].",\"\");'>borrar</span></td>";
                        	echo "</tr>";
                        }
                        
                        mysql_close($conn);
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="tracks">
        <div>
            <input type="text" id="track" />
            <input type="button" value="Buscar" onclick="buscaTracks();" />
            <div id="tracksTabla">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Titulo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php            
                        $conn = mysql_connect("localhost","root","");
                        mysql_select_db("powerlists",$conn);
                        
                        $query = "select titulo, id_track from Track;";
                        
                        $resultado = mysql_query($query, $conn);
                        
                        while($tabla = mysql_fetch_array($resultado)){
                        	echo "<tr>";
                        	echo "<td>".$tabla[0]."</td>";
                            echo "<td><span onclick='borrarTrack(".$tabla[1].",\"".$tabla[0]."\",\"\");'>borrar</span></td>";
                        	echo "</tr>";
                        }
                        
                        mysql_close($conn);
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>