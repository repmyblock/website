<?php
//	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	$HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/VendorListCompilation.jpg";
	$HeaderTwitterDesc = "Badge Verification";   
	$HeaderTwitterTitle = "Badge Verification page";   
	
	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGImageWidth = "450";
	$HeaderOGImageHeight = "253";
			
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_display.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
		
	$r = new display();
	$result = $r->findbadgeinfo($_GET["k"]);

	if (empty($result)) {
		echo "<CENTER><P><FONT SIZE=+3 COLOR=RED>The badge doesn't exist</FONT><BR></P></CENTER>";
		
	} else {

?>

<P>
<CENTER>
<P><FONT SIZE=+3 COLOR=GREEN>The badge does exist and is valid</FONT></P>
<P><FONT SIZE=+2><A HREF="https://static.repmyblock.org/authletters/20251104_BOENYC_SDACOPPPAL_AuthorizationLetter.pdf">Download Board of Election Authorization Letter</A></FONT></P>

<P>
<IMG SRC="/<?= $_GET["k"]?>/verif/piccred" style="border: 2px dashed red;" WIDTH=400>
</P>
</CENTER>
</P>

<?php } ?>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
