<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	$imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80 p10">Help put Socialists candidates on the ballot!</DIV>
	
			<P class="f50">
				Social Democrats of America is looking for Socialists to run for New York and Richmond Counties Committee in 2023.
				It's only a <B>22 hours</B> commitment <FONT COLOR=BROWN><B>PER YEAR</B></FONT>.
			</P>
			
			<P>
				Watch this 26 minutes documentary that explains what it means to be part of the governance of the County Democratic party.
			<B><A HREF="/<?= $middleuri ?>/exp/register/movie">Click here to watch the whole documentary.</A></B>
				<I>(Press the PLAY button and enter the password (all in uppercase) <FONT COLOR=BROWN><B>QCC4ALL</B></FONT> to access the documentary.)</I>
			</P>
			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/socialist/download">Click here to verify your eligibility to run for the 
					New York or Richmond County Committee governance 
					board in June 2023.</A>
			</P>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
