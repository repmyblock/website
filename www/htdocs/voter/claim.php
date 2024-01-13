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
		<DIV class="right f80">Claim a candidate profile</DIV>
	</P>
	
	<P CLASS="f80"><FONT COLOR="RED">IMPORTANT!!! PLEASE READ!!!</FONT></P>
	
	<P class="f60">
		We suggest the <B>principal candidate</B> claims the profile using their personal email address. 
		The Rep My Block tool is automated and was built by candidates for ballot access. 
		<B>The guide is an afterthought</B> that responded to popular demand by everyday voters 
		and is a by-product of the ballot access tool.
	</P>
		
	<P class="f60">
		Many candidates who helped build this website have worked on high-profile Democratic and Republican 
		campaigns and understand the intricate drama in campaigns.
	</P>
	
	<P class="f60">
		It's an Open Source project, and we <FONT COLOR="BLACK"><B>DO NOT have the time</B></FONT> 
		to troubleshoot privileged issues because it was beneath the ability of the candidate to type 
		their name, choose a password, and assign the team leadership to their campaign manager.
	</P>
	
	<P class="f60">
		<B>Any legal threat and request</B> will be answered with a standard letter to the court 
		requesting a continuance after the election, rendering the action moot. You can explore the 
		work queue.
	</P>
	
	<P class="f80">
		<U><B>The Voter Guide is for the voter</U>, and your participation will reflect on your campaign.
	</P>
	
	<P CLASS="f60">
		You will be requested to send a picture of you holding a campaign flyer and a piece of ID 
		where we can read the name that matches the information in the voter files/registration 
		authority.
	</P>


	<P class="f80">
		<A HREF="<?= $MailToText ?>" TARGET="claim">Click on this link to open your mail program or send 
		an email to <B>CLAIM+<?= $IDToClaim ?>@REPMYBLOCK.ORG</B> with the subject
		"<FONT COLOR=BROWN>I WANT TO CLAIM MY PROFILE</FONT></A>,"
		and you will receive a link with the registration information.
	</P>

	<P class="f60">
		<B>Check your SPAM folder.</B>
	</P>

	<P class="f40">
		If you made several requests, <A HREF="/<?= $middleuri ?>/register/investigate">click here to alert us 
		and we will investigate</A>.
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