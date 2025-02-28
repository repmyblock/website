<?php
	$HeaderTwitter = "yes";
	$HeaderTwitterTitle = "Rep My Block - Universal Voter Guide";
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/UniversalVoterGuide.jpg";
	$HeaderTwitterDesc = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
	$HeaderOGTitle = "Rep My Block Voter Guide.";
	$HeaderOGDescription = "Rep My Block Voter Guide, the only voter guide that don't restrict the candidate.";
	$HeaderOGImage = "https://static.repmyblock.org/pics/paste/UniversalVoterGuide.jpg"; 
	$HeaderOGImageWidth = "921";
	$HeaderOGImageHeight = "477";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	$IDToClaim = $k;
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }

	$MailToText = "mailto:claim+" . $IDToClaim . "@repmyblock.org?" .
								"subject=" . "I want to claim my profile" . 
								"&body=DO NOT CHANGE THE SUBJECT. Just send the email as is " .
								"for the computer to reply with the link.";			
?>
<DIV class="main">
		
	<P>
		<DIV class="right f80">Public Data Download.</DIV>
	</P>
	
	
	<P class="f60">
		The Rep My Block candidate data is public and shareable without attribution.
	</P>
		
	<P class="f60">
		<B>You can download and republish the data by accessing the shared folder here: 
		<A HREF="https://static.repmyblock.org/shared/share">https://static.repmyblock.org/shared/share</A></B>.
	</P>
	
	<P  class="f60">
		Don't forget to share The County documentary, now streaming on PBS:
		<A HREF="https://www.pbs.org/video/county-kigzrj" TARGET="NEWPBSCONTY">https://www.pbs.org/video/county-kigzrj</A>.
		
	</P>
		
	<P  class="f60">
		Encourage volunteers to get involved by following these steps:
		<A HREF="https://repmyblock.org/web/training/steps/torun">https://repmyblock.org/web/training/steps/torun</A>.
	</P>
	
	<P class="f40">
		By clicking the "Register" button, you are creating a 
		RepMyBlock account, and you agree to RepMyBlock's 
		<A HREF="/<?= $middleuri ?>/policies/terms">Terms of Use</A> and 
		<A HREF="/<?= $middleuri ?>/policies/privacy">Privacy Policy.</A>
	</P>

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>