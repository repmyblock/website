<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

		
	// Check that the hash code exist.
	if (! empty ($_GET["k"])) {
		$hashkey = substr( $_GET["k"], 0, 32);  
		$username = substr( $_GET["k"], 32, strlen($_GET["k"]) - 32);
	}
	
	if ( ! empty ($_POST["username"])) { $username = $_POST["username"]; }
	if ( ! empty ($_POST["hashkey"])) {	$hashkey = $_POST["hashkey"]; }

	if ( ! empty ($_POST["username"])) {
		
		$r = new login();
		$result = $r->CheckUsername($_POST["username"]);
		WriteStderr($result, "CheckUsernameInformation " . $_POST["username"]);
		
		if ( ! empty ($result["SystemTemporaryUser_emaillinkid"] )) {
			$TypeTable = "Temp";		
			$SystemHashKey = $result["SystemTemporaryUser_emaillinkid"];
			$PasswordToCheck = $result["SystemTemporaryUser_password"];
			$IDToPass = $result["SystemTemporaryUser_ID"];
			
		} else {
			$TypeTable = "Final";
			$SystemHashKey = $result["SystemUser_emaillinkid"];		
			$PasswordToCheck = $result["SystemUser_password"];
			$IDToPass = $result["SystemUser_ID"];
		}
		
		$VariableToPass = array( 
			"UserID" => $IDToPass,
			"PasswordToCheck" => $PasswordToCheck,
			"TypeTable" => $TypeTable
		);				

		// If Same, we pass to the password check
		if ($_POST["hashkey"] == $SystemHashKey) {
			header("Location: /" . CreateEncoded($VariableToPass, $VariableToRemove) . "/mailchks/verifypassword");
			exit();
		
		} else {
			$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
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
						<INPUT TYPE="Submit" NAME="signin" VALUE="Verify Email">
					</P>
			</FORM>
	</P>

	<P>
		<FONT SIZE=+2><A HREF="/<?= $middleuri ?>/exp/forgot/forgotpwd">I forgot my password</A></FONT><BR>
	</P>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>