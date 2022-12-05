<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";


	$r = new login();

	// Check that the hash code exist.


	if ( ! empty ($_POST)) {
		if ( ! empty ($_POST["username"])) {
			
			
			$hashtable = hash(md5, PrintRandomText(40));
			$r->UpdateUsernameHash($_POST["username"], $hashtable);

			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";	
			$result = $r->CheckUsername($_POST["username"]);
			
			SendForgotLogin($result["SystemUser_email"],  $hashtable);
			header("Location: sentpasswd");
			
			exit();
		} else {
			$EmptyEmail = true;
		}
	}						
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true ) { $TypeUsername = "username";
	} else { $TypeUsername = "text"; }
?>

<div class="main">
	
	<FORM METHOD="POST" ACTION="">
		<DIV class="right f80">Forgot Password</DIV>

			<?php 			
			if ($EmptyEmail == true) {
				echo "<P class=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The email address is empty.</FONT></B><BR>";
				echo "</P>";
			}
			?>
		
			<P class="f40">
				We will send you a link to the email address you 
				registered so you can reset your password.
			</P>
		
			<P class="f80">
				<DIV class="f80">Username:</DIV> 
				<DIV><INPUT type="<?= $TypeUsername ?>" autocorrect="off" autocapitalize="none" NAME="username" PLACEHOLDER="username" VALUE="<?= $_POST["username"] ?>"><DIV>
			</P>

			<P>
				<INPUT TYPE="Submit" NAME="signin" VALUE="Reset my password">
			</P>

			<P class="f40">
				If you don't receive a link in the next few hours, 
				<A HREF="mailto:passwordissues@<?=  $MailFromDomain ?>?subject=Problem with my username&body=Explain the situation here ..."><B>please send an email to  
				passwordissues@<?=  $MailFromDomain ?></B></A>.
								
			</P>
		</DIV>

	</FORM>
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
