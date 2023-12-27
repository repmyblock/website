<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";

	$r = new login();

	if ( ! empty ($_POST["signin"])) {
		
		$hashtable = hash(md5, PrintRandomText(40));
		$r->UpdateHash($_POST["email"], $hashtable);
		$result = $r->CheckEmail($_POST["email"]);
		
		SendForgotUsername($_POST["email"],  $hashtable);
		header("Location: sentusername");
		
		exit();
	}
	
	if (! empty ($_POST["emailaddress"])) {
		$EmailAddress = $_POST["emailaddress"];
	} else {
		$EmailAddress = $URIEncryptedString["Email"];
	}			
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

	<div class="main">
		
		<FORM METHOD="POST" ACTION="">					
			<DIV class="right f80">Forgot Username</DIV>

				<?php 			
				if ($EmptyEmail == true) {
					echo "<P class=\"f60\">";
					echo "<B><FONT COLOR=BROWN>The username field is empty.</FONT></B><BR>";
					echo "</P>";
				}
				?>

				<P class="f40">
					We will send you a link to the email address you 
					registered so you can send your username.
				</P>

				<P class="f80">
					<DIV class="f80">Email:</DIV> 
					<DIV><INPUT type="email" autocorrect="off" autocapitalize="none" NAME="email" PLACEHOLDER="you@email.net" VALUE="<?= $EmailAddress ?>"><DIV>
				</P>
						
				<P>
					<INPUT TYPE="Submit" NAME="signin" VALUE="Locate my username">
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