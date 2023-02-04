<?php
if ($_FILES["file"]["error"] > 0){
    header("location: cargaCanciones.php?error=2");
}
else{
    
    
    
    if (file_exists("mp3/".$_FILES["file"]["name"])){
        header("location: cargaCanciones.php?error=3");
    }
    else{
        $conn = mysql_connect("localhost","root","");
        mysql_select_db("powerlists",$conn);
        $query = "select max(id_track) from Track";
        $resultado = mysql_query($query, $conn);
        
        $filas = mysql_fetch_array($resultado);
        $query = "insert into Track values(".($filas[0]+1).",'".$_FILES["file"]["name"]."');";
        
        $resultado = mysql_query($query, $conn);
        
        mysql_close($conn);
        move_uploaded_file($_FILES["file"]["tmp_name"],
        "mp3/".$_FILES["file"]["name"]);
        header("location: cargaCanciones.php?error=1");
    }    
}
?>