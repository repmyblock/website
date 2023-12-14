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
				We are a Progressive Grassroot Movement
			</P>
			
			<P class="f50">
				Northern Manhattan Republicans does not directly provide financial support to Republican candidates competing 
				for public office. We reserve the right to endorse a candidate's political 
				committee who we think has the best chances of winning the race, AND will most likely be the best 
				candidate for the people.
			</P>
			
			
			<P class="f50">			
				Together we can empower the unique cluster of communities, protect our families and children from the 
				left anti-family destructive policies. Join this novel grassroot movement to protect our beautiful city!
			</P>
			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/search">Click here to check your registration</A>
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


