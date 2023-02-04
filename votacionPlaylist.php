<html>
<head>
</head>
<body>
<div>
<?php
$idPlaylist = $_GET["idPlaylist"];
$cod = $_GET["cod"];
echo "<form action='votarPlaylist.php?idPlaylist=".$idPlaylist."&cod=".$cod."' method='post'>";
?>    
        <div>
            <input type="radio" name="voto" value="1" checked="checked" /> 1
            <input type="radio" name="voto" value="2" /> 2
            <input type="radio" name="voto" value="3" /> 3
            <input type="radio" name="voto" value="4" /> 4
            <input type="radio" name="voto" value="5" /> 5
            <input type="radio" name="voto" value="6" /> 6
            <input type="radio" name="voto" value="7" /> 7
            <input type="radio" name="voto" value="8" /> 8
            <input type="radio" name="voto" value="9" /> 9
            <input type="radio" name="voto" value="10" /> 10
            <div>
                <input type="submit" value="Votar" />
            </div>
        </div>
    </form>
</div>
</body>
</html>