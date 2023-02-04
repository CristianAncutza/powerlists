<?php session_start();?>
<html>
<head>
<style type="text/css">
#footer{
	height: 100px;
    width: 100%;
	background-color: black;
	border: none;
    text-align: center;
}

.comment {
    color: white;
}

body {
    background-color: none;
}
</style>
</head>
<body>
<div id="footer">
<span class="comment"></span>
<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$idPlaylist = isset($_GET["idPlaylist"]) ? $_GET["idPlaylist"] : "";
$idTrack = isset($_GET["idTrack"]) ? $_GET["idTrack"] : "";


if ($idPlaylist != ""){
    $query = "select t.titulo, p.nombre from PlaylistTrack pt inner join Track t on t.id_track = pt.id_track inner join Playlist p on p.id_playlist = pt.id_playlist where pt.id_playlist = ".$idPlaylist.";";
    
    $resultado = mysql_query($query, $conn);
    
    $xml = new DOMDocument('1.0','UTF-8');
    $xml_playlist = $xml->createElement("playlist");
    $xml_playlist_version = $xml->createAttribute("version");
    $xml_playlist_version->value = "1";
    $xml_playlist_xmlns = $xml->createAttribute("xmlns");
    $xml_playlist_xmlns->value = "http://xspf.org/ns/0/";
    $xml_playlist->appendChild($xml_playlist_version);
    $xml_playlist->appendChild($xml_playlist_xmlns);
    
    $xml_tracklist = $xml->createElement("trackList");
    
    while($tabla = mysql_fetch_array($resultado)){
        
    $xml_track = $xml->createElement("track");
    $xml_location = $xml->createElement("location");
    $xml_location->nodeValue = "mp3/".$tabla[0];
    
    $xml_track->appendChild($xml_location);
    $xml_tracklist->appendChild($xml_track);
    
    $tituloPlaylist = $tabla[1];
    }
    
    $xml_playlist->appendChild($xml_tracklist);
    $xml->appendChild($xml_playlist);
    
    $xml->save($tituloPlaylist."playlist.xspf");    
    
    echo "<object type='application/x-shockwave-flash' width='410' height='22' data='xspf_player_slim.swf?autoplay=false&playlist_url=".$tituloPlaylist."playlist.xspf'>";
    echo "<param name='movie' value='xspf_player_slim.swf?autoplay=false&playlist_url=".$tituloPlaylist."playlist.xspf' />";
    echo "</object>";
    
    //$xml->save("playlist.xspf");    
    
    //echo "<object type='application/x-shockwave-flash' width='410' height='22' data='xspf_player_slim.swf?autoplay=false&playlist_url=playlist.xspf'>";
    //echo "<param name='movie' value='xspf_player_slim.swf?autoplay=false&playlist_url=playlist.xspf' />";
    //echo "</object>";
}
else if ($idTrack != ""){
    $query = "select t.titulo from Track t where t.id_track = ".$idTrack.";";
    
    $resultado = mysql_query($query, $conn);
    
    $tabla = mysql_fetch_array($resultado);
    
    echo "<object type='application/x-shockwave-flash' width='410' height='22' data='xspf_player_slim.swf?autoplay=false&song_url=mp3/".$tabla[0]."'>";
    echo "<param name='movie' value='xspf_player_slim.swf?autoplay=false&song_url=mp3/".$tabla[0]."' />";
    echo "</object>";
}

mysql_close($conn);
?>
</div>
</body>
</html>