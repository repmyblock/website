<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	// Check that the hash code exist.
	
	if ( ! empty ($_POST)) {
		if ( ! empty ($_POST["password"])) {
			if (password_verify ( $_POST["password"] , $password ) == 1) {
				$r->VerifyAccount($SystemUser_ID);
				$result = $r->FindRawVoterInfoFromSystemID($SystemUser_ID, $DatedFilesID, $DatedFiles);				
												
				if ( ! empty($resultPass["SystemUser_EDAD"])) { 
					preg_match('/(\d\d)(\d\d\d)/', $resultPass["SystemUser_EDAD"], $Keywords);
					$District = sprintf('AD %02d / ED %03d', $Keywords[1], $Keywords[2]);
					$URLToEncrypt .= "&MenuDescription=" . urlencode($District);
				}
				
				if ( empty () { $URLToEncrypt .= "&VerifVoter=1"; }
				if ( $resultPass["SystemUser_emailverified"] == 'no') { $URLToEncrypt .= "&VerifEmail=1"; }
	
				if ($SystemUser_ID > 0 ) {
					print "I am here<BR>";
				
					$VariableToPass = array( 
						"SystemUser_ID" => $SystemUser_ID,
						"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
						"FirstName=" => $resultPass["SystemUser_FirstName"],
						"LastName=" => $resultPass["SystemUser_LastName"]; 
						"VotersIndexes_ID=" => $resultPass["VotersIndexes_ID"],
						"UniqNYSVoterID=" => $resultPass["Raw_Voter_UniqNYSVoterID"],
						"UserParty=" => $resultPass["Raw_Voter_RegParty"]
					);				

					echo "CreateEncoded: " . CreateEncoded($VariableToPass) . "<BR>";
					exit();
					header("Location: /lgd/" . CreateEncoded($VariableToPass, $VariableToRemove) . "/index";
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