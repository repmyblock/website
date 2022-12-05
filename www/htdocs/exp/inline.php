<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	$r = new welcome();	
	
	if (! empty($_POST)) {
		WriteStderr($_POST, "_POST");
		parse_str(DecryptURL($_POST["String"]), $POSTEncryptedString);
		WriteStderr($POSTEncryptedString, "POSTEncryptedString");
		
		if ( ! empty ($_POST["NotInterested"])) {
			header("Location: /exp/share/qrcode"); exit();
		}
		
		if ( ! empty ($_POST["WantToKnowMore"])) {
			header("Location: /exp/iam/interested"); exit();
		}
		
		if ( ! empty ($_POST["SendMeMoreInfo"])) {
		header("Location: /exp/send/moreinfo"); exit();
		}
	
		
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	
?>
<DIV class="main">
		
	<DIV class="right f80">Waiting in line to vote</DIV>

	<P class="f60">
		Would you represent your block?
	</P>

	<P class="MediaCenter">
		<div>
  <div style="position:relative;padding-top:56.25%;">
	 <iframe style="position:absolute;top:0;left:0;width:100%;height:100%;" src="https://www.youtube.com/embed/MnI7iBxCN4A?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	 </div>
</div>
	</P>
	
	<FORM METHOD="POST" ACTION="">	
		<INPUT TYPE="HIDDEN" NAME="String" VALUE="<?= rawurldecode(rawurldecode(CreateEncoded ( array( 	
																					"Campaign" => "WaitingToVote",
																					"VolunteerEmail" => $VolunteerEmail,
																					"CampaignEmail" => $CampaignEmail,
																					)))) ?>">
	
	<P>
		<DIV><CENTER><INPUT class="" TYPE="Submit" NAME="NotInterested" VALUE="I am not interested but show me a QR code to share the knowledge"></CENTER></DIV>
	</P>
	
	<P>
		<DIV><CENTER><INPUT class="" TYPE="Submit" NAME="WantToKnowMore" VALUE="I want to know more"></CENTER></DIV>
	</P>
	
	<P>
		<DIV><CENTER><INPUT class="" TYPE="Submit" NAME="SendMeMoreInfo" VALUE="Send me more information"></CENTER></DIV>
	</P>

	
	
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>