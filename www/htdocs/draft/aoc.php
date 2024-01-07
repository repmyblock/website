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
	<DIV class="right f80 p05">Help put Socialists candidates on the ballot!</DIV>
	
		<h1>Draft AOC for President of the United States</h1>
	
			<P class="f60">
				Social Democrats of America is looking for Socialists to run or help other run for delegate to the Presidential 
				Convention in Chicago in 2024.
			</P>
			
			<P CLASS="f60">
				We know everyone is busy so the time commitment for drafting AOC is kept to a minimum. At this time AOC has not
				accepted the draft but we have about October 2024 to show we have reach a real grassroots campaign.
			</P>
			
			<P CLASS="f60">
				The goal is also to remove money from the electoral process so the way this draft campaign is setup is by collecting
				in kind donations where each one of us perform easy tasks for the benefit of all. It could be from going to the county
				chair and picking up a copy of the voter database, standing at a corner passing leftlets, drawing a logo, or anything
				you feel will achieve the goal.
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

			<P class="f60">
				Watch this 26 minutes documentary that explains what it means to be part of the governance of the County Democratic party.
			<B><A HREF="/<?= $middleuri ?>/register/movie">Click here to watch the whole documentary.</A></B>
				<I>(Press the PLAY button and enter the password (all in uppercase) <FONT COLOR=BROWN><B>QCC4ALL</B></FONT> to access the documentary.)</I>
			</P>
			
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services. <B>Draft AOC's content does not reflect the Rep My Block tool.</B>
			</P>
			
</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
