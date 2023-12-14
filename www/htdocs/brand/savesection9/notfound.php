<?php
	$HeaderTwitter = "yes";
	$HeaderTwitterTitle = "Save Section 9 - Rep My Block";
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/SaveSection9.jpg";
	$HeaderTwitterDesc = "Save Section 9, Run for Presidential Delegate.";
	$HeaderOGTitle = "Save Section 9, Run for Presidential Delegate.";
	$HeaderOGDescription = "Save Section 9, Run for Presidential Delegate.";
	$HeaderOGImage = "https://static.repmyblock.org/pics/paste/SaveSection9.jpg"; 
	$HeaderOGImageWidth = "960";
	$HeaderOGImageHeight = "541";
	
	$imgtoshow = "/brand/savesection9/SaveSection9.png";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST["CheckRegistration"])) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_savesection9.php";	
		$r = new savesection9();						
	  $IDReturned = $r->SaveContacts("savesection9", $_POST["FirstName"], $_POST["LastName"], 
										  $_POST["Email"], $_POST["Telephone"], NULL);

		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";

		header("Location: /" . CreateEncoded (
															array("SystemQuerySaveID" => $IDReturned),	
														)) .
						"/brand/savesection9/saveinformation");
		exit();
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<DIV class="right f80">Run Biden Presidential Delegates</DIV>
	
			
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
				This page is maintained by the <B><A HREF="https://www.facebook.com/groups/savesection9" TARGET="SS9">Save Section 9</A></B>.
				Check their facebook page at <B><A HREF="https://www.facebook.com/groups/savesection9" TARGET="SS9">https://www.facebook.com/groups/savesection9</A>.
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