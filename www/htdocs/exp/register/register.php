<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	switch($k) { 
		case "invalidcode": 
		case "emailreg": 
			$oldk = $k;
			$k = "web";
		break;
	}
		
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
		
	$MailToText = "mailto:notif@repmyblock.org?" . 
								"subject=I want to petition&" . 
								"body=DO CHANGE THE SUBJECT. Just send the email as is for the computer to reply with the link.";
								
	$MultipleMailToText = "mailto:infos@repmyblock.org?" . 
								"subject=Multiple users for one account&" . 
								"body=Please enable the multipleusers for one account feature.";							
?>
<DIV class="main">
		
	<P>
		<DIV CLASS="right f80">Register</DIV>
	</P>
	
	<?php switch($oldk) { 
		case "invalidcode": ?>
		
		<P CLASS="f60">
			<B><FONT COLOR=brown>The code you were given is invalid.</FONT></B> 
		</P>
		
		
		<P CLASS="f40">	
			In order to use the RepMyBlock website you must register by sending an email
			and following the registration process.
		</P>
		
	<?php break;
		case "emailreg": ?>
		
		<P CLASS="f60">
			<B><FONT COLOR=brown>That email address is already in our database.</FONT></B> 
		</P>
		
		
		<P CLASS="f40">	
			Use the <A HREF="/<?= $k ?>/exp/forgot/forgotpwd">forgot my password</A> or the 
			<A HREF="/<?= $k ?>/exp/forgot/forgotuser">forgot the username</A> screen to 
			retreive your information.
		</P>
		
		<P CLASS="f40">	
			If two people in the same household use the same email, send us an email 
			at <A HREF="<?= $MultipleMailToText ?>">infos@repmyblock.org</A></B> to enable 
			the <B>multiple users under same email</B> feature.
		</P>
		
	<?php break; 
	} ?>
	

	<P CLASS="f80">
		<A HREF="<?= $MailToText ?>">Please  
			send an email to <B>NOTIF@REPMBYLOCK.ORG</B> with the subject "<FONT COLOR=BROWN>I WANT TO RUN</FONT>"</A>
			and you will receive a link with the registration information.
	</P>
	
	<P CLASS="f40">
		<B>Check your SPAM folder.</B>
	</P>

	
	<P CLASS="f40">
		If you made several requests, <A HREF="/<?= $middleuri ?>/register/investigate">click here to alert us 
		and we will investigate</A>.
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