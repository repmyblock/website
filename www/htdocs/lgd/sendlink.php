<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if (! empty($_POST)) {
		//echo "POST: <PRE>" . print_r($_POST) . "</PRE>";
		parse_str(DecryptURL($_POST["String"]), $POSTEncryptedString);
		WriteStderr($POSTEncryptedString, "POSTEncryptedString");
		//		$r->SaveVolunteer($_POST["emailaddress"], $POSTEncryptedString["U"], $POSTEncryptedString["S"], $POSTEncryptedString["C"]); 
		
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/email.php";
		SendInviteToEnroll($_POST["emailaddress"], $POSTEncryptedString["Campaign"], $POSTEncryptedString["CampaignEmail"], $POSTEncryptedString["VolunteerEmail"]);
		
		header("Location: /lgd/" . CreateEncoded ( array( 	
								"FirstName" => $POSTEncryptedString["FirstName"] ,
								"Email" => $_POST["emailaddress"],
								"Campaign" => $POSTEncryptedString["Campaign"]
					)) . "/updateuserinfo");
		exit();
		
	}
	
	switch ($URIEncryptedString["SendOption"]) {
		case "SendLink":
			$title = "Send Link to enroll to Rep My Block";
			break;
			
		case "UpdateVoterInfo":
			$title = "Send link to update registration info";
			break;
			
		case "ListCandidate":
			$title = "Send link about candidate";
			break;
	}
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	$Party = NewYork_PrintParty($UserParty);
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading"><?= $title ?></h2>
				</div>
				
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
				
					<P CLASS="f80">
						<DIV CLASS="f80">Email:</DIV> 
						<DIV><INPUT CLASS="" type="<?= $TypeEmail ?>" autocorrect="off" autocapitalize="none" NAME="emailaddress" PLACEHOLDER="you@email.net" VALUE="<?= $_POST["emailaddress"] ?>"><DIV>
					</P>
						
					<P>
						<DIV><INPUT CLASS="" TYPE="Submit" NAME="SaveInfo" VALUE="Send the information By Email"></DIV>
					</P>
					
					<P CLASS="f40">
						By clicking the <B>"Send Information By Email"</B> button, 
						you are acknoleging to accept to receive email by <?= $CampaignName ?> the campaign. 
						RepMyBlock is a tool used by <?= $CampaignName ?> and the data available is collected
						trought the Voter Information file available freely to any candidate and citizen.
						<A HREF="/exp/<?= $middleuri ?>/terms">Terms of Use</A> and 
						<A HREF="/exp/<?= $middleuri ?>/privacy">Privacy Policy.</A>
					</P>

				
				</div>
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
