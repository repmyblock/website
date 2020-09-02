<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();

	// Check that the hash code exist.


	if ( ! empty ($_POST)) {
		if ( ! empty ($_POST["username"])) {
			
			
			$hashtable = hash(md5, PrintRandomText(40));
			$r->UpdateUsernameHash($_POST["username"], $hashtable);

			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";	
			$result = $r->CheckUsername($_POST["username"]);

			SendForgotLogin($result["SystemUser_email"],  $hashtable, $result["SystemUser_username"]);
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
		<DIV CLASS="right f80">Forgot Password</DIV>

			<?php 			
			if ($EmptyEmail == true) {
				echo "<P CLASS=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The email address is empty.</FONT></B><BR>";
				echo "</P>";
			}
			?>
		
			<P CLASS="f60 justify">
				We will send you a link to the email address you 
				registered so you can reset your password.
			</P>
		
			<P CLASS="f80">
				<DIV CLASS="f80">Username:</DIV> 
				<DIV><INPUT type="<?= $TypeUsername ?>" autocorrect="off" autocapitalize="none" NAME="username" PLACEHOLDER="username" VALUE="<?= $_POST["username"] ?>"><DIV>
			</P>

			<P>
				<INPUT TYPE="Submit" NAME="signin" VALUE="Reset my password">
			</P>

			<P CLASS="f60 justify">
				If you don't receive a link in the next few hours, send an 
				email to passwordissues@repmyblock.nyc.
			</P>
		</DIV>

	</FORM>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
