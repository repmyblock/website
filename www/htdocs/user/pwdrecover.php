<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	
	// Check that the hash code exist.

	$hashkey = $k; 
	if ( ! empty ($_POST["hashkey"])) {	$hashkey = $_POST["hashkey"]; }
	

	if ( ! empty ($_POST["username"])) {
		$result = $r->CheckUsername($_POST["username"]);
				
		if ($_POST["hashkey"] == $result["SystemUser_emaillinkid"]) {
		
			// The reason for no else is that the code supposed to go away.
			header("Location: /" . CreateEncoded ([
														"SystemUser_ID" => $result["SystemUser_ID"],
														"password" => $result["SystemUser_password"],
														"systemuserid" => $result["SystemUser_ID"],
														"hashkey" => $_POST["hashkey"],
														"username" => $_POST["username"],
										 ]) . "/lgd/password/forgotpwd_recover_password");
			exit();
		}
						
		$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true ) { $TypeUsername = "username";
	} else { $TypeUsername = "text"; }

?>

<DIV class="main">
	
	<FORM METHOD="POST" ACTION="">
		<INPUT TYPE="hidden" NAME="hashkey" VALUE="<?= $hashkey ?>">	
		
		<DIV class="right f80">Forgot Password</DIV>

			<P class="f60 justify">
				After you type your username you
				will be able to choose a new password.
			</P>
			        
     	<div class="field">
        <input type="text" id="username" autocorrect="off" class="input" name="username" placeholder=" " required style="max-width: 380px;">
        <label for="username">Username</label>
      </div>
				
      <DIV style="padding-bottom: 15px;">
        <INPUT CLASS="f60bold" TYPE="Submit" NAME="signin" VALUE="Reset my password">
      </DIV>
                  
		</DIV>
		
	</FORM>

</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>