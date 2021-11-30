<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";

	$r = new login();
	// Check that the hash code exist.
	WriteStderr($_POST, "_POST");
	
	
	if ( ! empty ($_POST)) {
		
		if ( ! empty ($_POST["password"])) {
			if (password_verify ( $_POST["password"] , $URIEncryptedString["password"] ) == 1) {
				
				// Move the information from Temp to Master.
				$ret = $r->CheckUsername($URIEncryptedString["username"]);
				WriteStderr($ret, "RET VAR CheckUsername with " . $URIEncryptedString["username"]);
				
				if ( empty ($ret["SystemUser_ID"])) {
					$TypeEmailVerif = "link";
					if ( $ret["SystemTemporaryUser_emailverified"] == "reply") { $TypeEmailVerif = "both"; }
					$ret = $r->MovedSystemUserToMainTable($ret["SystemTemporaryUser_email"], $TypeEmailVerif);
					
					WriteStderr($ret, "RET VAR after MovedSystemUserToMainTable with " . $URIEncryptedString["username"]);
				}
				
				// if Systerm_USER .... 
				
				WriteStderr($ret, "CheckUsername with " . $URIEncryptedString["username"]);
					
				if ($ret["SystemUser_ID"] > 0 ) {				
					$VariableToPass = array( 
						"SystemUser_ID" => $ret["SystemUser_ID"],
						"FirstName=" => $ret["SystemUser_FirstName"],
						"LastName=" => $ret["SystemUser_LastName"], 
						"VotersIndexes_ID=" => $ret["VotersIndexes_ID"],
						"UniqNYSVoterID=" => $ret["Raw_Voter_UniqNYSVoterID"],
						"UserParty=" => $ret["Raw_Voter_RegParty"]
					);				

					header("Location: /" . CreateEncoded($VariableToPass, $VariableToRemove) . "/lgd/summary/summary");
					exit();
				}
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