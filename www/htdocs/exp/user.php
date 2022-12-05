<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
	
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
	$r = new welcome();	
	
	if (! empty($_POST)) {
		//echo "POST: <PRE>" . print_r($_POST) . "</PRE>";
		parse_str(DecryptURL($_POST["String"]), $POSTEncryptedString);
		WriteStderr($POSTEncryptedString, "POSTEncryptedString");
		$r->SaveVolunteer($_POST["emailaddress"], $POSTEncryptedString["U"], $POSTEncryptedString["S"], $POSTEncryptedString["C"]); 
		
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";
		SendWelcomeVolunteerMessage($_POST["emailaddress"], $POSTEncryptedString["Campaign"], $POSTEncryptedString["CampaignEmail"], $POSTEncryptedString["VolunteerEmail"]);
		
		header("Location: /exp/" . CreateEncoded ( array( 	
								"FirstName" => $POSTEncryptedString["FirstName"] ,
								"Email" => $_POST["emailaddress"],
								"Campaign" => $POSTEncryptedString["Campaign"]
					)) . "/usersuccess");
		exit();
		
	}
	
	$VolunteerEmail = "testvol@theochino.com";
	$CampaignEmail = "campaigntest@theochino.com";
	
	$ResultCandidate = $r->FindCandidate($URIEncryptedString["C"]);
	$ResultVoter = $r->FindVoter($URIEncryptedString["U"], $DatedFiles);  	
	$ResultVolunteer = $r->FindVolunteer($URIEncryptedString["S"]);
	
	WriteStderr($ResultCandidate, "Candidate");
	WriteStderr($ResultVoter, "Voter");
	WriteStderr($ResultVolunteer, "Volunteer");
	
	$FirstName = ucwords(strtolower($ResultVoter["Raw_Voter_FirstName"]));
	$VolunteerName = ucwords(strtolower($ResultVolunteer["SystemUser_FirstName"]));
	$Campaign = ucwords(strtolower($ResultCandidate["Candidate_DispName"]));
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	
?>
<DIV class="main">
		
	<DIV class="right f80">Information</DIV>

	<P class="f40">
		Dear <B><?= $FirstName ?></B>, <BR>
		<BR>you were given this 
		code by <B><?= $VolunteerName ?></B>, a volunteer
		for the campaign of <B><FONT COLOR="BROWN"><?= $Campaign ?></FONT></B>.
	<BR>
	<BR>
		Please enter your contact information below.
	</P>



	<FORM METHOD="POST" ACTION="">	
		<INPUT TYPE="HIDDEN" NAME="String" VALUE="<?= rawurldecode(rawurldecode(CreateEncoded ( array( 	
																					"FirstName" => $FirstName,
																					"Campaign" => $Campaign,
																					"VolunteerEmail" => $VolunteerEmail,
																					"CampaignEmail" => $CampaignEmail,
																					"C" => $URIEncryptedString["C"],
																					"U" => $URIEncryptedString["U"],  	
																					"S" => $URIEncryptedString["S"]
																		)))) ?>">
		<P class="f80">
			<DIV class="f80">Email:</DIV> 
			<DIV><INPUT class="" type="<?= $TypeEmail ?>" autocorrect="off" autocapitalize="none" NAME="emailaddress" PLACEHOLDER="you@email.net" VALUE="<?= $_POST["emailaddress"] ?>"><DIV>
		</P>
			
		<P>
			<DIV><INPUT class="" TYPE="Submit" NAME="SaveInfo" VALUE="Receive Information By Email"></DIV>
		</P>
		
		<P class="f40">
			By clicking the <B>"Receiving Information By Email"</B> button, 
			you are acknoleging to accept to receive email by <?= $CampaignName ?> the campaign. 
			RepMyBlock is a tool used by <?= $CampaignName ?> and the data available is collected
			trought the Voter Information file available freely to any candidate and citizen.
			<A HREF="/exp/<?= $middleuri ?>/terms">Terms of Use</A> and 
			<A HREF="/exp/<?= $middleuri ?>/privacy">Privacy Policy.</A>
		</P>

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>