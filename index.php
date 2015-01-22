<?php
session_start();
if(isset($_POST["pseudo"])){
	$pseudo=$_POST["pseudo"];
	$_SESSION["pseudo"]=$pseudo;
	mysql_connect("localhost","root","root");
	$db=mysql_select_db("chat-school");
	mysql_query('insert into chatters(pseudo) values("'.$pseudo.'")');
}else{
	if(!isset($_SESSION["pseudo"])){
		header("location: connect.php");
	}
}
?>

<html>
<head>
	<title>Chat</title>
	<link type="text/css" href="css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="css/style.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="js/myjs.js"></script>
	<script type="text/javascript">
		function sendMessage(e){
			if(e.keyCode==13){
				var content=document.getElementById("msg-input").value;
				document.getElementById("msg-input").value="";
				$.get("insert_message.php?content="+content, function( data ) {
					//$("#sub").html(data);
				});
				
			}
		}

		function updateChat(e){
			$.get("broadcast.php", function( data ) {
				var xml=$(data).find("xml");
				var div="";
				var messages=$(xml).find("message").each(
					function(){
						console.log($(this).find("content").text()+" log");
						var content=$(this).find("content").text();
						var pseudo=$(this).find("pseudo").text();
						var time=$(this).find("time").text();
						div+="<div class='msg alert alert-success'><div class='time pull-right'>"+time+"</div><div class='pseudo'>"+pseudo+"</div><div class='content'>"+content+"</div></div>";
						//console.log(messages[i].find("content")[0].childNodes[0].nodeValue);
					}
				)
				if(div!=""){
					$(div).hide().prependTo("#hist").fadeIn("slow");
					//$("#hist").prepend(div).fadeIn("slow");
				}
			});
		}

		window.chatter_list=[];
		function updateChatters(){
			$.get("update_chatters.php?request=update", function( data ) {
				//console.log(xhr.responseXML);
				var xml=$(data).find("xml")[0];
				var chatters=$(xml).find("pseudo");
				var div="";
				for(var i=0;i<chatters.length;i++){
					if(chatters[i].childNodes[0] != undefined){
						if(window.chatter_list.indexOf(pseudo) == -1){
							var pseudo=$(chatters[i]).text();
							div+="<li class='pseudo_chat label label-primary'><h6>"+pseudo+"</h6></li>";
							//console.log(messages[i].find("content")[0].childNodes[0].nodeValue);
						}
					}
				}
				if(div!=""){
					//$("#chatters").html("");
					$(div).hide().prependTo("#chatters").slideDown("slow");
				}
			});
		}

		function init(){
			document.getElementById("msg-input").onkeypress=sendMessage;
			setInterval(updateChat,3000);
			setInterval(updateChatters,1000);
		}

		function newMessage(message){
			document.getElementById("text-hist").value=document.getElementById("text-hist").value+message
		}

	</script>
</head>
<body onload="init()">
	<a href="logout.php" class="input_msg"><button type="button" class="btn btn-danger">Logout</button></a>
	<div id="content">
		<div class="panel panel-primary">
			<div id="header" class="panel-heading">
				Chatters
			</div>
			<div class="panel-body">
				<ul id="chatters" class="nav nav-pills nav-stacked"></ul>
				<div id="hist" class="well well-sm"></div>
			</div>
			<div class="panel-footer">
				<div class="input-group input-group-sm" id="msg-input2">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			     	<input type="text"  id="msg-input" class="form-control" placeholder="Message here" required autofocus="autofocus">
				   	<span class="input-group-btn">
						<button class="btn btn-success" type="button"><i class="glyphicon glyphicon-comment"></i></button>
					</span>
			    </div>
			</div>
		</div>
	</div>
</body>
</html>