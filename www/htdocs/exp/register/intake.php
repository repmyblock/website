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
			$retreguser["PASSWORDNOTMATCH"] = 1;

		} else if ( strlen($_POST["password"]) < 8) {
			$retreguser["PASSWORDTOOSHORT"] = 1;
						
		}	else {
		
			// Check who we assign the registered user.
			if (! empty($k) && $k != "web") {	$Refer = $k; }
			
			$res = $r->SearchEmailFromIntake(trim($_POST["SystemUserEmail_ID"]), "ID");
			
			if ( $res["SystemUserEmail_AddFrom"] != $_POST["AddFrom"]) {
				header("Location: /emaildontmatch/exp/register/register");
				exit();
			}
			
			$retreguser = $r->RegisterUser(trim($_POST["username"]), $res["SystemUserEmail_AddFrom"], 
																	trim($_POST["password"]), "Register", $res["SystemUserEmail_WebCode"], 
																	$res["SystemUserEmail_MailCode"], "both");
																	
			WriteStderr($retreguser , "RegisterUser");
																	
																											
			if ( empty ($retreguser["USERNAME"]) && empty ($retreguser["EMAIL"])) {
	
				require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";		
				SendWelcomeEmail($retreguser["SystemTemporaryUser_email"], $retreguser["SystemTemporaryUser_emaillinkid"], 
													$retreguser["SystemTemporaryUser_username"], $infoarray = ""); 
	
				$VariableToPass = array( 
					"Email" => $retreguser["SystemTemporaryUser_email"],
					"Username" => $retreguser["SystemTemporaryUser_username"]
				);
	
				header("Location: /" . CreateEncoded($VariableToPass) . "/exp/register/doneregister");
				exit();
	
				if ( ! $retreguser ) {
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
		
	<DIV class="right f80">Register</DIV>
	
	<?php if ( ! empty($result["SystemUserEmail_WebCode"])) { ?>
		<P class="f40">
		You are joining <B><?= $result["Team_Name"] ?></B> team. <BR>
		<?php if ( ! empty ($result["SystemUser_ID"])) { ?>
			RepMyBlock will be sharing your 
			information with the group team leader, <B><?= $result["SystemUser_FirstName"] . " " . $result["SystemUser_LastName"] ?></B>.
	<?php } ?>
	</P>
	<?php } ?>
	
	<FORM METHOD="POST" ACTION="">	
		<INPUT TYPE="hidden" NAME="SystemUserEmail_ID" VALUE="<?= $result["SystemUserEmail_ID"] ?>" CHECKED>	
		<INPUT TYPE="hidden" NAME="AddFrom" VALUE="<?= $result["SystemUserEmail_AddFrom"] ?>" CHECKED>	
		<?php if ( ! empty ($result["SystemUserEmail_WebCode"])) { ?>
		<INPUT TYPE="hidden" NAME="TeamWebCode" VALUE="<?= $result["SystemUserEmail_WebCode"] ?>" CHECKED>	
		<INPUT TYPE="hidden" NAME="TeamWebCodeID" VALUE="<?= $result["Team_ID"] ?>" CHECKED>	
		<?php } ?>
	
		<?php
		
			if ($retreguser["PASSWORDTOOSHORT"] == 1) {
				echo "<P class=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The password is too short. It need at least 8 characters.</FONT></B><BR>";
				echo "</P>";
			}
		
			if ($retreguser["PASSWORDNOTMATCH"] == 1) {
				echo "<P class=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The password don't match.</FONT></B><BR>";
				echo "</P>";
			}
		
			if ($retreguser["USERNAME"] == 1) {
				echo "<P class=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The USERNAME " . $_POST["username"] . " already exist</FONT></B><BR>";
				echo "</P>";
			}
			
			if ($retreguser["EMAIL"] == 1) {
				echo "<P class=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The EMAIL " . $_POST["emailaddress"] . " already exist</FONT></B><BR>";
				echo "</P>";
			}
		?>
		
		<P class="f80">
			<DIV class="f80">Email:</DIV>
			<DIV class="f60"><?= $result["SystemUserEmail_AddFrom"] ?><DIV>				
		</P>
			
		<P class="f80">
			<DIV class="f80">Username:</DIV>
			<DIV><INPUT class="" type="<?= $TypeUsername ?>" autocorrect="off" autocapitalize="none" NAME="username" PLACEHOLDER="username" VALUE="<?= $_POST["username"] ?>"></DIV>
		</P>
		
		<P class="f40">
			Choose a username that contains only letters and numbers, or
			use your email address.
		</P>
		
		<P class="f80">
			<DIV class="f80">Password:</DIV>
			<DIV><INPUT class="" TYPE="password" NAME="password" PLACEHOLDER="password" VALUE=""><DIV>
		</P>
		
		<P class="f80">
			<DIV class="f80">Verify Password:</DIV>
			<DIV><INPUT class="" TYPE="password" NAME="verifypassword" PLACEHOLDER=" verify password"  VALUE=""></DIV>
		</P>
	
		<P>
			<DIV><INPUT class="" TYPE="Submit" NAME="SaveInfo" VALUE="Register"></DIV>
		</P>
		
		<P class="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/<?= $middleuri ?>/policies/terms">Terms of Use</A> and 
			<A HREF="/<?= $middleuri ?>/policies/privacy">Privacy Policy.</A>
		</P>

	</FORM>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>