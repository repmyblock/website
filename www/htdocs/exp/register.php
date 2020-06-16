<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	if ( ! empty ($_POST["SaveInfo"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
	
		$r = new login();	
		$result = $r->RegisterUser(trim($_POST["username"]), trim($_POST["emailaddress"]), 
																trim($_POST["password"]), "Register");
																
		if ( empty ($result["USERNAME"]) && empty ($result["EMAIL"])) {
		
			require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";			
			SendWelcomeEmail($result["SystemUser_email"], $result["SystemUser_emaillinkid"], 
											$result["SystemUser_username"], $infoarray = ""); 
	
			header("Location: done/?k=" . EncryptURL($URLToEncrypt));
			exit();
	
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

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
?>
<DIV class="main">
		
	<DIV CLASS="right f80">Register</DIV>

	<FORM METHOD="POST" ACTION="">	
		<INPUT TYPE="hidden" NAME="login" VALUE="password" CHECKED>	
			
		<?php
		
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
			<DIV><INPUT CLASS="" type="<?= $TypeEmail ?>" autocorrect="off" autocapitalize="none" NAME="emailaddress" PLACEHOLDER="you@email.net" VALUE="<?= $_POST["emailaddress"] ?>"><DIV>
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
			<DIV><INPUT CLASS="" TYPE="password" NAME="password" PLACEHOLDER="password" VALUE="<?= $_POST["password"] ?>"><DIV>
		</P>
		
		<P CLASS="f80">
			<DIV CLASS="f80">Verify Password:</DIV>
			<DIV><INPUT CLASS="" TYPE="password" NAME="verifypassword" PLACEHOLDER=" verify password"  VALUE="<?= $_POST["password"] ?>"></DIV>
		</P>
	
		<P>
			<DIV><INPUT CLASS="" TYPE="Submit" NAME="SaveInfo" VALUE="Register"></DIV>
		</P>
		
		<P CLASS="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/exp/<?= $middleuri ?>/terms">Terms of Use</A> and 
			<A HREF="/exp/<?= $middleuri ?>/privacy">Privacy Policy.</A>
		</P>

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>