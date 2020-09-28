<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "voters";
	$BigMenu = "represent";	
	
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	// require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterlist.php";  
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($URIEncryptedString["UserParty"]);

	$rmb = new RepMyBlock();	
	$result = $rmb->GetPetitionsForCandidate($DatedFiles, 0, $URIEncryptedString["SystemUser_ID"]);
	
	if ( ! empty ($result)) {
		foreach ($result as $var) {
			if ( ! empty ($var)) {

				$MyAddressToUse = $var["Raw_Voter_ResHouseNumber"] . " " . 
													$var["Raw_Voter_ResStreetName"];

				if ( empty ($Counter[$MyAddressToUse] )) {
					$Counter[$MyAddressToUse] = 0;
				}
				
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Petition_ID"] = $var["Candidate_ID"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_ID"] = $var["VotersIndexes_UniqNYSVoterID"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_FullName"] = $var["CandidatePetition_VoterFullName"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Elector_Address"] = "Apt " . $var["Raw_Voter_ResApartment"];
				$Electors[$MyAddressToUse][$Counter[$MyAddressToUse]]["Full_Elector_Address"] = $var["Raw_Voter_ResHouseNumber"] . " " . $var["Raw_Voter_ResStreetName"];
			}			
			
			$Counter[$MyAddressToUse]++;
		}	
	}

			
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ($MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

<div class="row">
  <div class="main">



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>


<div class="<?= $Cols ?> float-left">
	
	<div class="Subhead">
  	<h2 class="Subhead-heading">Voters</h2>
	</div>

	<?php 
		if ($VerifEmail == true) { 
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
		} else if ($VerifVoter == true) {
			include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
		} 
	?>
	
	<A HREF="/lgd/<?= $k ?>/voterquery">Query for a voter</A><BR>
	<A HREF="/lgd/<?= $k ?>/voterlist">List of voters in district</A>
			


	
</div>

</div>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
