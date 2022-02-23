<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
	$r = new login();	

	if (! empty($k) && $k != "web") {
		
		preg_match('/ml(.*)/', $k, $matches, PREG_OFFSET_CAPTURE);
		$result = $r->SearchEmailFromIntake($matches[1][0]);

		if ( empty ($result)) {
			header("Location: /invalidcode/exp/register/register");
			exit();		
		}

		$DBInfo = $r->CheckBothSystemUserTable ($result["SystemUserEmail_AddFrom"], "Email");
		if ( ! empty ($DBInfo)) {
			header("Location: /emailreg/exp/register/register");		
		}
		
	} else {
		
		header("Location: /invalidcode/exp/register/register");
		exit();
	}
	
	
	
	
	if ( ! empty ($_POST["SaveInfo"])) {
		
		
		if ( $_POST["password"] != $_POST["verifypassword"]) {
			$result["PASSWORDNOTMATCH"] = 1;

		} else if ( strlen($_POST["password"]) < 8) {
			$result["PASSWORDTOOSHORT"] = 1;
						
		}	else {
		
			// Check who we assign the registered user.
			if (! empty($k) && $k != "web") {	$Refer = $k; }
			
			$res = $r->SearchEmailFromIntake(trim($_POST["SystemUserEmail_ID"]), "ID");
			
			if ( $res["SystemUserEmail_AddFrom"] != $_POST["AddFrom"]) {
				header("Location: /emaildontmatch/exp/register/register");
				exit();
			}
			
			$result = $r->RegisterUser(trim($_POST["username"]), $res["SystemUserEmail_AddFrom"], 
																	trim($_POST["password"]), "Register", $Refer, 
																	$res["SystemUserEmail_MailCode"], "both");
																																	
			if ( empty ($result["USERNAME"]) && empty ($result["EMAIL"])) {
	
				require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";		
				SendWelcomeEmail($result["SystemTemporaryUser_email"], $result["SystemTemporaryUser_emaillinkid"], 
													$result["SystemTemporaryUser_username"], $infoarray = ""); 
	
				$VariableToPass = array( 
					"Email" => $result["SystemTemporaryUser_email"],
					"Username" => $result["SystemTemporaryUser_username"]
				);
	
				header("Location: /" . CreateEncoded($VariableToPass) . "/exp/register/doneregister");
				exit();
	
				if ( ! $result ) {
					$URLToEncrypt = "emailaddress=" . $_POST["emailaddress"];
													
					// The reason for no else is that the code supposed to go away.		
					if ( $_POST["login"] == "password") {
						header("Location:/register/password/?k=" . EncryptURL($URLToEncrypt));
						exit();
					}
					
					if ( $_POST["login"] == "email") {
						header("Location: /register/emaillink/?k=" . EncryptURL($URLToEncrypt));
						exit();
					}
				} else {
					header("Location:/register/sending/?k=" . EncryptURL($URLToEncrypt));
					exit();
				}	
				// If we are here which we should never be we need to send user to problem loop
				exit();
			}
		}
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
?>
<DIV class="main">
		
	<DIV CLASS="right f80">Register</DIV>

	<FORM METHOD="POST" ACTION="">	
		<INPUT TYPE="hidden" NAME="SystemUserEmail_ID" VALUE="<?= $result["SystemUserEmail_ID"] ?>" CHECKED>	
		<INPUT TYPE="hidden" NAME="AddFrom" VALUE="<?= $result["SystemUserEmail_AddFrom"] ?>" CHECKED>	
			
		<?php
		
			if ($result["PASSWORDTOOSHORT"] == 1) {
				echo "<P CLASS=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The password is too short. It need at least 8 characters.</FONT></B><BR>";
				echo "</P>";
			}
		
			if ($result["PASSWORDNOTMATCH"] == 1) {
				echo "<P CLASS=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The password don't match.</FONT></B><BR>";
				echo "</P>";
			}
		
			if ($result["USERNAME"] == 1) {
				echo "<P CLASS=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The USERNAME " . $_POST["username"] . " already exist</FONT></B><BR>";
				echo "</P>";
			}
			
			if ($result["EMAIL"] == 1) {
				echo "<P CLASS=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The EMAIL " . $_POST["emailaddress"] . " already exist</FONT></B><BR>";
				echo "</P>";
			}
		?>
		

	
		<P CLASS="f80">
			<DIV CLASS="f80">Email:</DIV>
			<DIV><?= $result["SystemUserEmail_AddFrom"] ?><DIV>				
		</P>
			
		<P CLASS="f80">
			<DIV CLASS="f80">Username:</DIV>
			<DIV><INPUT CLASS="" type="<?= $TypeUsername ?>" autocorrect="off" autocapitalize="none" NAME="username" PLACEHOLDER="username" VALUE="<?= $_POST["username"] ?>"></DIV>
		</P>
		
		<P CLASS="f40">
			Choose a username that contains only letters and numbers, or
			use your email address.
		</P>
		
		<P CLASS="f80">
			<DIV CLASS="f80">Password:</DIV>
			<DIV><INPUT CLASS="" TYPE="password" NAME="password" PLACEHOLDER="password" VALUE=""><DIV>
		</P>
		
		<P CLASS="f80">
			<DIV CLASS="f80">Verify Password:</DIV>
			<DIV><INPUT CLASS="" TYPE="password" NAME="verifypassword" PLACEHOLDER=" verify password"  VALUE=""></DIV>
		</P>
	
		<P>
			<DIV><INPUT CLASS="" TYPE="Submit" NAME="SaveInfo" VALUE="Register"></DIV>
		</P>
		
		<P CLASS="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/<?= $middleuri ?>/policies/terms">Terms of Use</A> and 
			<A HREF="/<?= $middleuri ?>/policies/privacy">Privacy Policy.</A>
		</P>

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>