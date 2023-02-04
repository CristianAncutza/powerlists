<html>
<head>
<title>Creando una Playlist</title>
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
        <h1>Creacion de Playlist</h1>
    </div>
<hr/>
    <form id= "formulario" method="post" action="insertarPlaylist.php" onsubmit="return validar();">
        <div>Nombre: <input type="text" id="nombrePlaylist" name="nombrePlaylist" /></div>
        <div>Genero: 
            <select id="generoPlaylist" name="generoPlaylist">
            <?php
                $conn = mysql_connect("localhost","root","");
                mysql_select_db("powerlists",$conn);
                
                $query = "select nombre from Genero;";
                
                $resultado = mysql_query($query, $conn);
    
                while ($genero = mysql_fetch_array($resultado)){
                        echo "<option value='".$genero[0]."'>".$genero[0]."</option>";
                }
                mysql_close($conn);
            ?>
            </select>
        </div>
        <div>Categoria: <input type="text" id="categoriaPlaylist" name="categoriaPlaylist" /></div>
        <div>Tipo: <select id="tipoPlaylist" name="tipoPlaylist"><option value="privada">Privada</option><option value="publica">Publica</option><option value="compartida">Compartida</option></select></div>
        <div>Canciones: <select id="cancionPlaylist" name="cancionPlaylist[]" multiple="multiple" onchange="habilitarRemover();"></select><input id="remover" type="button" value="Remover" onclick="removera();" disabled="disabled" /></div>
        <div><input type="submit" value="Crear" /></div>
    </form>
    <div id="formulario">
        <input id="texto" type="text" name="texto" />
        <input type="button" value="Buscar MP3" onclick="busca();" /><br/><br/>
        <div id="canciones">
        </div>
    </div>
</div>
</body>
</html>