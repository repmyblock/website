<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST["CheckRegistration"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_runwithme.php";	
	
		header("Location: ../findvoter/?k=" . EncryptURL("FirstName=" . trim($_POST["FirstName"]) . "&LastName=" . trim($_POST["LastName"])));
		exit();
	}

	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
		
	<DIV CLASS="right f80">Download a Paperboy Love Prince Petition</DIV>
	
		<P>
			&nbsp;
		</P>
			
		<P>
			To prepare the petition, we need to verify your Voter Registration. Please enter your first and last name.
		</P>

		<P>
			<?php if ( ! empty($error_msg)) { ?>
						
				<FONT COLOR="BROWN"><B><?= $error_msg ?></B></FONT>
			
			<?php } ?>
			
			&nbsp;
		</P>
						

	<FORM METHOD="POST" ACTION="">			
		<?php
		
			if ($result["USERNAME"] == 1) {
				echo "<P CLASS=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The USERNAME " . $_POST["username"] . " already exist</FONT></B><BR>";
				echo "</P>";
			}
			
			if ($result["EMAIL"] == 1) {
				echo "<P CLASS=\"f60\">";
				echo "<B><FONT COLOR=BROWN>The EMAIL " . $_POST["emailaddress"] . " already exist</FONT></B><BR>";
				echo "</P>";
			}
		?>
		
		<P CLASS="f80">
			<DIV CLASS="f80">First Name:</DIV> 
			<DIV><INPUT CLASS="" type="<?= $TypeEmail ?>" autocorrect="off" autocapitalize="none" NAME="FirstName" PLACEHOLDER="First Name" VALUE="<?= $_POST["emailaddress"] ?>"><DIV>
		</P>
			
		<P CLASS="f80">
			<DIV CLASS="f80">Last Name:</DIV>
			<DIV><INPUT CLASS="" type="<?= $TypeUsername ?>" autocorrect="off" autocapitalize="none" NAME="LastName" PLACEHOLDER="Last Name" VALUE="<?= $_POST["username"] ?>"></DIV>
		</P>
		
		<P>
			<DIV><INPUT CLASS="" TYPE="Submit" NAME="CheckRegistration" VALUE="Check Registration"></DIV>
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