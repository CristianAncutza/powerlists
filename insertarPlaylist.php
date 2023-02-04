<?php
session_start();
$conn = mysql_connect("localhost","root","");
mysql_select_db("PowerLists",$conn);

$nombrePlaylist = isset($_POST["nombrePlaylist"]) ? $_POST["nombrePlaylist"] : "";
$generoPlaylist = $_POST["generoPlaylist"];
$categoriaPlaylist = isset($_POST["categoriaPlaylist"]) ? $_POST["categoriaPlaylist"] : "";
$tipoPlaylist = $_POST["tipoPlaylist"];
$cancionPlaylist = isset($_POST["cancionPlaylist"]) ? $_POST["cancionPlaylist"] : "";
 
$usuario = $_SESSION["idUsuarioLogueado"];
$query = "select max(id_playlist) from Playlist";
$resultado = mysql_query($query, $conn);

$filas = mysql_fetch_array($resultado);

$query = "select id_genero from Genero where nombre = '".$generoPlaylist."'";
$resultado = mysql_query($query, $conn);

$genero = mysql_fetch_array($resultado);

date_default_timezone_set('America/Argentina/Buenos_Aires');
$horaActual = date("Y-m-d H:i:s"); 

$insert = "insert into Playlist values (".($filas[0]+1).",'".$nombrePlaylist."',".$genero[0].",'".$categoriaPlaylist."','".$tipoPlaylist."','".$horaActual."','".$horaActual."',".$usuario.");";

$resultado = mysql_query($insert, $conn);
if (is_array($cancionPlaylist))
    foreach ($cancionPlaylist as $cancion){
        $query = "select id_track from Track where titulo = '".$cancion."';";  
        $resultado = mysql_query($query, $conn);
        $tabla = mysql_fetch_array($resultado);
        
        $query = "insert into PlaylistTrack values(".($filas[0]+1).",".$tabla[0].");";
        $resultado = mysql_query($query, $conn);
    }
else{
    $query = "select id_track from Track where titulo = '".$cancionPlaylist."';";  
    $resultado = mysql_query($query, $conn);
    $tabla = mysql_fetch_array($resultado);
    
    $query = "insert into PlaylistTrack values(".($filas[0]+1).",".$tabla[0].");";
    $resultado = mysql_query($query, $conn);
}

if ($tipoPlaylist == "compartida"){
    $query = "select max(id_notificacion) from Notificacion";

    $resultado = mysql_query($query, $conn);
    
    $filas = mysql_fetch_array($resultado);
    
    $fila = $filas[0];
    
    $query = "select id_usuario_solicitante from Solicitud where id_usuario_solicitado = ".$_SESSION["idUsuarioLogueado"]." and estado = 2;";
    
        $resultado = mysql_query($query, $conn);
        
        while ($tabla = mysql_fetch_array($resultado)){
            $fila += 1;
            
            $descripcion = $_SESSION["usuarioLogueado"]." comparti&oacute; la playlist -".$nombrePlaylist."-";
            
            $insert = "insert into Notificacion values (".$fila.", ".$tabla[0].", '".$descripcion."');";
            
            $resultado2 = mysql_query($insert, $conn);
        }
}

mysql_close($conn);
header("location:home.php");
?>