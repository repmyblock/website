<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST["CheckRegistration"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_runwithme.php";	
	
		
	
	
		header("Location: /" . CreateEncoded (
														array("FirstName" => trim($_POST["FirstName"]),	
																	"LastName" => trim($_POST["LastName"]))) .
						"/brand/RunWithMe/findvoter");
		exit();
	}

	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<DIV CLASS="right f80">Download a Paperboy Love Prince Petition</DIV>
	
			
		<P CLASS="f60 p20">
			To prepare the petition, we need to verify your Voter Registration. Please enter your first and last name.
		</P>

		<?php if ( ! empty($error_msg)) { ?>
			<P CLASS="f60">
				<FONT COLOR="BROWN"><B><?= $error_msg ?></B></FONT>
			</P>
		<?php } ?>
						

	<FORM METHOD="POST" ACTION="">			
		
		<P CLASS="f80">
			<DIV CLASS="f80">First Name:</DIV> 
			<DIV><INPUT CLASS="" type="text" autocorrect="off" autocapitalize="none" NAME="FirstName" PLACEHOLDER="First Name" VALUE="<?= $_POST["emailaddress"] ?>"><DIV>
		</P>
			
		<P CLASS="f80">
			<DIV CLASS="f80">Last Name:</DIV>
			<DIV><INPUT CLASS="" type="text" autocorrect="off" autocapitalize="none" NAME="LastName" PLACEHOLDER="Last Name" VALUE="<?= $_POST["username"] ?>"></DIV>
		</P>
		
		<P>
			<DIV><INPUT CLASS="" TYPE="Submit" NAME="CheckRegistration" VALUE="Check My Voter Registration"></DIV>
		</P>
		
		<P CLASS="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/text/terms">Terms of Use</A> and 
			<A HREF="/text/privacy">Privacy Policy.</A>
		</P>

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>