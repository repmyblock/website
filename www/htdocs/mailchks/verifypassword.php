<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";

	$r = new login();
	// Check that the hash code exist.
	WriteStderr($_POST, "_POST");
	
	if ( ! empty ($_POST)) {
		if ( ! empty ($_POST["password"])) {
			WriteStderr($URIEncryptedString, "URI Passed: " . $URIEncryptedString["username"]);
			if (password_verify ( $_POST["password"] , $URIEncryptedString["PasswordToCheck"] ) == 1) {
				switch ($URIEncryptedString["TypeTable"]) {
					case "Temp":
						$ret = $r->FindPersonUserTemp($URIEncryptedString["UserID"]);
						if ( $URIEncryptedString["PasswordToCheck"] == $ret["SystemTemporaryUser_password"] ) {				
							WriteStderr($ret, "TEMP Table AFTER PASSWORD CHECK: " . $URIEncryptedString["username"]);
							switch ($ret["SystemTemporaryUser_emailverified"]) { 
								case 'no': $r->UpdateTemporaryEmailVerification($ret["SystemTemporaryUser_ID"], "link"); break;
								case 'reply': $r->UpdateTemporaryEmailVerification($ret["SystemTemporaryUser_ID"], "both"); break;
							}
						}
						$VariableToPass = array( 
							"SystemUser_ID" => "TMP",
							"Password" => $URIEncryptedString["PasswordToCheck"],
							"SystemTemporaryEmail" => $ret["SystemTemporaryUser_email"],
						);
					break;
	
					case "Final":
						$ret = $r->FindPersonUserProfile($URIEncryptedString["UserID"]);
						if ( $URIEncryptedString["PasswordToCheck"] == $ret["SystemUser_password"] ) {				
							WriteStderr($ret, "FINAL Table AFTER PASSWORD CHECK: " . $URIEncryptedString["username"]);
							switch ($ret["SystemUser_emailverified"]) { 
								case 'no': $r->UpdateEmailVerification($ret["SystemUser_ID"], "link"); break;
								case 'reply': $r->UpdateEmailVerification($ret["SystemUser_ID"], "both"); break;
							}
						}			
						$VariableToPass = array( 
							"SystemUser_ID" => $URIEncryptedString["UserID"],
							"Password" => $URIEncryptedString["PasswordToCheck"],
							"SystemTemporaryEmail" => $ret["SystemTemporaryUser_email"],
						);
					break;
				}
				
				
				header("Location: /" . CreateEncoded($VariableToPass, $VariableToRemove) . "/lgd/summary/summary");
				exit();
			}
		}
		$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
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
						Password: 
						<INPUT TYPE="password" NAME="password" placeholder="Password">
					</P>
					
					<P>
						<INPUT TYPE="Submit" NAME="signin" VALUE="Enter your password">
					</P>
			</FORM>
		</P>

	
	<P CLASS="f60">
			<A HREF="/<?= $middleuri ?>/exp/forgot/forgotpwd">I forgot my password</A>
	</P>
	
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>