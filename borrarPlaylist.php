<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$idPlaylist = $_GET["idPlaylist"];
$cod = $_GET["cod"];
$playlist = isset($_GET["texto"]) ? $_GET["texto"] : "";

$query = "select nombre, tipo from Playlist where id_playlist = ".$idPlaylist.";";

$resultado = mysql_query($query, $conn);

$tabla = mysql_fetch_array($resultado);

$tituloPlaylist = $tabla[0];
$tipoPlaylist = $tabla[1];

if (($cod == 1 || $cod == 3) && $tipoPlaylist != "privada"){
    
    $query = "select max(id_notificacion) from Notificacion";
    
    $resultado = mysql_query($query, $conn);
    
    $filas = mysql_fetch_array($resultado);
    
    $fila = $filas[0];
            
    $descripcion = $cod != 3 ? $_SESSION["usuarioLogueado"]." borr&oacute; la playlist -".$tituloPlaylist."-" : "La playlist -".$tituloPlaylist."- ha sido borrada";
    
    if ($tipoPlaylist == "publica"){
        $query = "select id_usuario from PlaylistUsuario where id_playlist = ".$idPlaylist.";";
        
        $resultado = mysql_query($query, $conn);
        
        while ($tabla = mysql_fetch_array($resultado)){
            $fila += 1;
            
            $delete = "delete from PlaylistUsuario where id_playlist = ".$idPlaylist." and id_usuario = ".$tabla[0].";";
        
            $resultado2 = mysql_query($delete, $conn);        
            
            $insert = "insert into Notificacion values (".$fila.", ".$tabla[0].", '".$descripcion."');";
            
            $resultado2 = mysql_query($insert, $conn);
        }        
    }
    else {
    
        $query = "select id_usuario_solicitante from Solicitud where id_usuario_solicitado = ".$_SESSION["idUsuarioLogueado"]." and estado = 2;";
    
        $resultado = mysql_query($query, $conn);
        
        while ($tabla = mysql_fetch_array($resultado)){
            $fila += 1;
            
            $insert = "insert into Notificacion values (".$fila.", ".$tabla[0].", '".$descripcion."');";
            
            $resultado2 = mysql_query($insert, $conn);
        }
    }
            
    $delete = "delete from Voto where id_playlist = ".$idPlaylist.";";
    
    $resultado = mysql_query($delete, $conn);
}

if ($cod == 2)
    $delete = "delete from Voto where id_playlist = ".$idPlaylist." and id_usuario = ".$_SESSION["idUsuarioLogueado"].";";
else
    $delete = "delete from PlaylistTrack where id_playlist = ".$idPlaylist.";";

$resultado = mysql_query($delete, $conn);

switch ($cod){
    case 1:
    case 3:
        $query = "delete from Playlist where id_playlist = ".$idPlaylist.";";
        break;
    case 2:
        $query = "delete from PlaylistUsuario where id_playlist = ".$idPlaylist." and id_usuario = ".$_SESSION["idUsuarioLogueado"].";";
        break;
}

$resultado = mysql_query($query, $conn);

mysql_close($conn);

if ($cod != 3)
    header("location:home.php");
else{
    header("location:buscaPlaylists.php?texto=".$playlist);
}

?>