<?php

	$HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/draft/ReplaceJayJacobs-ByeJay.jpg";
	$HeaderTwitterDesc = "If you are a Manhattan Democratic County Committee, sign the pledge of signing the petition for the New York County Committee joining the Replace Jay Jacobs Coalition.";   
	$HeaderTwitterTitle = "Replace Jay Jacobs - #ByeJay";   
	
	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGTitle = $HeaderTwitterTitle;
	$HeaderOGImageWidth = "708";
	$HeaderOGImageHeight = "757";
	
	$HeaderTwitterSite = "@ReplaceJacobs"; 
	$HeaderTwitterCreator = "@ReplaceJacobs"; 

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	// $imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80 p05">Help gather pledges from Manhattan County Committees!</DIV>
	
		<h1>Draft for the New York County to join the Replace Jay Jacobs coalition</h1>
	
			<P class="f60">
				About 1,700 party delegates and activists are renewing calls for Gov. Hochul to ditch Jacobs as he's set to host a state party meeting this week in Albany. 
			</P>
					
			<P CLASS="f60">
				The goal is to identify 15 County Committees in 6 Assembly District Parts willing to openly sign the petition to 
				put on the floor a vote to Replace Jay Jacobs.
			</P>
	
			<?php 
				$min =  gmdate("i", time());
				$hour =  gmdate("H", time());
				$rounded_min = floor($min/5) * 5;
				if ($rounded_min == 0 ) $rounded_min = "00";
				if ($rounded_min == 5 ) $rounded_min = "05";
				
				if ($rounded_min == 60) {
					$rounded_min = "00"; $hour++;
				  if ($hour == 24) {
				  	$hour = "00";
				  }
				}
				
				echo "\n<!-- Hour: $hour Minute: $rounded_min -->\n";
				include $StatusDirectory . "/replacejayjacobs/" . $hour . "-" . $rounded_min . ".html";
				
			?>

			<P class="f60">
				Watch this 26 minutes documentary that explains what it means to be part of the governance of the County Democratic party.
			<B><A HREF="/<?= $middleuri ?>/exp/register/movie">Click here to watch the whole documentary.</A></B>
				<I>(Press the PLAY button and enter the password (all in uppercase) <FONT COLOR=BROWN><B>QCC4ALL</B></FONT> to access the documentary.)</I>
			</P>
			
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services. <B>Draft AOC's content does not reflect the Rep My Block tool.</B>
			</P>
			
</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
