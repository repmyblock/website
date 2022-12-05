<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	if ( $URIEncryptedString["SystemUser_ID"] > 0) {


		if ( ! empty ($_POST["SaveInfo"])) {
		
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
			
			$r = new login();
	
			// We did not find anything so we are creating it.
			// We need to encrypt the password here.
			
			// Check that the password match.
			if ($_POST["password"] == $_POST["verifypassword"]) {
																
				if (strlen($_POST["password"]) < 8) {
		    	$ErrorMessage = "<FONT COLOR=RED><B>Password too short!<BR>Password must at least 8 characters!</B></FONT>";
		    } /* else if (!preg_match("#[0-9]+#", $_POST["password"])) {
	    		$ErrorMessage = "<FONT COLOR=RED><B>Password must include at least one number!</B></FONT>";
				} else if (!preg_match("#[a-zA-Z]+#", $_POST["password"])) {
		    	$ErrorMessage = "<FONT COLOR=RED><B>Password must include at least one letter!</B></FONT>";
		    }*/ else {
		    	
					$hashtable = hash("md5", PrintRandomText(40));
					$r->UpdateUsernamePassword($URIEncryptedString["SystemUser_ID"], $URIEncryptedString["username"], 
																			$_POST["password"], $URIEncryptedString["hashtable"] );
				
				
	
											
					header("Location: /" . CreateEncoded ( array( 
																					"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																					"RawVoterID" => $URIEncryptedString["RawVoterID"],
																					"DatedFiles" => $URIEncryptedString["DatedFiles"], 
																					"ElectionDistrict" => $URIEncryptedString["ElectionDistrict"],
																					"AssemblyDistrict" => $URIEncryptedString["AssemblyDistrict"], 
																					"FirstName" => $URIEncryptedString["FirstName"],
																					"LastName" => $URIEncryptedString["LastName"],
																		)) . "/lgd/password/forgotpwd_recover_password_done");
					exit();
				}
			} else {
				$ErrorMessage = "The password don't match, please verify that they do.";
			}
			
			

		}
	} else {
		
		// The userid is ZERO and we need to check why.
		// We should never be here so we'll need to send meail to admin.
		
		print "<FONT COLOR=RED><B>THERE IS AN INTERNAL ERROR WITH userid = zero - Nothing you can do, we need to investigate. Try from the beggining.</B></FONT>";
	}

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		

?>
<DIV class="main">
		
	<DIV class="right f80">Forgot Password</DIV>

		<FORM METHOD="POST" ACTION="">	
			<INPUT TYPE="hidden" NAME="login" VALUE="password" CHECKED>	
				
			<?php if (! empty ($ErrorMessage)) { 
				echo "<P class=\"f60\"><FONT COLOR=RED>" . $ErrorMessage . "</FONT></P>";
			} ?>
			
			<P class="f60">
				Choose a password that contains only letters and numbers.
			</P>
			
			<P class="f80">
				<DIV class="f80">Password:</DIV>
				<DIV><INPUT class="" TYPE="password" NAME="password" PLACEHOLDER="password" VALUE=""><DIV>
			</P>
			
			<P class="f80">
				<DIV class="f80">Verify Password:</DIV>
				<DIV><INPUT class="" TYPE="password" NAME="verifypassword" PLACEHOLDER="verify password"  VALUE=""></DIV>
			</P>
		
			<P>
				<DIV><INPUT class="" TYPE="Submit" NAME="SaveInfo" VALUE="Change Password"></DIV>
			</P>

		</FORM>
	
	</DIV>
</DIV>
			
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>