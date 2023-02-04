<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("PowerLists",$conn);

$idPlaylist = $_GET["idPlaylist"];

$nombrePlaylist = isset($_POST["nombrePlaylist"]) ? $_POST["nombrePlaylist"] : "";
$generoPlaylist = $_POST["generoPlaylist"];
$categoriaPlaylist = isset($_POST["categoriaPlaylist"]) ? $_POST["categoriaPlaylist"] : "";
$tipoPlaylist = $_POST["tipoPlaylist"];
$cancionPlaylist = isset($_POST["cancionPlaylist"]) ? $_POST["cancionPlaylist"] : "";

$query = "select nombre, tipo from Playlist where id_playlist = ".$idPlaylist.";";

$resultado = mysql_query($query, $conn);

$tabla = mysql_fetch_array($resultado);

$nombreAnterior = $tabla[0];
$tipoAnterior = $tabla[1];

$query = "select id_genero from Genero where nombre = '".$generoPlaylist."'";
$resultado = mysql_query($query, $conn);

$genero = mysql_fetch_array($resultado);

date_default_timezone_set('America/Argentina/Buenos_Aires');
$horaActual = date("Y-m-d H:i:s");

$query = "update Playlist set nombre = '".$nombrePlaylist."', id_genero = ".$genero[0].", categoria = '".$categoriaPlaylist."', tipo = '".$tipoPlaylist."', fecha_ult_mod = '".$horaActual."' where id_playlist = ".$idPlaylist.";";

$resultado = mysql_query($query, $conn);

$deleteTracks = "delete from PlaylistTrack where id_playlist = ".$idPlaylist.";";

$resultado = mysql_query($deleteTracks, $conn);

if (is_array($cancionPlaylist))
    foreach ($cancionPlaylist as $cancion){
        $query = "select id_track from Track where titulo = '".$cancion."';";  
        $resultado = mysql_query($query, $conn);
        $tabla = mysql_fetch_array($resultado);
        
        $query = "insert into PlaylistTrack values(".$idPlaylist.",".$tabla[0].");";
        $resultado = mysql_query($query, $conn);
    }
else{
    $query = "select id_track from Track where titulo = '".$cancionPlaylist."';";  
    $resultado = mysql_query($query, $conn);
    $tabla = mysql_fetch_array($resultado);
    
    $query = "insert into PlaylistTrack values(".$idPlaylist.",".$tabla[0].");";
    $resultado = mysql_query($query, $conn);
}

$query = "select max(id_notificacion) from Notificacion";

$resultado = mysql_query($query, $conn);

$filas = mysql_fetch_array($resultado);

$fila = $filas[0];

$query = "select id_usuario from PlaylistUsuario where id_playlist = ".$idPlaylist.";";

$resultado = mysql_query($query, $conn);

while ($tabla = mysql_fetch_array($resultado)){
    $fila += 1;
    
    if ($tipoPlaylist == "publica")
        $descripcion = "La Playlist -".$nombreAnterior."- se ha actualizado";
    else {
        $descripcion = $_SESSION["usuarioLogueado"]." dej&oacute; de publicar la playlist -".$nombreAnterior."-";
        
        $delete = "delete from PlaylistUsuario where id_playlist = ".$idPlaylist." and id_usuario = ".$tabla[0].";";
    
        $resultado2 = mysql_query($delete, $conn);
    }
    
    $insert = "insert into Notificacion values (".$fila.", ".$tabla[0].", '".$descripcion."');";
    
    $resultado2 = mysql_query($insert, $conn);
}

if ($tipoPlaylist == "compartida" || $tipoAnterior == "compartida") {
    $query = "select id_usuario_solicitante from Solicitud where id_usuario_solicitado = ".$_SESSION["idUsuarioLogueado"]." and estado = 2;";
    
    $resultado = mysql_query($query, $conn);
    
    while ($tabla = mysql_fetch_array($resultado)){
        $fila += 1;
        
        $descripcion = $tipoPlaylist == "compartida" && $tipoAnterior == "compartida"
                        ? "La Playlist -".$nombreAnterior."- se ha actualizado"
                        : ($tipoPlaylist == "compartida"
                            ? $_SESSION["usuarioLogueado"]." comparti&oacute; la playlist -".$nombreAnterior."-"
                            : $_SESSION["usuarioLogueado"]." dej&oacute; de compartir la playlist -".$nombreAnterior."-");
        
        $insert = "insert into Notificacion values (".$fila.", ".$tabla[0].", '".$descripcion."');";
        
        $resultado2 = mysql_query($insert, $conn);
    }
}

mysql_close($conn);
header("location:home.php");
?>