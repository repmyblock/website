<?php
	$middleuri="dberror";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	
	
	// Check the time the last error happened.
?>

<P><BR></P>

<P>
<CENTER>
	<h2>Database Error - Catastrophic problem with the Database</h2>

	<?php if (! empty ($URIEncryptedString["error_msg"])) { ?>
		<H3><FONT COLOR=BROWN><?= $URIEncryptedString["error_msg"] ?></FONT></H3>
	<?php } else { ?>

<P><BR>
	This is a database error. Please check in a few hours.<BR>
	The administrators have been notified.
</P>	
<?php } ?>

</CENTER>
</P>

<P><BR></P>


<?php
	include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; 
?>
