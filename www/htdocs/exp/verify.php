<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	
	// Check that the hash code exist.
	if (! empty ($_GET["info"])) {
		$hashkey = substr( $_GET["info"], 0, 32);  
		$username = substr( $_GET["info"], 32, strlen($_GET["info"]) - 32);
	}
	
	if ( ! empty ($_POST["username"])) { $username = $_POST["username"]; }
	if ( ! empty ($_POST["hashkey"])) {	$hashkey = $_POST["hashkey"]; }

	if ( ! empty ($_POST["username"])) {
		$result = $r->CheckUsername($_POST["username"]);
		if ( $result["SystemUser_emailverified"] == "no") {		
			if ($_POST["hashkey"] == $result["SystemUser_emaillinkid"]) {
				
				$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . 
												"&password=" . $result["SystemUser_password"] .
												"&systemuserid=" . $result["SystemUser_ID"] .
												"&hashkey=" . $_POST["hashkey"] . 
												"&username=" . $_POST["username"];
				// The reason for no else is that the code supposed to go away.
				header("Location: /lgd/" .  rawurlencode(EncryptURL($URLToEncrypt)) . "/verifypassword");
				exit();
			} else {
				$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
			}
		} else {
					
					// This is to redirect to another screen in case.
					
					$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . 
												"&password=" . $result["SystemUser_password"] .
												"&systemuserid=" . $result["SystemUser_ID"] .
												"&hashkey=" . $_POST["hashkey"] . 
												"&username=" . $_POST["username"];
				// The reason for no else is that the code supposed to go away.
				header("Location: /lgd/" .  rawurlencode(EncryptURL($URLToEncrypt)) . "/verifypassword");
				exit();		
		}
	}
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>
<div class="main">
	<H1>Verify the email address</H1>

	<?php if (! empty ($error_msg)) {
		echo "<P>" . $error_msg . "</P>";	
	} ?>

	<P>
			<FORM METHOD="POST" ACTION="">
					<P CLASS="f80">
						Username:
						<INPUT TYPE="text" NAME="username" VALUE="<?= $username ?>" placeholder="Username">
					<P>
						
					<P CLASS="f80">
						Hashkey: 
						<INPUT TYPE="text" NAME="hashkey" VALUE="<?= $hashkey ?>" SIZE=60 placeholder="Hashkey">
					</P>
					
					<P>
						<INPUT TYPE="Submit" NAME="signin" VALUE="Log In">
					</P>
			</FORM>
	</P>

	<P>
		<FONT SIZE=+2><A HREF="/exp/<?= $_GET["info"] ?>/forgotpwd">I forgot my password</A></FONT><BR>
	</P>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>