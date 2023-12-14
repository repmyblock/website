<?php
	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST["CheckRegistration"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";

		header("Location: /" . CreateEncoded (
														array("FirstName" => trim($_POST["FirstName"]),	
																	"LastName" => trim($_POST["LastName"]))) .
						"/brand/restorethe4th/findvoter");
		exit();
	}
	
	if ( $URIEncryptedString["SystemQuerySaveID"] > 0 ) {
		$EmailToEmail = "restorethe4th+" . $URIEncryptedString["SystemQuerySaveID"] . "@register.repmyblock.org";
	} else {
		$EmailToEmail = "restorethe4th@register.repmyblock.org";
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<DIV class="right f80">Run Democratic and Republican Presidential Delegates</DIV>
	
			
		<P class="f60 p20">
			Thanks for filling out the registration form. Someone for Save Section 9 will contact 
			you shortly to help get the petition.
		</P>
		
		<P class="f60">
			You can create a username by sending an email to 
			<A HREF="mailto:<?= $EmailToEmail ?>?subject=I want to register&body=DO NOT CHANGE THE SUBJECT. Just send the email as is for the computer to reply with the link." TARGET="emailreg"><B><?=$EmailToEmail ?></B></A>.
		</P>
		
			
			<P class="f50">
				This page is maintained by the New York City <B><A HREF="https://restorethe4th.com" TARGET="RT4">Restore the Fourth</A></B>.
				Check the national website page at <B><A HREF="https://restorethe4th.com/" TARGET="RT4">https://restorethe4th.com/</A>.
			</P>
			
		<P class="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/text/terms">Terms of Use</A> and 
			<A HREF="/text/privacy">Privacy Policy.</A>
		</P>



	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>