<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	switch($k) { 
		case "invalidcode": 
		case "emailreg": 
			$oldk = $k;
			$k = "web";
		case "donotcall":
			$oldk = $k;
		break;
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }

	$MailToText = "mailto:notif@repmyblock.org?" .
								"subject=";
	
	if ( $k != "web") {
		// Check for the team.
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
		$r = new login();
		$result = $r->CheckForValidityOfTeam($k);

		if ( $result["Team_Active"] == "yes")  {
			if ($k == "donotcall") {
				$MailToText .= "Add me to the " . $k;
				$MailURLText = "<FONT COLOR=BLUE>" . $k . "</FONT>";
			
			} else {
				$MailToText .= "I want to register for team " . $k;
				$MailURLText = " FOR TEAM <FONT COLOR=BLUE>" . $k . "</FONT>";
			}
		} else {
			$MailToText .= "I want to register";
		}
	} else {
		$MailToText .= "I want to register";
	}
	
	$MailToText .= "&body=DO NOT CHANGE THE SUBJECT. Just send the email as is for the computer to reply with the link.";
								
	$MultipleMailToText = "mailto:infos@repmyblock.org?" .
												"subject=Multiple users for one account&" .
												"body=Please enable the multipleusers for one account feature.";						
?>
<DIV class="main">
		
	<P>
		<DIV class="right f80">Register</DIV>
	</P>
	
	<?php switch($oldk) { 
		case "donotcall": ?>
		
			
		<P class="f40">	
			In order to use the RepMyBlock website you must register by sending an email
			and following the registration process.
		</P>
		
		<P class="f80">
			<A HREF="<?= $MailToText ?>" TARGET="emailreg">Click on this link to open your mail program or
			send an email to <B>NOTIF@REPMYBLOCK.ORG</B> with the subject "<FONT COLOR=BROWN>ADD ME TO THE <?= $MailURLText ?></FONT>"</A>
			and you will receive a link with the registration information to be added in the Do Not Call List.
		</P>
		
		
		
	<?php break;
		case "invalidcode": ?>
		
		<P class="f80">
			<B><FONT COLOR=brown>The code you were given is invalid.</FONT></B> 
		</P>
		
		
		<P class="f40">	
			In order to use the RepMyBlock website you must register by sending an email
			and following the registration process.
		</P>
		
		<P class="f80">
			<A HREF="<?= $MailToText ?>" TARGET="emailreg">Click on this link to open your mail program or
			send an email to <B>NOTIF@REPMYBLOCK.ORG</B> with the subject "<FONT COLOR=BROWN>I WANT TO REGISTER<?= $MailURLText ?></FONT>"</A>
			and you will receive a link with the registration information.
		</P>
		
	<?php break;
		case "emailreg": ?>
		
		<P class="f80">
			<B><FONT COLOR=brown>That email address is already in our database.</FONT></B> 
		</P>
		
		
		<P class="f40">	
			Use the <A HREF="/<?= $k ?>/exp/forgot/forgotpwd">forgot my password</A> or the 
			<A HREF="/<?= $k ?>/exp/forgot/forgotuser">forgot the username</A> screen to 
			retreive your information.
		</P>
		
		<P class="f40">	
			If two people in the same household use the same email, send us an email 
			at <A HREF="<?= $MultipleMailToText ?>">infos@repmyblock.org</A></B> to enable 
			the <B>multiple users under same email</B> feature.
		</P>
		
	<?php break; 
		default: ?>
	
	<P class="f80">
		<A HREF="<?= $MailToText ?>" TARGET="emailreg">Click on this link to open your mail program or
			send an email to <B>NOTIF@REPMYBLOCK.ORG</B> with the subject "<FONT COLOR=BROWN>I WANT TO REGISTER<?= $MailURLText ?></FONT>"</A>
			and you will receive a link with the registration information.
	</P>
	
	<P class="f40">
		<B>Check your SPAM folder.</B>
	</P>


	<?php break; 
	} ?>
	
	<P class="f40">
		If you made several requests, <A HREF="/<?= $middleuri ?>/user/investigate">click here to alert us 
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