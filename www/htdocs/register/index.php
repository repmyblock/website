<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	if ( ! empty ($_POST["SaveInfo"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";	
	
		$r = new login();	
		$result = $r->RegisterUser($_POST["username"], $_POST["emailaddress"], $_POST["password"], "Register");
																
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
		echo "<B><FONT COLOR=BROWN>The USERNAME " . $_POST["username"] . " already exist</FONT></B><BR>";
	}
	
	if ($result["EMAIL"] == 1) {
		echo "<B><FONT COLOR=BROWN>The EMAIL " . $_POST["emailaddress"] . " already exist</FONT></B><BR>";
	}
?>

		<P>
				<FORM METHOD="POST" ACTION="">
					
					<INPUT TYPE="hidden" NAME="login" VALUE="password" CHECKED>	
					Email:		
					<INPUT TYPE="text" NAME="emailaddress" PLACEHOLDER="you@email.net" VALUE="<?= $_POST["emailaddress"] ?>">				
					
					<BR>
					
					Username:
					<INPUT TYPE="text" NAME="username" PLACEHOLDER="username" VALUE="<?= $_POST["username"] ?>">				
					Choose a username that contains only letters and numbers, or
					use your email address.
					
					<BR>
					
					Password:
					<INPUT TYPE="text" NAME="password" PLACEHOLDER="password"  VALUE="<?= $_POST["password"] ?>">							
					Your password is secure and you're all set!
					
					<BR>
					<INPUT TYPE="Submit" NAME="SaveInfo" VALUE="Continue">
					<BR>
					By clicking the "Get Started!" button, you are creating a 
					RepMyBlock account, and you agree to RepMyBlock's 
					<A HREF="/text/terms">Terms of Use</A> and 
					<A HREF="/text/privacy">Privacy Policy.</A>
					
					
				</FORM>
			</P>
			
			<P>
			
						<FONT SIZE=+2><A HREF="/login">Login</A></FONT>

					
			<P>
				<A HREF="facebook.php?k=<?= $k ?>" class="btn">facebook</A>
				<A HREF="googleid.php?k=<?= $k ?>" class="btn">googleID</A>
			</P>
		</DIV>
	</div>
</div>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php"; ?>