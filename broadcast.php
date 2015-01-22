<?php
session_start();
header("Content-type : text/xml");
mysql_connect("localhost","root","root");
$db=mysql_select_db("chat-school");

$result=mysql_query("select max(id) from messages");
$row=mysql_fetch_row($result);
$_SESSION["last_id"]=isset($_SESSION["last_id"])?$_SESSION["last_id"]:$row[0];
$last_id=$_SESSION["last_id"];

$result=mysql_query("select * from messages where id>$last_id LIMIT 10");
echo '<xml>';
while($row=mysql_fetch_row($result)){
	echo '<message>';
	echo '<pseudo>'.$row[1].'</pseudo>';
	echo '<content>'.$row[2].'</content>';
	echo '<time>'.$row[3].'</time>';
	echo '</message>';
}
echo '</xml>';
$result=mysql_query("select max(id) from messages");
$row=mysql_fetch_row($result);
$_SESSION["last_id"]=$row[0];
?>