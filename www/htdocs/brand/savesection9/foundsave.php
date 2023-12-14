<?php
	include "brandheader.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";

	if ( ! empty ($_POST)) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/brand/db_generic.php";	
		$r = new generic();						
	 	$IDReturned = $r->SaveContacts($BrandingName , trim($_POST["FirstName"]), trim($_POST["LastName"]), 
										  			trim($_POST["Email"]), trim($_POST["Telephone"]), trim($_POST["NYSID"]));
	
		header("Location: /" . CreateEncoded (
															array("SystemQuerySaveID" => $IDReturned),	
														) .
						"/brand/" . $BrandingName . "/saveinformation");
		exit();
			
	}
	
	if ( ! empty ($_GET["k"])) {		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
		<DIV class="right f80"><?= $BrandingTitle ?></DIV>
	
			
		<P class="f50">
			Please enter your contact information and we'll contact you shortly about signing the petition for presidential delegates.
		</P>
		
		<INPUT TYPE="hidden" NAME="NYSID" VALUE="<?= $URIEncryptedString["NYSID"] ?>">
		<INPUT TYPE="hidden" NAME="FirstName" VALUE="<?= $URIEncryptedString["FirstName"] ?>">
		<INPUT TYPE="hidden" NAME="LastName" VALUE="<?= $URIEncryptedString["LastName"] ?>">

			
		<P class="f80">
			<DIV class="f80">Email:</DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Email" PLACEHOLDER="Email Address" VALUE=""></DIV>
		</P>
		
			<P class="f80">
			<DIV class="f80">Telephone:</DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Telephone" PLACEHOLDER="Telephone" VALUE=""></DIV>
		</P>
			&nbsp;<BR>

			<DIV>
				<INPUT class="" TYPE="Submit" NAME="checkoneyes" VALUE="Save the information">
			</DIV>
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
