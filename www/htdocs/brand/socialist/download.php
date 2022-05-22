<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST["CheckRegistration"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_runwithme.php";	
	
		
	
	
		header("Location: /" . CreateEncoded (
														array("FirstName" => trim($_POST["FirstName"]),	
																	"LastName" => trim($_POST["LastName"]))) .
						"/brand/socialist/findvoter");
		exit();
	}

	$imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<DIV CLASS="right f80">Download an Social Democrat of America Petition</DIV>
	
			
		<P CLASS="f60 p20">
			To prepare the petition, we need to verify your Voter Registration. Please enter your first and last name.
		<BR><BR>
			Because of the fast moving pace of the petition period, we created a WhatsApp and Telegram group to notify 
			of changes in the data. <B>This is a very low notification group <I>(a message every two days around 7:30 pm New York Time)</I>.</B> 
			We'll send updates on the availability of the petitions and how to give them to the various SDA comrades.<BR>
			<I>
				WhatsApp: <A TARGET="NewWhat" HREF="https://chat.whatsapp.com/EDKNVkzhlEyI9qvUXqu5S8">https://chat.whatsapp.com/EDKNVkzhlEyI9qvUXqu5S8</A><BR>
				Telegram: <A TARGET="NewTel" HREF="https://t.me/+hJgN1aRJFqU2MTAx">https://t.me/+hJgN1aRJFqU2MTAx</A>
			</I>
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