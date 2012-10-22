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

<?php
if (isset($_GET['nm'])) {
$nm = stripcslashes($_GET['nm']);
$ps = stripcslashes($_GET['ps']);
}
else { print '<meta http-equiv="REFRESH" content="0;url=http://www.cosmicpolygon.com/exchange/login.php">'; }

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
//start of curl method to get information
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
//end of curl method

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

$gs="$user1&action=balances";
$XMLresponse=askexchange($gs);

$object1=simplexml_load_string ($XMLresponse);
$responsecode=$object1->responsecode;
$balances=$object1->balances;
$bucks=$object1->balances->balance->amount; 

if( $responsecode == "ok" ){
	
}else {
print '<meta http-equiv="REFRESH" content="0;url=http://www.cosmicpolygon.com/exchange/login.php">';	
}
	
?>

</head>
<body id="body" >

<div >
<?php echo $bucks; ?>
	
</body>
</html>