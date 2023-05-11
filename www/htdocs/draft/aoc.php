<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	// $imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80 p05">Help put Socialists candidates on the ballot!</DIV>
	
		<h1>Draft AOC</h1>
	
			<P class="f50">
				Social Democrats of America is looking for Socialists to run or help other run for delegate to the Presidential 
				Convention in Chicago in 2024.
			</P>
			
			<P CLASS="f50">
				We know everyone is busy so the time commitment for drafting AOC is kept to a minimum. At this time AOC has not
				accepted the draft but we have about October 2024 to show we have reach a real grassroots campaign.
			</P>

			<H1>Statement of needs</H1>	
		
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
			<P>
		
			<P>
				Watch this 26 minutes documentary that explains what it means to be part of the governance of the County Democratic party.
			<B><A HREF="/<?= $middleuri ?>/exp/register/movie">Click here to watch the whole documentary.</A></B>
				<I>(Press the PLAY button and enter the password (all in uppercase) <FONT COLOR=BROWN><B>QCC4ALL</B></FONT> to access the documentary.)</I>
			</P>
			
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
