<?php

	$HeaderTwitter = 1;
	
	switch($_GET["k"]) {
		case "rmbimg":
			$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/draft/FillAOCSurvey.jpg";
			$HeaderTwitterDesc = "This is a grassroots mouvement so we need each person to mobilize in their local Democratic party.";   
			$HeaderTwitterTitle = "Take 5 minutes to fill the survey.";   
			break;
		
		default:
			$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/draft/DraftAOCForPresidentIn2024.jpg";
			$HeaderTwitterDesc = "To save Democracy, Human Rights, and the Planet. The Status Quo will not make the changes we need to win the future we deserve. Bernie started the Political Revolution, We must finish it together. AOC must take the torch and lead the way forward.";   
			$HeaderTwitterTitle = "Draft AOC for President in 2024";   
	}
	
	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGTitle = $HeaderTwitterTitle;
	$HeaderOGImageWidth = "750";
	$HeaderOGImageHeight = "324";
	
	$HeaderTwitterSite = "@draftaoc2024"; 
	$HeaderTwitterCreator = "@draftaoc2024"; 

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	// $imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80 p05">Help Put Socialist Candidates on the Ballot!</DIV>
	
		<h1>Draft AOC for President of the United States</h1>
	
			<P class="f60">
				Social Democrats of America are looking for Socialists 
				to run or help others run as delegates to the Presidential Convention in 2028.
			</P>
			
			<P CLASS="f60">
				We understand everyone is busy, so the time commitment for drafting AOC is 
				kept to a minimum. While AOC has not yet accepted the draft, we have until 
				October 2028 to demonstrate that we&rsquo;ve built a true grassroots campaign.
			</P>
			
			<P CLASS="f60">
				Our goal is also to remove money from the electoral process. This draft campaign 
				is structured around in-kind contributions, where each of us performs simple 
				tasks for the benefit of the collective. These tasks could include picking 
				up a copy of the voter database from the county chair, handing out leaflets 
				on a street corner, designing a logo, or any other action that helps us reach our goal.
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
				include $StatusDirectory . "/draftaoc2024/" . $hour . "-" . $rounded_min . ".html";
				
			?>

			<P class="f40">
			By clicking the "Register" button, you are creating a RepMyBlock account and agreeing to RepMyBlock's
			<A HREF="/text/terms">Terms of Use</A> and 
			<A HREF="/text/privacy">Privacy Policy.</A>
		</P>
			

			<P class="f60">
				Watch this 26-minute documentary to understand what it means to be part of the governance of the County Democratic Party. 
			<B><A HREF="/documentary">Click here to watch the whole documentary.</A></B>
				<I>(Press the PLAY button and enter the password <FONT COLOR=BROWN><B>QCC4ALL</B></FONT> (all in uppercase) to access it.)</I>
			</P>
			
	<P class="f60">
				Rep My Block is provided free of charge to any candidate who wishes to use its services.
				<B>Please note that Draft AOC's content is independent of the Rep My Block tool.</B>
			</P>
			
</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
