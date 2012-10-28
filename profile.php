<?php
session_start();
if (isset($_SESSION['nm']) ) {}
else { header("location: login.php"); }
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

<?php
//if (isset($_SESSION['nm']) ) {}
//else { print '<meta http-equiv="REFRESH" content="0;url=http://www.cosmicpolygon.com/exchange/login.php">'; }

//echo $_SESSION['nm'];
$nm = $_SESSION['nm'];
$ps = $_SESSION['ps'];

// This is a 'starter kit' and demonistration for how to
// request information from Moshell's Exchange program.
// You are authorized to use this function and these examples
// as part of your project for DIG4104c, Fall 2012
//

// askexchange ($getstring)
//
//The parameter '$getstring' must
// be formatted as login=xxx&password=yyy&action=zzz&www, where
//
// xxx is a user ID for the exchange system
// yyy is the password associated with that person
// zzz is one of the acceptable action commands (see documentation)
// www is any necessary information for that action command
//
function askexchange($getstring)
{
	//$targetURL="localhost:8888/startup/exchange.php"; // used during development
	
	//use this URL during the testing of your Exchange front-end
	$targetURL="https://regmaster3.com/startup/exchangetest.php";
	
	//use this URL during actual operation of your Exchange front-end
	//$targetURL=""https://regmaster3.com/startup/exchange.php";
		
	// You have to urlencode so that blank spaces (e. g. in note or double names) doesn't
	// break up the GET communication
	
    $combinedURL="$targetURL?$getstring";
    $ch = curl_init();
    // set url
    if (!curl_setopt($ch, CURLOPT_URL, $combinedURL))
		print "fail 1 with url=$combinedurl";

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $outputobject = curl_exec($ch); 
	return $outputobject;
} // end askexchange

#logprint:
///logprint: The basic diagnostic tool
function logprint($saywhat,$selector=0,$trace=0,$arrayin=0)
{ global $Testactive, $Testnumber;

	static $counter;
	if (!$Testactive) return;
	
//$Form['templogprint'].="LP: selector=$selector, state=".$State['testnumber']."<br />";
//if (($selector<0 && $State['testnumber']!=0) || ($selector==$State['testnumber']) )
if (($selector==$Testnumber) ||($selector<0))
	{ 
		list($micro,$sec)=explode(" ",microtime());
		
		if ($Param['logprint.microtime'])
			$dtstamp=date('H:i:s:').$micro.':--';
		else
			$dtstamp=date('H:i:s--').'--';

		$stack=debug_backtrace();
		$caller=$stack[1]['function'];
		
		if ($trace)
			$tracedata=logtrace($stack);
			
		//if ($Param['testprint']>0)
		if ($trace)
				$head="LPT: from $caller #$counter#:".$dtstamp."<br />";
			else
				$head="LP from $caller #$counter#:".$dtstamp."<br />";
		$counter++;
		if ($trace==0) $trace='';
		
		if ($arrayin)
		{
			$struc= "<br />**** STRUCTURE *********************************<br />";
			$struc .=print_r ($arrayin,TRUE);
			$struc.="<br />===========================================<br />";
		}
		$workstring=$head.$saywhat.$tracedata.$struc."<br />";
		print $workstring;
		
	}
} # End logprint

//Start page info

$user1="login=".$nm."&password=".$ps;

//balances
$gs="$user1&action=balances";
$XMLresponse=askexchange($gs);
$object1=simplexml_load_string ($XMLresponse);
$responsecode=$object1->responsecode;
$balances=$object1->balances;
$bucks=$object1->balances->balance->amount; 

//transaction history
$th="$user1&action=transactions";
$XMLresponseTH=askexchange($th);
$object2=simplexml_load_string ($XMLresponseTH);
$responsecode=$object2->responsecode;
$tx=$object2->transactions;

if( $responsecode == "ok" ){
	
}else {
//print '<meta http-equiv="REFRESH" content="0;url=http://www.cosmicpolygon.com/exchange/login.php">';	
}
	
?>

</head>
<body id="body" >
<div class="main_body">
	
	<div class="tabn">
		
		<div class="nav">
			<a class="home active" href=""><img src="imgs/hm.png" /></a>
			<a class="history" href=""><img src="imgs/hs.png" /></a>
			<a class="transfer" href=""><img src="imgs/tf.png" /></a>
			<a class="logout" href="login.php?status=loggedout"><img src="imgs/out.png" /></a>
		</div>
		<div class="th_main">
			<?php echo $XMLresponseTH;?>
		</div>
		<div class="tf_main">
			<h4>Transfer</h4>
		</div>
	</div>
	<div class="main_profile">
		<h1>The Exchange</h1>
		<div class="bal">Balance: <?php echo $bucks; ?></div>
	</div>
</div>

<script>
$(document).ready(function(){
	var tabw = $(".tabn").width();
	$(".th_main").css("height", "0px");
	$(".main_profile").css("width",tabw-70);
	$(".th_main").css("width",tabw-70);
	$(".tabn").css("margin-left",(tabw-50)*-1);
	//$(".tabn").css("height",$(window).height());
	$(".nav").css("height",$(window).height());
});
$(window).resize(function() {
	var tabw = $(".tabn").width();
	//$(".th_main").css("height", "0px");
	$(".main_profile").css("width",tabw-72);
	$(".th_main").css("width",tabw-70);
	//$(".tabn").css("height",$(window).height());
	if( $(".history").hasClass("active") ){
		$(".nav").css("height",($(".th_main").height()+25));
	}else{
		$(".nav").css("height",$(window).height());
	}
	if( $(".home").hasClass("active") ){
		$(".main_profile").stop().animate({"margin-right": "0px"}, "slow");
		$(".tabn").css("margin-left",(tabw-50)*-1);
	}
});
$(".home").click(function() {
	var tabw = $(".tabn").width();
	$(".nav").css("height",$(window).height());
	$(".th_main").css("height", "0px");
	$('.nav a').removeClass("active");
	$(this).addClass("active");
	$(".tabn").stop().animate({"margin-left": (tabw-50)*-1}, "slow");
	$(".main_profile").stop().animate({"margin-right": "0px"}, "slow");
	return false;
});
$(".history").click(function() {
	var tabw = $(".tabn").width();
	$('.nav a').removeClass("active");
	$(this).addClass("active");
	$(".th_main").css("height", "100%");
	$(".tf_main").css("height", "0px");
	$(".main_profile").stop().animate({"margin-right": tabw*-1}, "slow");
	$(".tabn").stop().animate({"margin-left": "0px"}, "slow");
	$(".nav").css("height",$(".th_main").height()+25);
	return false;
});
$(".transfer").click(function() {
	var tabw = $(".tabn").width();
	$(".nav").css("height",$(window).height());
	$(".th_main").css("height", "0px");
	//$(".th_main").css("overflow", "hidden");
	$('.nav a').removeClass("active");
	$(this).addClass("active");
	$(".main_profile").stop().animate({"margin-right": tabw*-1}, "slow");
	$(".tabn").stop().animate({"margin-left": "0px"}, "slow");
	return false;
});
</script>
	
</body>
</html>