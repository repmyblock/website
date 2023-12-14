<?php

	$HeaderTwitter = "yes";
	$HeaderTwitterTitle = "Rep My Block - Rep My Block";
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/PledgeSignature.jpg";
	$HeaderTwitterDesc = "Pledge your signature to Biden delegates for the DNC convention.";
	$HeaderOGTitle = "Biden For President";
	$HeaderOGDescription = "Pledge your signature to Biden delegates for the DNC convention.";
	$HeaderOGImage = "https://static.repmyblock.org/pics/paste/PledgeSignature.jpg"; 
	$HeaderOGImageWidth = "623";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST["CheckRegistration"])) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_brand_socialist.php";	

		header("Location: /" . CreateEncoded (
														array("FirstName" => trim($_POST["FirstName"]),	
																	"LastName" => trim($_POST["LastName"]),
																	"Email" => trim($_POST["Email"]))) .
						"/brand/socialist/findvoter");
		exit();
	}

	$imgtoshow = "/brand/socialist/Socialists.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
	<DIV class="right f80">Download a Social Democrat of America Petition</DIV>
	
			
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
		
		
		<P class="f60 p20">
			Because of the fast moving pace of the petition period, we created a WhatsApp and Telegram group to notify 
			of changes in the data. 
		<BR><BR>
			<B>This is a very low notification group <I>(a message every two days around 7:30 pm New York Time)</I>.</B> 
		
		<BR><BR>
			
			We'll send updates on the availability of the petitions and how to give them to the various SDA comrades.<BR>
			<I>
				WhatsApp: <A TARGET="NewWhat" HREF="https://chat.whatsapp.com/EDKNVkzhlEyI9qvUXqu5S8">https://chat.whatsapp.com/EDKNVkzhlEyI9qvUXqu5S8</A><BR>
				Telegram: <A TARGET="NewTel" HREF="https://t.me/+hJgN1aRJFqU2MTAx">https://t.me/+hJgN1aRJFqU2MTAx</A>
			</I>
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