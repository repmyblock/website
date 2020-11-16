<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	
	if ( ! empty ($_POST)) {
		echo "<PRE>" .	print_r($_POST, 1) . "</PRE>";
		
		// This is the Email Address
		if ( ! empty ($_POST["EmailAddress"])) {
			$result = $rmb->SearchVoterContactEmail($URIEncryptedString["SystemUser_ID"], $_POST["UniqNYSVoterID"], $_POST["EmailAddress"]);
			if ( empty ($result)) {
				$rmb->SaveVoterContactEmail($URIEncryptedString["SystemUser_ID"], $_POST["UniqNYSVoterID"], $_POST["EmailAddress"]);
			}
		}
		
		// This is for telephone
		if ( ! empty ($_POST["Telephone"])) {
			$result = $rmb->SearchVoterContactTelephone($URIEncryptedString["SystemUser_ID"], $_POST["UniqNYSVoterID"], $_POST["Telephone"]);
			if ( empty ($result)) {
				$rmb->SaveVoterContactTelephone($URIEncryptedString["SystemUser_ID"], $_POST["UniqNYSVoterID"], $_POST["Telephone"], $_POST["TypePhone"]);
			}
		}
		
		exit();
	}
	
	$InformationAboutVote = $rmb->FindAllVoterInformationByUniq($URIEncryptedString["SystemUser_ID"], $URIEncryptedString["Elector_ID"], $DatedFiles);
	WriteStderr($InformationAboutVote, "InformationAboutVote");

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	$SurveyWindows = $rmb->ListSurveyCategories($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($SurveyWindows, "SurveyWindows");
	
	if ( ! empty ($SurveyWindows)) {
		foreach($SurveyWindows as $var) {
			if ( ! empty ($var)) {
				$SurveyOptionsName[$var["SurveyCategory_ID"]] = $var["SurveyCategory_Name"];
				$SurveyOptionsValue[$var["SurveyCategory_ID"]][$var["SurveyValues_ID"]] = $var["SurveyValues_Name"];
			}
		}
	}
	
	WriteStderr($SurveyOptionsName, "SurveyOptionsName");
	WriteStderr($SurveyOptionsValue, "SurveyOptionsValue");
		
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";

?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Voter Information</h2>
				</div>
				
				
				

			<FORM ACTION="" METHOD="POST">
			<INPUT TYPE="HIDDEN" NAME="UniqNYSVoterID" VALUE="<?= $URIEncryptedString["Elector_ID"] ?>">
			 	<DIV class="panels">	
			 	
			 	<P>	
			 	<h3><?= DB_ReturnFullName($InformationAboutVote[0]) ?></h3>	
				<H4><I><?= DB_ReturnAddressLine1($InformationAboutVote[0]) ?>, <?=  DB_ReturnAddressLine2($InformationAboutVote[0]) ?></I></h4>
			 	</P>
				 		
				<P>
				<B>Update the voter information.</B><BR>
				This information is not shared with anyone except who you share it with.
			</P>
			
			<?php if ( ! empty ($InformationAboutVote[0]["VoterContactEmail_val"])) {
					foreach($InformationAboutVote as $var) {
						if ( ! empty ($var["VoterContactEmail_val"])) {
							echo "<B>Email:</B> " . $var["VoterContactEmail_val"] . "<BR>";
						}
					}
			} ?>


			<?php if ( ! empty ($InformationAboutVote[0]["VoterContactEmail_val"])) {
					foreach($InformationAboutVote as $var) {
						if ( ! empty ($var["VoterContactEmail_val"])) {
							echo "<B>Telephone:</B> " . formatPhoneNumber($var["VoterContactPhone_val"]) . " - " . $var["VoterContactPhone_type"] . "<BR>";
						}
					}
			} ?>
			

			
			
			
			
		</P>			
			
		
			<?php
				// To deal with the referer
				$KeyWords = PrintReferer(1);
			?>
			
			<P>
				
				
				<A HREF="/lgd/<?= CreateEncoded (
													array( 
														"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
														"FirstName" => $PersonFirstName, "LastName" => $PersonLastName,
														"VotersIndexes_ID" =>  $URIEncryptedString["VotersIndexes_ID"], "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
														"UserParty" => $URIEncryptedString["UserParty"], "MenuDescription" => $URIEncryptedString["MenuDescription"],
														"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
														"VerifVoter" => $URIEncryptedString["VerifVoter"], "VerifEmail" => $URIEncryptedString["VerifEmail"],
														"EDAD" => $URIEncryptedString["EDAD"],
														"SendOption" => "SendLink",
														"Return" => $KeyWords[5],	
														"ReturnParams" => $Decrypted_k													
													)) ?>/sendlink">Send them a link to enroll into RepMyBlock.</A><BR>
				<A HREF="/lgd/<?= CreateEncoded (
													array( 
														"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
														"FirstName" => $PersonFirstName, "LastName" => $PersonLastName,
														"VotersIndexes_ID" =>  $URIEncryptedString["VotersIndexes_ID"], "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
														"UserParty" => $URIEncryptedString["UserParty"], "MenuDescription" => $URIEncryptedString["MenuDescription"],
														"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
														"VerifVoter" => $URIEncryptedString["VerifVoter"], "VerifEmail" => $URIEncryptedString["VerifEmail"],
														"EDAD" => $URIEncryptedString["EDAD"],
														"SendOption" => "UpdateVoterInfo",
														"Return" => $KeyWords[5],
														"ReturnParams" => $Decrypted_k			
													))?>/sendlink">Send them information to update their voter registration information.</A><BR>
				<A HREF="/lgd/<?= CreateEncoded (
													array( 
														"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
														"FirstName" => $PersonFirstName, "LastName" => $PersonLastName,
														"VotersIndexes_ID" =>  $URIEncryptedString["VotersIndexes_ID"], "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
														"UserParty" => $URIEncryptedString["UserParty"], "MenuDescription" => $URIEncryptedString["MenuDescription"],
														"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
														"VerifVoter" => $URIEncryptedString["VerifVoter"], "VerifEmail" => $URIEncryptedString["VerifEmail"],
														"EDAD" => $URIEncryptedString["EDAD"],
														"SendOption" => "ListCandidate",
														"Return" => $KeyWords[5],
														"ReturnParams" => $Decrypted_k			
													)) ?>/sendlink">Send them information on a candidate you like.</A><BR>
				</P>
						
				<P>
					<B>Add Contact Information:</B>
				</P>
					
							
				
					<P>
						<DIV>Email:
							<INPUT CLASS="" type="" autocorrect="off" autocapitalize="none" NAME="EmailAddress" PLACEHOLDER="you@email.net" VALUE=""><DIV>
					</P>
						
					
					
					<P >
						<DIV >Telephone:
							<INPUT CLASS="" type="" autocorrect="off" autocapitalize="none" NAME="Telephone" PLACEHOLDER="(212) 555-1212" VALUE="">
							<SELECT NAME="TypePhone">
								<OPTION VALUE="">&nbsp;</OPTION>
								<OPTION VALUE="landline">Land Line</OPTION>
								<OPTION VALUE="cell">Cell Phone</OPTION>
								<OPTION VALUE="voip">VOIP</OPTION>
								<OPTION VALUE="other">Other</OPTION>
								<OPTION VALUE="unkown">Unkown</OPTION>
							</SELECT>
						<DIV>
					</P>
					
					
				</P>
						
								
				<P>
					
					<B>Update Survey Info:</B>

			</P>
			<P>
					<?php 
						echo "<UL><TABLE ID=\"NoBoRder\" CLASS=\"NoBoRder\" BORDER=0>";
						if (! empty ($SurveyOptionsName)) {
							foreach ($SurveyOptionsName as $var => $index) {
								echo "<TR><TD>$index:</TD><TD><SELECT NAME=\"Survey[" .  $var . "]\">";
									if ( ! empty($SurveyOptionsValue[$var])) {
										echo "<OPTION VALUE=\"\"></OPTION>";			
										foreach ($SurveyOptionsValue[$var] as $vor => $index2) {
											if ( ! empty($vor)) {
												echo "<OPTION VALUE=\"" . $vor . "\">" . $index2 . "</OPTION>";													
											}
										}
									}								
								echo "</SELECT></TD></TR>\n";
							}
						}
						echo "</TABLE></UL>";
					
					?>
					
					
				</P>
				
								<P>									
													
													
				<A HREF="/lgd/<?= CreateEncoded (
													array( 
														"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	"Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
														"FirstName" => $PersonFirstName, "LastName" => $PersonLastName,
														"VotersIndexes_ID" =>  $URIEncryptedString["VotersIndexes_ID"], "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
														"UserParty" => $URIEncryptedString["UserParty"], "MenuDescription" => $URIEncryptedString["MenuDescription"],
														"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
														"VerifVoter" => $URIEncryptedString["VerifVoter"], "VerifEmail" => $URIEncryptedString["VerifEmail"],
														"EDAD" => $URIEncryptedString["EDAD"],
														"SendOption" => "SendLink",
														"Return" => $KeyWords[5],	
														"ReturnParams" => $Decrypted_k													
													)) ?>/updateinfocreatecategories">Create Categories</A><BR>
			
													
				
					</P>
					
					
					<P>
						<DIV><INPUT CLASS="" TYPE="Submit" NAME="SaveInfo" VALUE="Update voter's contact information"></DIV>
					</P>
					
					 	<P><B>Voter History</B></P>
			 	<P>
			 		<?= $InformationAboutVote[0]["Raw_Voter_VoterHistory"] ?>
			 	</P>		
				
			<A HREF="<?= PrintReferer()  ?>">Return to previous menu</A></B>
		</P>	

			</DIV>
				</DIV>
					</DIV>
			</DIV>
									
		
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
