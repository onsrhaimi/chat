<?php
session_start();

$pseudo=$_SESSION["pseudo"];
$content=$_GET["content"];
$bdd = new PDO('mysql:host=localhost;dbname=chat-school', 'root', 'root');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query="INSERT INTO messages(pseudo,message,time) VALUES('$pseudo','$content',NOW())";
$result=$bdd->exec($query);

?>