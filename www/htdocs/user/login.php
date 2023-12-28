<?php
	$BigMenu = "profile";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( ! empty ($_POST["username"])) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
		$r = new login();
		
		### I need to check the username and password.
		$resultPass = $r->CheckUsernamePassword($_POST["username"], $_POST["password"]);
		WriteStderr($resultPass, "ResultPass");
		
		if (! empty($URIEncryptedString["UserName"])) { $PrintUsername = $URIEncryptedString["UserName"]; }
		if (! empty ($_POST["username"])) {	$PrintUsername = $_POST["username"]; }
		
		if ( ! empty ($resultPass)) {			
			// This is a hack to deal with the fact that the database need to be rebuilt.
			// So we need to get the rest in the RawDatabase
			// $ResultRawInfo = $r->FindVotersFromNYSUniq($resultPass["Raw_Voter_UniqNYSVoterID"], $DatedFiles);
			// WriteStderr($ResultRawInfo, "ResultRawInfo");
			
			// Since the person just logged in
			
			$resultPass["SystemUserTemporary_ID"] = (isset ($resultPass["SystemUserTemporary_ID"])) ? $resultPass["SystemUserTemporary_ID"] : NULL;
					
			if ( $resultPass["SystemUserTemporary_ID"] > 0 && empty ($resultPass["SystemUser_ID"])) {
				// This is in case 
								
				$VariableToPass = array( 
					"SystemUser_ID" => "TMP",
					"SystemTemporaryID" => $resultPass["SystemUserTemporary_ID"],
					"SystemTemporaryEmail" => $resultPass["SystemUserTemporary_email"],
					"ProfileCreate" => "yes",
					"SystemUser_Priv" => 1,
			    "EmailLink" => $resultPass["SystemUserTemporary_emaillinkid"],
			    "EmailVerified" => $resultPass["SystemUserTemporary_emailverified"]
				);
				
			} else {
		
				$VariableToPass = array( 
					"SystemUser_ID" => $resultPass["SystemUser_ID"],
					"Raw_Voter_ID" => (isset ($resultPass["Raw_Voter_ID"])) ? $resultPass["Raw_Voter_ID"] : NULL ,
					"FirstName" => $resultPass["SystemUser_FirstName"],
					"LastName" => $resultPass["SystemUser_LastName"],
					"VotersIndexes_ID" => (isset ($resultPass["VotersIndexes_ID"])) ? $resultPass["VotersIndexes_ID"] : NULL ,
					"UniqNYSVoterID" => (isset ($resultPass["Raw_Voter_UniqNYSVoterID"])) ? $resultPass["Raw_Voter_UniqNYSVoterID"] : NULL ,
					"UserParty" => (isset ($ResultRawInfo["Raw_Voter_EnrollPolParty"])) ? $ResultRawInfo["Raw_Voter_EnrollPolParty"] : NULL ,
					"EDAD" => $resultPass["SystemUser_EDAD"],
					"SystemUser_Priv" => $resultPass["SystemUser_Priv"]
				);
			}

			WriteStderr($resultPass, "ResultPass before writing variable.");	
			header("Location: /" . CreateEncoded($VariableToPass) . "/lgd/summary/summary");
			exit();
		}
		
		$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	
	if ( $MobileDisplay == true ) { $TypeUsername = "username";
	} else { $TypeUsername  = "text"; }
?>
<DIV class="main">
	<DIV class="right f80bold">Login</DIV>
	
		<?php if (! empty ($error_msg)) {
			echo "<P class=\"f80\">" . $error_msg . "</P>";	
		} ?>
		
		<P>
			<FORM METHOD="POST" ACTION="">
					<P class="f80">
						Username:
						<INPUT TYPE="<?= $TypeUsername ?>" NAME="username"  autocorrect="off" autocapitalize="none" VALUE="<?= $PrintUsername ?>" placeholder="Username">
					<P>
						
					<P class="f80">
						Password: 
						<INPUT TYPE="password" NAME="password" placeholder="Password">
					</P>
					
					<P>
						<INPUT TYPE="Submit" NAME="signin" VALUE="Log In">
					</P>
			</FORM>
		</P>
		
		<P class="f60">
			<A HREF="/<?= $middleuri ?>/user/forgotpwd">I forgot my password</A>
		</P>
		
		<P class="f60">
			<A HREF="/<?= $middleuri ?>/user/forgotuser">I forgot my username</A>
		</P>
		
		<P class="f60">
			<A HREF="/<?= $middleuri ?>/register/user">Register</A>
		</P>

	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>