<?php

	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST["CheckRegistration"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/brand/db_generic.php";	

		header("Location: /" . CreateEncoded (
														array("FirstName" => trim($_POST["FirstName"]),	
																	"LastName" => trim($_POST["LastName"]),
																	"Email" => trim($_POST["Email"]))) .
						"/brand/diaspora/findvoter");
		exit();
	}

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<DIV class="right f80"><?= $BrandingTitle ?></DIV>
	
			
		<P class="f60 p20">
			To prepare the petition, we need to verify your Voter Registration. 
			Please enter the first and last name of the person you want to verify.
		</P>

		<?php if ( ! empty($URIEncryptedString["error_msg"])) { ?>
			<P class="f60">
				<FONT COLOR="BROWN"><B><?= $URIEncryptedString["error_msg"] ?></B></FONT>
			</P>
		<?php } ?>
						

	<FORM METHOD="POST" ACTION="">			
		
		<P class="f80">
			<DIV class="f80">First Name:</DIV> 
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="FirstName" PLACEHOLDER="First Name" VALUE="<?= $_POST["FirstName"] ?>"><DIV>
		</P>
			
		<P class="f80">
			<DIV class="f80">Last Name:</DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="LastName" PLACEHOLDER="Last Name" VALUE="<?= $_POST["LastName"] ?>"></DIV>
		</P>
	
		<P class="f80">
			<DIV class="f80">Email:</DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Email" PLACEHOLDER="Last Name" VALUE="<?= $_POST["Email"] ?>"></DIV>
		</P>
		
		<P>
			<DIV><INPUT class="" TYPE="Submit" NAME="CheckRegistration" VALUE="Check My Voter Registration"></DIV>
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