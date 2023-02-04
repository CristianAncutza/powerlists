<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("powerlists",$conn);

$idNotificacion = $_GET["idNotificacion"];

$query = "delete from Notificacion where id_notificacion = ".$idNotificacion.";";

$resultado = mysql_query($query, $conn);

mysql_close($conn);

header("location:home.php?notificaciones=1");

?>