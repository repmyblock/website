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
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_savesection9.php";	

		header("Location: /" . CreateEncoded (
														array("FirstName" => trim($_POST["FirstName"]),	
																	"LastName" => trim($_POST["LastName"]))) .
						"/brand/savesection9/findvoter");
		exit();
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<DIV class="right f80">Run Biden Presidential Delegates</DIV>
	
			
		<P class="f60 p20">
			To prepare the petition, we need to verify your Voter Registration. Please enter your first and last name.
		</P>

		<?php if ( ! empty($error_msg)) { ?>
			<P class="f60">
				<FONT COLOR="BROWN"><B><?= $error_msg ?></B></FONT>
			</P>
		<?php } ?>
						

	<FORM METHOD="POST" ACTION="">			
		
		<P class="f80">
			<DIV class="f80">First Name:</DIV> 
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="FirstName" PLACEHOLDER="First Name" VALUE="<?= $_POST["emailaddress"] ?>"><DIV>
		</P>
			
		<P class="f80">
			<DIV class="f80">Last Name:</DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="LastName" PLACEHOLDER="Last Name" VALUE="<?= $_POST["username"] ?>"></DIV>
		</P>
		
		<P>
			<DIV><INPUT class="" TYPE="Submit" NAME="CheckRegistration" VALUE="Check My Voter Registration"></DIV>
		</P>

		<P class="f50">
				This page is maintained by the <B><A HREF="https://www.baagusa.org" TARGET="BAAG">BANGLADESHI AMERICAN ADVOCACY GROUP (BAAG)</A></B>.
				Check their website at <B><A HREF="https://www.baagusa.org" TARGET="BAAG">https://www.baagusa.org</A>.
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