<?php
	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80"><?= $BrandingTitle ?></DIV>
	
			
			<P class="f50">					
				We are America's Oldest Republican Club, Organized since 1875.
			</P>
			
			<P class="f50">
				State and County Committee positions have tremendous influence over shaping the direction of the party and
				over elections and races in New York. Unfortunately, the vast majority of the committee member seats go
				unfilled every election cycle. This leaves strategic decisions made by a few Republican Party insiders and they don't
				always reflect the will or values of voters. It undermines our goal of broad participation in county and state decisionmaking
				and proper representation by its residents.
			</P>
			
			
			<P class="f50">			
				The Queens Village Republican Club (QVRC) envisions	Queens County as being a standard for the American
				spirit and political energy in the Republican	Party. We seek robust Committee representation
				that is inclusive, participatory, and transparent in its actions. We aim to bring the County Committee to
				full-strength so it can be the powerhouse it should be and position us to... <B>"Make New York Great Again!"</B>
			</P>
			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/search">Click here to check your registration</A>
			</P>
			
			<P>
				Our Mission: Through our education and information program, the mission of the Queens Village Republican Club is to
				continue to advance the basic Republican principles of maximum personal freedom and limited government and to 
				elect principled Republicans who uphold our values.
			</P>
			
			<P>
				<A HREF="/brand/<?= $BrandingName ?>/NEW_PATRIOT_BOOKLET_07_10_23.pdf">Download the New Patriot booklete</A></I>
			</P>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
			<P class="f50">
				<?= $BrandingMaintainer ?>
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>


