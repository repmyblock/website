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

	if ( ! empty ($_POST)) {
		if ($_POST["checkoneyes"] == "Prepare the petition") {
						
			$Counter = 0;
			foreach ($_POST["NYSID"] as $index => $NYSID) {
				if ( ! empty($NYSID)) {
					print "Found : $index => $NYSID<BR>";
					$StringURL .= "NYSID[" . $Counter . "]=$NYSID&Witness[" . $Counter . "]=" . $_POST["Witness"][$index] . "&";
					$Counter++;
				}
			}
			
			header("Location: /" . CreateEncoded (
														array("FirstName" => trim($_POST["FirstName"]),	
																	"LastName" => trim($_POST["LastName"]),
																	"UniqID" => trim($_POST["NYSID"])
																	
																	)) .
																	
														"/brand/RunWithMe/saveinformation");
			exit();
			
		}
		exit();
	}
	
	if ( ! empty ($_GET["k"])) {		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_savesection9.php";	
					
		$r = new savesection9();	
		$result = $r->FindNeibors($URIEncryptedString["NYSID"]);
		WriteStderr($URIEncryptedString["NYSID"], "Neighbors ... ");
		
		/*												
		if ( empty ($result)) {
			$error_msg = "Could not find the voter. Check the name.";
			header("Location: ../download/?k=" . EncryptURL("error_msg=" . $error_msg));
			exit();
		}
		*/
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<FORM METHOD="POST" ACTION="">		
		<DIV class="right f80">Run Biden Presidential Delegates</DIV>
	
			
		<P class="f50">
			Please enter your contact information and we'll contact you shortly about signing the petition for presidential delegates.
		</P>
		
		<INPUT TYPE="hidden" NAME="NYSID" VALUE="<?= $URIEncryptedString["NYSID"] ?>">

			
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