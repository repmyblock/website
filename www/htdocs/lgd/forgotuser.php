<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	
	// Check that the hash code exist.

	if ( ! empty ($_GET["email"])) { $email = $_GET["email"]; }
	if ( ! empty ($_GET["hashkey"])) {	$hashkey = $_GET["hashkey"]; }	
	if ( ! empty ($_POST["email"])) { $email = $_POST["email"]; }
	if ( ! empty ($_POST["hashkey"])) {	$hashkey = $_POST["hashkey"]; }
		
	if ( ! empty ($email) && ! empty ($hashkey)) {
		$result = $r->FindFromEmailHashkey($email, $hashkey);
	}
	
	if ( empty ($result)) {
		header("Location: /fwdemail");
		exit();
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>
<div class="row">
	<div class="main">
	<H1>My username is: <?= $result["SystemUser_username"] ?></H1>
	

	<?php if (! empty ($error_msg)) {
		echo "<P>" . $error_msg . "</P>";	
	} ?>

	
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>