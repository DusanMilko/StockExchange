<?php
session_start();
if ( $_GET['status'] == "loggedout" ) {
	session_destroy();
}
else{
	if (isset($_SESSION['nm']) ) {
	header("location: profile.php");
	}
	else {}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0" />
<title>The Exchange</title>
<meta name="description" content="dusan milko" />
<meta name="keywords" content="dusan milko" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<link rel="stylesheet" href="http://panicpop.com/css/screen.css" type="text/css" media="screen" />
<link rel="stylesheet" href="global.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://dusanmilko.com/js/jquery-1.7.2.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Alfa+Slab+One' rel='stylesheet' type='text/css'>
</head>
<body id="body" >
	
	<div id="login_cont">
	
	<form id="login" name="login_form" method="post" action="check.php" onsubmit="return ajaxit();"> 
			<h1>The Exchange</h1>
			<div id="result" ></div> 
			<div> 
				<label for="usern">Username</label> 
				<input type="text" name="usern" id="usern" /> 
			</div> 
			<div> 
				<label for="pass">Password</label> 
				<input type="text" name="pass" id="pass" /> 
			</div> 

			<input type="submit" id="send" value="Log In" name="submit" />
	</form> 
	
	</div> 

<script>
$(document).ready(function(){
	$("form label").css("display","block");
	$("form label").stop().animate({"opacity": "1"}, 600);
	//form
	$("form input").focus(function () {
		$(this).siblings("label").stop().animate({"opacity": "0"}, 400);
		$(this).siblings("label").css("display","none");
	});
	$("form input").blur(function() {
		if( $(this).val() == "" ){
	  		$(this).siblings("label").stop().animate({"opacity": "1"}, 400);
	  		$(this).siblings("label").css("display","block");
  		}
	});
	//Ajax
	$.ajaxSetup ({  
        cache: false  
    });  
    var ajax_load = "<img class='hid loader' src='imgs/ajax-loader.gif' alt='loading...' />"; 
	$("#send").click(function(){ 
		if( $("#usern").val()=="" ){
		return false;
		}else{
		var nm = $("#usern").val();
		var ml = $("#pass").val();
    	var loadUrl = "check.php?nm="+nm+"&ps="+ml;
        $("#result").html(ajax_load).load(loadUrl); 
        return false;
    	}
    });
});
</script>
	
</body>
</html>