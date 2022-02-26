<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";

	$r = new login();
	// Check that the hash code exist.
	
	preg_match('/([a-f0-9]{32})(.*)/i', rawurldecode($k), $matches);
	$hashkey = $matches[1];
	$email = rawurldecode($matches[2]);
		
	if ( ! empty ($email) && ! empty ($hashkey)) {
		$result = $r->FindFromEmailHashkey($email, $hashkey);
	}
	
	
	if ( empty ($result)) {
		header("Location: /" . $middleuri . "/lgd/password/couldnotfind");
		exit();
	}
	 
	header("Location: /" . CreateEncoded ( array( 
														"UserName" => $result["SystemUser_username"],
										 )) . "/lgd/password/printuser");
	exit();
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	
?>
<div class="row">
	<div class="main">
	<H1>My username is: <?= $result["SystemUser_username"] ?></H1>

	<?php if (! empty ($error_msg)) {
		echo "<P>" . $error_msg . "</P>";	
	} ?>

	</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>