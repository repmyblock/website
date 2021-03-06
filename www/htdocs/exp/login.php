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
		
		
		if ( ! empty ($resultPass)) {			

			// This is a hack to deal with the fact that the database need to be rebuilt.
			// So we need to get the rest in the RawDatabase
			// $ResultRawInfo = $r->FindVotersFromNYSUniq($resultPass["Raw_Voter_UniqNYSVoterID"], $DatedFiles);
			// WriteStderr($ResultRawInfo, "ResultRawInfo");
		
			$VariableToPass = array( 
				"SystemUser_ID" => $resultPass["SystemUser_ID"],
				"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
				"FirstName" => $resultPass["SystemUser_FirstName"],
				"LastName" => $resultPass["SystemUser_LastName"],
				"VotersIndexes_ID" => $resultPass["VotersIndexes_ID"],
				"UniqNYSVoterID" => $resultPass["Raw_Voter_UniqNYSVoterID"],
				"UserParty" => $ResultRawInfo["Raw_Voter_EnrollPolParty"],
				"EDAD" => $resultPass["SystemUser_EDAD"],
				"SystemAdmin" => $resultPass["SystemUser_Priv"]
			);
						
			header("Location: /lgd/" . CreateEncoded($VariableToPass) . "/index");
			
			exit();
		}
						
		$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	
	if ( $MobileDisplay == true ) { $TypeUsername = "username";
	} else { $TypeUsername  = "text"; }
?>

<DIV class="main">
	<DIV CLASS="right f80bold">Login</DIV>

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
			<A HREF="/exp/<?= $middleuri ?>/forgotpwd">I forgot my password</A>
		</P>
		
		<P CLASS="f60">
			<A HREF="/exp/<?= $middleuri ?>/forgotuser">I forgot my username</A>
		</P>
		
		<P CLASS="f60">
			<A HREF="/exp/<?= $middleuri ?>/register">Register</A>
		</P>

	</DIV>
</DIV>
	
	
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>