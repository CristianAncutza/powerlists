<?php session_start();?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/estilos_creacionpl.css"/>
	<title id="title">Bienvenido a PowerLists</title>
</head>
<body>

<div id="header">
<a id="homelink" href="home.php"><img src="img/pl_logo2.png" id="logo" alt="powerlist"/></a> 
<span id="title">El sitio web de intercambio de playlists!</span>
</div>

<div id="container_left">
<div id="user_title">
		<h1>Seccion de carga de MP3</h1>
	</div>
<hr/>	
<form action="cargarCancion.php" method="post" enctype="multipart/form-data">
<input type="file" name="file" /><br/>
<input type="submit" value="Subir MP3 +" /><br/>
<?php
$error = isset($_GET["error"]) ? $_GET["error"] : "";

switch ($error){
    case 1: echo "<p style='color: green;'>MP3 cargado con éxito!</p>";break;
    case 2: echo "<p style='color: red;'>Se produjo un error en la subida</p>";break;
    case 3: echo "<p style='color: red;'>Ya existe un MP3 con el mismo titulo</p>";break;
}
?>
</form>
</div>
</body>
</html>