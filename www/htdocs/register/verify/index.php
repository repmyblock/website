<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	
	// Check that the hash code exist.

	if ( ! empty ($_GET["username"])) { $username = $_GET["username"]; }
	if ( ! empty ($_GET["hashkey"])) {	$hashkey = $_GET["hashkey"]; }	
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
				header("Location: /register/verify/verifypassword/?k=" . EncryptURL($URLToEncrypt));
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
				header("Location: /register/verify/verifypassword/?k=" . EncryptURL($URLToEncrypt));
				exit();		
		}
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>
<div class="main">
	<H1>Verify the email address</H1>

	<?php if (! empty ($error_msg)) {
		echo "<P>" . $error_msg . "</P>";	
	} ?>

	<P>
		<FORM METHOD="POST" ACTION="">
			<TABLE>
				<TR><TD>Username:</TD><TD><INPUT TYPE="text" NAME="username" VALUE="<?= $username ?>" SIZE=30></TD></TR>
				<TR><TD>HashCode:</TD><TD><INPUT TYPE="text" NAME="hashkey" VALUE="<?= $hashkey ?>" SIZE=60></TD></TR>
				<TR><TD>&nbsp;</TD><TD><INPUT TYPE="Submit" NAME="signin" VALUE="Verify Email"></TD></TR>
			</TABLE>
		</FORM>
	</P>

	<P>
		<FONT SIZE=+2><A HREF="/login/forgotpwd">I forgot my password</A></FONT><BR>
	</P>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>