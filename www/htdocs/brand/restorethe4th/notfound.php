<?php
	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST["CheckRegistration"])) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/brand/db_baag.php";	
		$r = new baag();					
	  $IDReturned = $r->SaveContacts($BrandingName, trim($_POST["FirstName"]), trim($_POST["LastName"]), 
										  trim($_POST["Email"]), trim($_POST["Telephone"]), NULL);

		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";

		header("Location: /" . CreateEncoded (
															array("SystemQuerySaveID" => $IDReturned),	
														) .
						"/brand/" . $BrandingName . "/saveinformation");
		exit();
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<DIV class="right f80"><?= $BrandingTitle ?></DIV>
	
	<P class="f60 p20">
		We did not find your voter registration card in the system. Please enter your contact information and 
		someone will contact you shortly.
	</P>
							

	<FORM METHOD="POST" ACTION="">			
		
		<P class="f80">
			<DIV class="f80">First Name:</DIV> 
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="FirstName" PLACEHOLDER="First Name" VALUE="<?= $URIEncryptedString["FirstName"] ?>"><DIV>
		</P>
			
		<P class="f80">
			<DIV class="f80">Last Name:</DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="LastName" PLACEHOLDER="Last Name" VALUE="<?= $URIEncryptedString["LastName"] ?>"></DIV>
		</P>
		
		<P class="f80">
			<DIV class="f80">Email:</DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Email" PLACEHOLDER="Email Address" VALUE=""></DIV>
		</P>
		
		<P class="f80">
			<DIV class="f80">Telephone:</DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Telephone" PLACEHOLDER="Telephone" VALUE=""></DIV>
		</P>
		
		<P>
			<DIV><INPUT class="" TYPE="Submit" NAME="CheckRegistration" VALUE="Save My Information"></DIV>
		</P>

			<P class="f50">
				<?= $BrandingMaintainer ?>
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