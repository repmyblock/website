<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	
	if ( $SystemUser_ID > 0) {


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
		    } else if (!preg_match("#[0-9]+#", $_POST["password"])) {
	    		$ErrorMessage = "<FONT COLOR=RED><B>Password must include at least one number!</B></FONT>";
				} else if (!preg_match("#[a-zA-Z]+#", $_POST["password"])) {
		    	$ErrorMessage = "<FONT COLOR=RED><B>Password must include at least one letter!</B></FONT>";
		    } else {
		    	
					$hashtable = hash("md5", PrintRandomText(40));
					$r->UpdateUsernamePassword($SystemUser_ID, $username, $_POST["password"], $hashtable );
				
					$URLToEncrypt = "SystemUser_ID=" . $SystemUser_ID . "&RawVoterID=" . $RawVoterID . 
												"&DatedFiles=" . $DatedFiles . 
												"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
												"&FirstName=" . $FirstName . "&LastName=" . $LastName;
	
											
					header("Location: done/?k=" . EncryptURL($URLToEncrypt));
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

	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";		

?>
<DIV class="main">
		
	<DIV CLASS="right f80">Forgot Password</DIV>

	<FORM METHOD="POST" ACTION="">	
		<INPUT TYPE="hidden" NAME="login" VALUE="password" CHECKED>	
			
		<?php if (! empty ($ErrorMessage)) { 
			echo "<P CLASS=\"f60\"><FONT COLOR=RED>" . $ErrorMessage . "</FONT></P>";
		} ?>
		
		<P CLASS="f60">
			Choose a password that contains only letters and numbers.
		</P>
		
		<P CLASS="f80">
			<DIV CLASS="f80">Password:</DIV>
			<DIV><INPUT CLASS="" TYPE="password" NAME="password" PLACEHOLDER="password" VALUE=""><DIV>
		</P>
		
		<P CLASS="f80">
			<DIV CLASS="f80">Verify Password:</DIV>
			<DIV><INPUT CLASS="" TYPE="password" NAME="verifypassword" PLACEHOLDER="verify password"  VALUE=""></DIV>
		</P>
	
		<P>
			<DIV><INPUT CLASS="" TYPE="Submit" NAME="SaveInfo" VALUE="Change Password"></DIV>
		</P>

	</FORM>
</DIV>
			
<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>