<?php
	include "brandheader.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80 p10">Help put Socialists candidates on the ballot!</DIV>
	
		<P>
			Send Socialist delegates who pledge to vote for Joe Biden to the August Convention.
		</P>
		
		<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/check">Click here to verify your eligibility to pledge
					your signature for the Biden slate at the DNC convention in August 2024.</A>
		</P>
	
		<P>
			<CENTER>
			<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/check"><IMG SRC="/brand/socialist/SocialistsForBidenHarris.jpg"></A>
		</CENTER>
			</P>
				
			<P class="f50">
				Social Democrats of America is looking for Socialists to pledge their signatures to get Joe Biden and a slate of 
				Socialist delegates to Chicago. <B>We'll email you a real petition like this 
				<A HREF="https://pdf.repmyblock.org/UBFZPZ8jrZgA/NY/petition" TARGET="new">sample petition</A></B>.
			</P>
		
		<P>
			<DIV class="videowrapper center">
	 			<iframe src="https://www.youtube.com/embed/cizp2jVf-Yk?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</DIV>
	</P>
		
			
			<?php /*
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/check">Click here to verify your eligibility to run for the 
					New York or Richmond County Committee governance 
					board in June 2023.</A>
			</P>
			*/ ?>

			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/check">Click here to verify your eligibility to run for the 
					Bronx, Queens or Kings <I>(Brooklyn)</I> County Committee governance 
					board in June 2024 or as a Biden delegate for the DNC convention in April 2024.</A>
			</P>
			
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
