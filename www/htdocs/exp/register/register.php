<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
		
	$MailToText = "mailto:notif@repmyblock.org?" . 
								"subject=Send me a Rep My Block registration invite&" . 
								"body=DO CHANGE THE SUBJECT. Just send the email as is for the computer to reply with the link.";
?>
<DIV class="main">
		
	<P>
		<DIV CLASS="right f80">Register</DIV>
	</P>
	
	<P CLASS="f60">
		<A HREF="<?= $MailToText ?>">To register, 
			send an email to <B>NOTIF@REPMBYLOCK.ORG</B> with the subject <I>"Send me a Rep My 
			Block registration invite"</I>
			to receive a link with the registration information.
		</A>
	</P>
	
	<P CLASS="f40">
		The reason we ask that you request a link by emailing <B><A HREF="<?= $MailToText ?>">notif@repmyblock.org</A></B>
		is to combat spam registrations.
	</P>
	
	<P CLASS="f40">
		If you made several requests, <A HREF="/<?= $middleuri ?>/register/investigate">click here to let 
		us know to investigate</A>.
	</P>
	
	<P CLASS="f40">
		By clicking the "Register" button, you are creating a 
		RepMyBlock account, and you agree to RepMyBlock's 
		<A HREF="/<?= $middleuri ?>/policies/terms">Terms of Use</A> and 
		<A HREF="/<?= $middleuri ?>/policies/privacy">Privacy Policy.</A>
	</P>

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>