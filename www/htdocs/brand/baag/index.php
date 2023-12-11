<?php

	$HeaderTwitter = "yes";
	$HeaderTwitterTitle = "Rep My Block - Rep My Block";
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/BAAGRepMyBlock.jpg";
	$HeaderTwitterDesc = "Run for County Committee.";
	$HeaderOGTitle = "Run for County Committee.";
	$HeaderOGDescription = "Run for County Committee..";
	$HeaderOGImage = "https://static.repmyblock.org/pics/paste/BAAGRepMyBlock.jpg"; 
	$HeaderOGImageWidth = "921";
	$HeaderOGImageHeight = "575";
	
	$imgtoshow = "/brand/baag/BAAG.png";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80">Run For County Committee</DIV>
	
			<P class="f50">
				The Bangladeshi American Advocacy Group (BAAG) was founded in 2010 by a group of Bangladeshi immigrants with a unique vision to empower the community.
				They recognized the struggle their community faced trying to live the American Dream and wanted to create a voice for the community.
			</P>
			
			<P class="f50">
				The purpose of BAAG is to empower our community, young and old, and push Bangladeshis to become more involved in what is happening in their local, state, and federal governments; to encourage them to demand equal political rights and social justice to raise their quality of life.
			</P>
			
			<P class="f50">
				The purpose of BAAG is to empower our community, young and old, and push Bangladeshis to become more involved in what is happening in their local, state, and federal governments; to encourage them to demand equal political rights and social justice to raise their quality of life.
			</P>
			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/baag/download">Click here to check your registration</A>
			</P>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
			<P class="f50">
				This page is maintained by the <B><A HREF="https://www.baagusa.org" TARGET="BAAG">BANGLADESHI AMERICAN ADVOCACY GROUP (BAAG)</A></B>.
				Check their website at <B><A HREF="https://www.baagusa.org" TARGET="BAAG">https://www.baagusa.org</A>.
			</P>
		
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
