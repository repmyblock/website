<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "profile";  
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();
	
	if ( ! empty ($_POST)) {
    $ADED = sprintf('%02d%03d', $_POST["Raw_Voter_AssemblyDistr"], $_POST["Raw_Voter_ElectDistr"]);		
    $District = sprintf('AD %02d / ED %03d', $_POST["Raw_Voter_AssemblyDistr"], $_POST["Raw_Voter_ElectDistr"]);		

		$rmb->UpdateSystemUserWithVoterCard($SystemUser_ID, $_POST["RawVoterID"], 
																				$_POST["Raw_Voter_UniqNYSVoterID"], $ADED);
																				
		$EncryptedURL = "SystemUser_ID=" . $SystemUser_ID .
										"&FirstName=" . $FirstName . 
										"&LastName=" . $LastName .
										"&VotersIndexes_ID=" . $VotersIndexes_ID . 
										"&UniqNYSVoterID=" . $_POST["Raw_Voter_UniqNYSVoterID"] . 
										"&MenuDescription=" . urlencode($District) . 
										"&UserParty=" . $_POST["Raw_Voter_EnrollPolParty"];
		
		header("Location: /lgd/profile/voter/?k=" . EncryptURL($EncryptedURL));
		exit();
	}
	
	if ( empty ($VotersIndexes_ID )) {
		include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
		echo "We did not find the Voter ID information. We Return";
		include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";
		exit();
	} 
	
	$rmbvoters = $rmb->SearchVotersBySingleIndex($VotersIndexes_ID, $DatedFiles);
	
	if (! empty ($rmbvoters["Raw_Voter_UniqNYSVoterID"])) {
		$rmbvoteridx = $rmb->SearchLocalRawDBbyNYSID($rmbvoters["Raw_Voter_UniqNYSVoterID"]);
	
		if ( ! empty ($rmbvoteridx)) {
			foreach ($rmbvoteridx as $var) {
				if ( ! empty ($var)) {
					if ( $var["Raw_Voter_ID"] > $RawVoterID ) {
						$RawVoterID = $var["Raw_Voter_ID"];
					}
				}
			}
		}
	}
	
	

	
	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);

	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>
  		<div class="col-9 float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Voter Profile</h2>
			  </div>
			     
				<nav class="UnderlineNav pt-1 mb-4" aria-label="Billing navigation">
					<div class="UnderlineNav-body">
						<a href="/lgd/profile/?k=<?= $k ?>" class="UnderlineNav-item">Public Profile</a>
						<a href="/lgd/profile/voter/?k=<?= $k ?>" class="UnderlineNav-item selected">Voter Profile</a>
						<a href="/lgd/profile/candidate/?k=<?= $k ?>" class="UnderlineNav-item">Candidate Profile</a>
					</div>
				</nav>

				<div class="Box">
					<div class="Box-header pl-0">
						<div class="table-list-filters d-flex">
							<div class="table-list-header-toggle states flex-justify-start pl-3">Voter Card</div>
						</div>
					</div>
				
					<div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
						We don't know your district <a href="/voter">create one</a>?
					</div>
					
					<FORM ACTION="" METHOD=POST>

					<div id="voters">
						<div class="list-group-item filtered">
							<p><button type="submit" class="btn btn-primary">This is my voter registration card</button></p>
							<INPUT TYPE="checkbox" NAME="SelectAllAddresses" VALUE="<?= $rmbvoters["Raw_Voter_UniqNYSVoterID"] ?>">&nbsp;&nbsp;<BR>
							
							<INPUT TYPE="hidden" NAME="VoterIndexes_ID" VALUE="<?= $rmbvoters["VotersIndexes_ID"] ?>">
							<INPUT TYPE="hidden" NAME="Raw_Voter_ID" VALUE="<?= $rmbvoters["Raw_Voter_ID"] ?>">
							<INPUT TYPE="hidden" NAME="RawVoterID" VALUE="<?= $RawVoterID ?>">
							<INPUT TYPE="hidden" NAME="Raw_Voter_UniqNYSVoterID" VALUE="<?= $rmbvoters["Raw_Voter_UniqNYSVoterID"] ?>">
							<INPUT TYPE="hidden" NAME="Raw_Voter_ElectDistr" VALUE="<?= $rmbvoters["Raw_Voter_ElectDistr"] ?>">
							<INPUT TYPE="hidden" NAME="Raw_Voter_AssemblyDistr" VALUE="<?= $rmbvoters["Raw_Voter_AssemblyDistr"] ?>">
							<INPUT TYPE="hidden" NAME="Raw_Voter_EnrollPolParty" VALUE="<?= $rmbvoters["Raw_Voter_EnrollPolParty"] ?>">

		
							
							VotersIndexes_ID: <?= $rmbvoters["VotersIndexes_ID"] ?><BR>
						 	Raw_Voter_ID: <?= $rmbvoters["Raw_Voter_ID"] ?><BR>
						 	RawVoterID: <?= $RawVoterID ?><BR>
						 	UNIQ_VOTER_ID: <?= $rmbvoters["Raw_Voter_UniqNYSVoterID"] ?><BR>
						  <BR>
						  
						  Voter Status: <?= $rmbvoters["Raw_Voter_Status"] ?><BR>
							Reason Code: <?= $rmbvoters["Raw_Voter_ReasonCode"] ?><BR>
							Voter Date Inactive: <?= $rmbvoters["Raw_Voter_VoterMadeInactive"] ?><BR>
							Voter Date Purged: <?= $rmbvoters["Raw_Voter_VoterPurged"] ?><BR>
							
							<BR>   
							     
							First Name: <?= $rmbvoters["Raw_Voter_FirstName"] ?><BR>
							Middle Name: <?= $rmbvoters["Raw_Voter_MiddleName"] ?><BR>
							Last Name: <?= $rmbvoters["Raw_Voter_LastName"] ?>			<BR>	    
							Suffix: <?= $rmbvoters["Raw_Voter_Suffix"] ?><BR>
							<BR>

							Address:<BR> 
								<?= $rmbvoters["Raw_Voter_ResHouseNumber"] ?>
							  <?= $rmbvoters["Raw_Voter_ResFracAddress"] ?>
							  <?= $rmbvoters["Raw_Voter_ResPreStreet"] ?>
							  <?= $rmbvoters["Raw_Voter_ResStreetName"] ?>
							  <?= $rmbvoters["Raw_Voter_ResPostStDir"] ?>
							  Apt #<?= $rmbvoters["Raw_Voter_ResApartment"] ?><BR>
							  <?= $rmbvoters["Raw_Voter_ResCity"] ?>, NY
							  <?= $rmbvoters["Raw_Voter_ResZip"] ?>
							  <?= $rmbvoters["Raw_Voter_ResZip4"] ?>
							<BR>

							Date of Birth: <?= $rmbvoters["Raw_Voter_DOB"] ?><BR>
							Gender: <?= $rmbvoters["Raw_Voter_Gender"] ?><BR>
							    
							Enrolled Party: <?= $rmbvoters["Raw_Voter_EnrollPolParty"] ?><BR>
							   <?= $rmbvoters["Raw_Voter_OtherParty"] ?><BR>

					 		Town City: <?= $rmbvoters["Raw_Voter_TownCity"] ?><BR>
							County: <?= $rmbvoters["DataCounty_Name"] ?><BR>
							
							Election District: <?= $rmbvoters["Raw_Voter_ElectDistr"] ?><BR>
							Assembly District:<?= $rmbvoters["Raw_Voter_AssemblyDistr"] ?><BR>
							SenateDistrict: <?= $rmbvoters["Raw_Voter_SenateDistr"] ?><BR>
							Congressional District: <?= $rmbvoters["Raw_Voter_CongressDistr"] ?><BR>
							Legislative District: <?= $rmbvoters["Raw_Voter_LegisDistr"] ?><BR>								  
							Ward: <?= $rmbvoters["Raw_Voter_Ward"] ?><BR>

							Last Time Voted: <?= $rmbvoters["Raw_Voter_LastDateVoted"] ?><BR>
							<BR>
						</div>
							
					 	<DIV class="panels">
							<div class="list-group-item">	
								<?php  
										echo "<PRE>";
										print_r($rmbvoters);
										echo "</PRE>";
										
										echo "INDEX";
										echo "<PRE>";
										print_r($rmbvoteridx);
										echo "</PRE>";
										
										
										
								?>
				
							
							</div>
						</div>
					</div>
				</FORM>
				</div>
			</div>		
		</div>
	</div>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>