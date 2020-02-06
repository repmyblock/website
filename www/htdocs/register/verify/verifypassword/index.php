<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	// Check that the hash code exist.
	
	if ( ! empty ($_POST)) {
		if ( ! empty ($_POST["password"])) {
			
			$time_pre = microtime(true);
			if (password_verify ( $_POST["password"] , $password ) == 1) {
			$time_post = microtime(true);
			print "Password Verify: " . ($time_post - $time_pre) . "<BR>\n";
					
				$time_pre = microtime(true);
				$r->VerifyAccount($SystemUser_ID);
				$time_post = microtime(true);
				print "VerifyAccount: " . ($time_post - $time_pre) . "<BR>\n";
				$result = $r->FindRawVoterInfoFromSystemID($SystemUser_ID, $DatedFilesID, $DatedFiles);				
				$time_pre = microtime(true);
				print "FindRawVoterInfoFromSystemID:" . ($time_pre - $time_post) . "<BR>\n";
				
									
				if ($SystemUser_ID > 0 ) {
					//$resultCandidate = $r->FindCandidateInfo($SystemUser_ID);		
					
					$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID;
					if ( empty ($resultPass["Raw_Voter_ID"])) { $URLToEncrypt .= "&VerifVoter=1"; }
					if ( $resultPass["SystemUser_emailverified"] == 'no') { $URLToEncrypt .= "&VerifEmail=1"; }
					if ( ! empty($resultPass["SystemUser_FirstName"])) { $URLToEncrypt .= "&FirstName=" . $resultPass["SystemUser_FirstName"]; }
					if ( ! empty($resultPass["SystemUser_LastName"])) { $URLToEncrypt .= "&LastName=" . $resultPass["SystemUser_LastName"]; }
					if ( ! empty($resultPass["VotersIndexes_ID"])) { $URLToEncrypt .= "&VotersIndexes_ID=" . $resultPass["VotersIndexes_ID"]; }
					if ( ! empty($resultPass["Raw_Voter_UniqNYSVoterID"])) { $URLToEncrypt .= "&UniqNYSVoterID=" . $resultPass["Raw_Voter_UniqNYSVoterID"]; }
					if ( ! empty($resultPass["Raw_Voter_RegParty"])) { $URLToEncrypt .= "&UserParty=" . $resultPass["Raw_Voter_RegParty"]; }
					if ( ! empty($resultPass["SystemUser_EDAD"])) { 
						preg_match('/(\d\d)(\d\d\d)/', $resultPass["SystemUser_EDAD"], $Keywords);
						$District = sprintf('AD %02d / ED %03d', $Keywords[1], $Keywords[2]);
						$URLToEncrypt .= "&MenuDescription=" . urlencode($District);
					}
									
					header("Location: /lgd/?k=" . EncryptURL($URLToEncrypt));
					exit();
				}
			}
		}
		$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
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
				<TR><TD>Password:</TD><TD><INPUT TYPE="password" NAME="password" VALUE="" SIZE=30></TD></TR>
				<TR><TD>&nbsp;</TD><TD><INPUT TYPE="Submit" NAME="signin" VALUE="Enter your password"></TD></TR>
			</TABLE>
		</FORM>
	</P>
	
	<P>
		<FONT SIZE=+2><A HREF="/login/forgotpwd">I forgot my password</A></FONT><BR>
	</P>
	
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>