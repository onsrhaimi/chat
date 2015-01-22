<?php
session_start();
mysql_connect("localhost","root","root");
$db=mysql_select_db("chat-school");
mysql_query('delete from chatters where pseudo="'.$_SESSION["pseudo"].'"');
session_destroy();
header("Location:connect.php");

?>