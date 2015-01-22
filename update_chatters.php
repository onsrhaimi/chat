<?php
$request=$_GET["request"];
header("Content-type : text/xml");

mysql_connect("localhost","root","root");
$db=mysql_select_db("chat-school");

if($request=="add"){
	$pseudo=$_GET["pseudo"];
	mysql_query('insert into chatters(pseudo) values("'.$pseudo.'")');
}else{
	if($request=="update"){
		$result=mysql_query("select pseudo from chatters");
		echo '<xml>';
		echo '<pseudo>Kamel</pseudo>';
		while($row=mysql_fetch_row($result)){
			echo '<pseudo>'.$row[0].'</pseudo>';
		}
		echo '</xml>';
	}
}
?>