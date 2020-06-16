<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
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
					
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="main">
		
	<FORM METHOD="POST" ACTION="">					
		
		<DIV CLASS="right f80">Forgot Username</DIV>

		<?php 			
		if ($EmptyEmail == true) {
			echo "<P CLASS=\"f60\">";
			echo "<B><FONT COLOR=BROWN>The username field is empty.</FONT></B><BR>";
			echo "</P>";
		}
		?>

		

		<P CLASS="f60 justify">
			We will send you a link to the email address you 
			registered so you can reset your password.
		</P>

	<P CLASS="f80">
		<DIV CLASS="f80">Email:</DIV> 
		<DIV><INPUT CLASS="" type="email" autocorrect="off" autocapitalize="none" NAME="email" PLACEHOLDER="you@email.net" VALUE="<?= $_POST["emailaddress"] ?>"><DIV>
	</P>
			
	<P>
		<INPUT TYPE="Submit" NAME="signin" VALUE="Reset my password">
	</P>
			
		</FORM>
	
	<P CLASS="f60 justify">
		If you don't receive a link in the next few hours, send an 
		email to passwordissues@repmyblock.nyc.
	</P>
	
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
