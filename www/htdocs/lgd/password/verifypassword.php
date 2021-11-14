<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";

	$r = new login();
	// Check that the hash code exist.
	WriteStderr($_POST, "_POST");
	
	
	if ( ! empty ($_POST)) {
		
		if ( ! empty ($_POST["password"])) {
			if (password_verify ( $_POST["password"] , $URIEncryptedString["password"] ) == 1) {
				$r->VerifyAccount($URIEncryptedString["SystemUser_ID"]);
				
				$result = $r->FindRawVoterInfoFromSystemID($URIEncryptedString["SystemUser_ID"], $DatedFilesID, $DatedFiles);				
				WriteStderr($result, "Result FindRawVoterInfoFromSystemID");
				
				if ( ! empty($resultPass["SystemUser_EDAD"])) { 
					preg_match('/(\d\d)(\d\d\d)/', $resultPass["SystemUser_EDAD"], $Keywords);
					$District = sprintf('AD %02d / ED %03d', $Keywords[1], $Keywords[2]);
					$URLToEncrypt .= "&MenuDescription=" . urlencode($District);
				}
					
				if ($URIEncryptedString["SystemUser_ID"] > 0 ) {				
					$VariableToPass = array( 
						"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
						"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
						"FirstName=" => $resultPass["SystemUser_FirstName"],
						"LastName=" => $resultPass["SystemUser_LastName"], 
						"VotersIndexes_ID=" => $resultPass["VotersIndexes_ID"],
						"UniqNYSVoterID=" => $resultPass["Raw_Voter_UniqNYSVoterID"],
						"UserParty=" => $resultPass["Raw_Voter_RegParty"]
					);				

					header("Location: /lgd/" . CreateEncoded($VariableToPass, $VariableToRemove) . "/index");
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
			<A HREF="/exp/<?= $middleuri ?>/forgotpwd">I forgot my password</A>
	</P>
	
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>