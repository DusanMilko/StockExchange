<?php
session_start();
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

	$nm = stripcslashes($_GET['nm']);
	$ps = stripcslashes($_GET['ps']);
	$_SESSION['nm'] = $nm;
	$_SESSION['ps'] = $ps;

	$user1="login=".$nm."&password=".$ps;
	
// action 1: validate a legitimate user
	
	$gs="$user1&action=validateperson";
	$XMLresponse=askexchange($gs);
	print "<div class='response'>".$XMLresponse."</div>";

?>

<script>

	if( $(".response responsecode").text() == "failed" ){
		//alert("fail");
	}else{
		window.location.href = "profile.php";
	}

</script>