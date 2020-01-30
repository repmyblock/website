<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	
	// Check that the hash code exist.
	if ( ! empty ($_GET["username"])) { $username = $_GET["username"]; }
	if ( ! empty ($_GET["hashkey"])) {	$hashkey = $_GET["hashkey"]; }	
	if ( ! empty ($_POST["username"])) { $username = $_POST["username"]; }
	if ( ! empty ($_POST["hashkey"])) {	$hashkey = $_POST["hashkey"]; }
	

	if ( ! empty ($_POST["username"])) {
		$result = $r->CheckUsername($_POST["username"]);
				
		if ($_POST["hashkey"] == $result["SystemUser_emaillinkid"]) {
			
			$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . 
											"&password=" . $result["SystemUser_password"] .
											"&systemuserid=" . $result["SystemUser_ID"] .
											"&hashkey=" . $_POST["hashkey"] . 
											"&username=" . $_POST["username"];
			// The reason for no else is that the code supposed to go away.

			header("Location: password/?k=" . EncryptURL($URLToEncrypt));
			exit();
		}
						
		$error_msg = "<FONT COLOR=RED><B>The information did not match our records</B></FONT>";	
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
	if ( $MobileDisplay == true ) { $TypeUsername = "username";
	} else { $TypeUsername = "text"; }

?>

<DIV class="main">
	
	<FORM METHOD="POST" ACTION="">
	<INPUT TYPE="hidden" NAME="hashkey" VALUE="<?= $hashkey ?>">	
	
	<DIV CLASS="right f80">Forgot Password</DIV>

	<P CLASS="f60 justify">
		After you type your username you
		will be able to choose a new password.
	</P>
	
	<P CLASS="f80">
		<DIV CLASS="f80">Username:</DIV> 
		<DIV><INPUT CLASS="" type="<?= $TypeUsername ?>" autocorrect="off" autocapitalize="none" NAME="username" PLACEHOLDER="username" VALUE=""><DIV>
	</P>

	<P>
		<INPUT TYPE="Submit" NAME="signin" VALUE="Reset my password">
	</P>
	</FORM>

</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>