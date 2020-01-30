<?php
	$BigMenu = "profile";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	if ( ! empty ($_POST["username"])) {
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
		$r = new login();
		
		### I need to check the username and password.
		$resultPass = $r->CheckUsernamePassword($_POST["username"], $_POST["password"]);
		
		if ( ! empty ($resultPass)) {											
			$URLToEncrypt = "SystemUser_ID=" . $resultPass["SystemUser_ID"];
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
			// The reason for no else is that the code supposed to go away.
		}
						
		$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
	
	if ( $MobileDisplay == true ) { $TypeUsername = "username";
	} else { $TypeUsername  = "text"; }
?>

<div class="main">

	<DIV CLASS="right f80">Login</DIV>

	<?php if (! empty ($error_msg)) {
		echo "<P CLASS=\"f80\">" . $error_msg . "</P>";	
	} ?>
	
	<P>
		<FORM METHOD="POST" ACTION="">
				<P CLASS="f80">
					Username:
					<INPUT TYPE="<?= $TypeUsername ?>" NAME="username"  autocorrect="off" autocapitalize="none" VALUE="<?= $_POST["username"] ?>" placeholder="Username">
				<P>
					
				<P CLASS="f80">
					Password: 
					<INPUT TYPE="password" NAME="password" placeholder="Password">
				</P>
				
				<P>
					<INPUT TYPE="Submit" NAME="signin" VALUE="Log In">
				</P>
		</FORM>
	</P>
	

	
	<P CLASS="f60">
		<A HREF="/login/forgotpwd">I forgot my password</A>
	</P>
	
	<P CLASS="f60">
		<A HREF="/login/forgotuser">I forgot my username</A>
	</P>
	
	<P CLASS="f60">
		<A HREF="/register">Register</A>
	</P>
		</DIV>

</DIV>
	
	
<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>