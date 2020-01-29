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

	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 
?>
<div class="row">
	<div class="main">
		<div class="register">
		
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

<P>
	<FORM METHOD="POST" ACTION="">					
		<INPUT TYPE="hidden" NAME="login" VALUE="password" CHECKED>	
		<P CLASS="f80">
			Email: 
			<INPUT type="email" autocorrect="off" autocapitalize="none" NAME="emailaddress" PLACEHOLDER="you@email.net" VALUE="<?= $_POST["emailaddress"] ?>">				
		</P>
			
		<P CLASS="f80">
			Username:
			<INPUT type="username" autocorrect="off" autocapitalize="none" NAME="username" PLACEHOLDER="username" VALUE="<?= $_POST["username"] ?>">
		</P>
		
		<P CLASS="f40">
			Choose a username that contains only letters and numbers, or
			use your email address.
		</P>
		
		<P CLASS="f80">
			Password:
			<INPUT TYPE="password" NAME="password" PLACEHOLDER="password"  VALUE="<?= $_POST["password"] ?>">
		</P>
		
		<P CLASS="f80">
			Verify Password:
			<INPUT TYPE="password" NAME="verifypassword" PLACEHOLDER=" verify password"  VALUE="<?= $_POST["password"] ?>">
		</P>
	
		<P>
			<INPUT TYPE="Submit" NAME="SaveInfo" VALUE="Register">
		</P>
		
		<P CLASS="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/text/terms">Terms of Use</A> and 
			<A HREF="/text/privacy">Privacy Policy.</A>
		</P>

</FORM>
</P>

<?php /*
<P>
			
						<FONT SIZE=+2><A HREF="/login">Login</A></FONT>

					
			<P>
				<A HREF="facebook.php?k=<?= $k ?>" class="btn">facebook</A>
				<A HREF="googleid.php?k=<?= $k ?>" class="btn">googleID</A>
			</P>

*/ ?>			
			
		</DIV>
	</div>
</div>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>