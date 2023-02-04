<?php session_start();?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/estilos_creacionpl.css"/>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
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

function busca() {	
    var texto = document.getElementById('texto').value;
	var strURL="buscaCanciones.php?texto="+texto;
	var req = getXMLHTTP();
	if (req) {
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				// only if "OK"
				if (req.status == 200) {		
				   document.getElementById('canciones').innerHTML=req.responseText; 					
                } else {
					alert("There was a problem while using XMLHTTP:\n" + req.statusText);
				}
			}				
		}			
		req.open("GET", strURL, true);
		req.send(null);
	}
}

function agregar(){
    $(":checkbox").each(function(){
        if ($(this).prop("checked")){
            $("#cancionPlaylist").append("<option value='"+$(this).val()+"'>"+$(this).val()+"</option>")
        }
    });
}

function validar(){
    if ($("#cancionPlaylist").children().length != 0){
        $("#cancionPlaylist").children().each(function(){
            $(this).attr("selected","selected");
        });
        return true;      
    }
    
    alert("Debe seleccionar al menos una canción");
    return false;    
}

function habilitarRemover(){
    var habilitado = false;
    if ($("#cancionPlaylist").children().length != 0){
        $("#cancionPlaylist").children().each(function(){
            if($(this).prop("selected")){
                habilitado = true;
                return true;
            }
        }); 
    }
    if (habilitado)
        $("#remover").prop("disabled","");
    else
        $("#remover").prop("disabled","disabled");
}

function removera(){
    $("#cancionPlaylist").children().each(function(){
        if($(this).prop("selected")){
            $(this).remove();
        }
    }); 
    
    habilitarRemover();
}

function cargarCancion(idTrack){    
    var reproductor = parent.document.getElementById('reproductor');
    
    reproductor.src = 'reproductor.php?idTrack='+idTrack;
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
        <h1>Seccion de edicion de playlist</h1>
    </div>
<hr/>
    <?php
    $conn = mysql_connect("localhost","root","");
    mysql_select_db("powerlists",$conn);
    
    $idPlaylist = $_GET["idPlaylist"];
    $cod = $_GET["cod"];
    
    $disabled = $cod != 1 ? " disabled " : "";
    
    $query = "select p.nombre, g.nombre, p.categoria, p.tipo from Playlist p inner join Genero g on g.id_genero = p.id_genero where p.id_playlist = ".$idPlaylist.";";
    
    $resultado = mysql_query($query, $conn);
    
    $tabla = mysql_fetch_array($resultado);
    
    $query = "select nombre from Genero;";
    
    $resultado = mysql_query($query, $conn);
    
    echo "<form id='formulario' method='post' action='actualizarPlaylist.php?idPlaylist=".$idPlaylist."' onsubmit='return validar();'>";
    echo "<div>Nombre: <input type='text' id='nombrePlaylist' name='nombrePlaylist' value='".$tabla[0]."' ".$disabled."/></div>";
    echo "<div>Genero:"; 
    echo "<select id='generoPlaylist' name='generoPlaylist' value='".$tabla[1]."' ".$disabled.">";
    while ($genero = mysql_fetch_array($resultado)){
        if ($genero[0] == $tabla[1])
            echo "<option value='".$genero[0]."' selected>".$genero[0]."</option>";
        else
            echo "<option value='".$genero[0]."'>".$genero[0]."</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div>Categoria: <input type='text' id='categoriaPlaylist' name='categoriaPlaylist' value='".$tabla[2]."' ".$disabled."/></div>";
    echo "<div>Tipo: <select id='tipoPlaylist' name='tipoPlaylist' value='".$tabla[3]."' ".$disabled.">";
    if ($tabla[3] == "privada")
        echo "<option value='privada' selected>Privada</option>";
    else
        echo "<option value='privada'>Privada</option>";
     if ($tabla[3] == "publica")
        echo "<option value='publica' selected>Publica</option>";
    else
        echo "<option value='publica'>Publica</option>";
     if ($tabla[3] == "compartida")
        echo "<option value='compartida' selected>Compartida</option>";
    else
        echo "<option value='compartida'>Compartida</option>";
    echo "</select></div>";
    
    $query = "select t.titulo from PlaylistTrack p inner join Track t on p.id_track = t.id_track where p.id_playlist = ".$idPlaylist.";";
    
    $resultado = mysql_query($query, $conn);
    
    echo "<div>Canciones: <select id='cancionPlaylist' name='cancionPlaylist[]' multiple='multiple' onchange='habilitarRemover();' ".$disabled.">";
    while ($titulos = mysql_fetch_array($resultado)){
        echo "<option value='".$titulos[0]."'>".$titulos[0]."</option>";
    }
    echo "</select><input id='remover' type='button' value='Remover' onclick='removera();' disabled='disabled' /></div>";
    echo "<div><input type='submit' value='Guardar' ".$disabled."/></div>";
    echo "</form>";
    
    mysql_close($conn);
    ?>
    <div id="formulario">
        <input id="texto" type="text" name="texto" <?php echo $disabled?>/>
        <input type="button" value="Buscar MP3" onclick="busca();" <?php echo $disabled?>/><br/><br/>
        <div id="canciones">
        </div>
    </div>
</div>
</body>
</html>