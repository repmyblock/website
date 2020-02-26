<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	$BigMenu = "represent";	
	 
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
	
	// Verify that the person is or has not beeing a candidate already.
	if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();
	
	if ( ! empty ($_POST)) {
		// echo "<PRE>" . print_r($_POST, 1) . "</PRE>";
		//function PrepDisctictVoterRoll($CandidateID, $RawVoterID, $DatedFiles, $DatedFilesID, $InfoArray) {
			
		
		$DisplayName = $_POST["FirstName"] . " " . $_POST["MiddleName"] . " " . $_POST["LastName"] . " " . $_POST["Suffix"];
		$Address = $_POST["ResHouseNumber"] . " " . $_POST["ResFracAddress"] . " " . $_POST["ResPreStreet"] . " " . 
		$_POST["ResStreetName"] . " " . $_POST["ResPostStDir"] . " " . $_POST["ResApartment"] . " " . 
		$_POST["ResCity"] . ", NY " . $_POST["ResZip"];
		
		$CanID = $rmb->InsertCandidate(NULL, $_POST["UniqNYSVoterID"], $_POST["rawvoterid"], $_POST["DatedFiles"], 
															$_POST["DatedFilesID"], $_POST["candidateelection"], $_POST["EnrollPolParty"], $_POST["FullName"],
															$_POST["Address1"] . "\n" . $_POST["Address2"], $_POST["candidateDBTable"], $_POST["DBTableValue"],	NULL, "published");	
		$CandidatePetitionSet = $rmb->InsertCandidatePetitionSet();

		$CanPetSet = $rmb->InsertCandidateSet($CanID["Candidate_ID"], $CandidatePetitionSet["CandidatePetitionSet_ID"], $_POST["EnrollPolParty"], $_POST["County"]);
		
		$InfoArray["ElectDistr"] = $_POST["ED"];
		$InfoArray["AssemblyDistr"] = $_POST["AD"];
		$InfoArray["Party"] = $_POST["EnrollPolParty"];
		
		$rmb->PrepDisctictVoterRoll($CanID["Candidate_ID"], $_POST["DatedFiles"], $_POST["DatedFilesID"], $InfoArray);
		
		header("Location: ?k=" . $k);
		exit();
		
	}

	// $Result = $rmb->SearchVoterBeingCandidate($URIEncryptedString["Raw_Voter_ID"]);
	$Result = $rmb->VoterRanCandidate($URIEncryptedString["Raw_Voter_ID"], $DatedFiles);
	
	if ( ! empty ($Result)) {
		$ResultStats = $rmb->ReturnGroupAD_Dated_DB($UniqNYSVoterID, $DatedFiles, $DatedFilesID, $Result[0]["Raw_Voter_EnrollPolParty"], 
																								$Result[0]["Raw_Voter_AssemblyDistr"], $Result[0]["Raw_Voter_ElectDistr"]);
																																
	}
	
	// echo "<PRE>" . print_r($Result,1) . "</PRE>";
	
	if ( empty ($Result[0]["Candidate_ID"])) {
		$EDAD = sprintf("%'.02d%'.03d",$Result[0]["Raw_Voter_AssemblyDistr"], $Result[0]["Raw_Voter_ElectDistr"]);
		$ResultElections = $rmb->CandidateElection("EDAD", $EDAD, date("Y-m-d"));
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Find Raw Voter</h2>
				</div>
					
						 <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
								<INPUT TYPE="hidden" NAME="rawvoterid" VALUE="<?= $Result[0]["Raw_Voter_ID"] ?>">
								<INPUT TYPE="hidden" NAME="UniqNYSVoterID" VALUE="<?= $Result[0]["Raw_Voter_UniqNYSVoterID"] ?>">
								<INPUT TYPE="hidden" NAME="DatedFiles" VALUE="<?= $DatedFiles ?>">
								<INPUT TYPE="hidden" NAME="DatedFilesID" VALUE="<?= $DatedFilesID ?>">
								<INPUT TYPE="hidden" NAME="EnrollPolParty" VALUE="<?= $Result[0]["Raw_Voter_EnrollPolParty"] ?>">
								<INPUT TYPE="hidden" NAME="FullName" VALUE="<?= $rmb->DB_ReturnFullName($Result[0]); ?>">     
								<INPUT TYPE="hidden" NAME="Address1" VALUE="<?= $rmb->DB_ReturnAddressLine1($Result[0]); ?>">     
								<INPUT TYPE="hidden" NAME="Address2" VALUE="<?= $rmb->DB_ReturnAddressLine2($Result[0]); ?>">     
								<INPUT TYPE="hidden" NAME="County" VALUE="<?= $Result[0]["Raw_Voter_CountyCode"] ?>">     
								<INPUT TYPE="hidden" NAME="ED" VALUE="<?= $Result[0]["Raw_Voter_ElectDistr"] ?>">     
								<INPUT TYPE="hidden" NAME="AD" VALUE="<?= $Result[0]["Raw_Voter_AssemblyDistr"] ?>">     
            
						<div class="list-group-item filtered f60 hundred">
							<span><B>Raw Voter List</B></span>  	          			
						</div>
							
					 <DIV class="panels">
				<?php
		 if ( ! empty ($Result)) {
				foreach ($Result as $var) {
					if ( ! empty ($var)) { 
						
						$EnrollVoterParty = $var["Raw_Voter_EnrollPolParty"];
						
						if ( $var["Raw_Voter_Gender"] == "M") {	$EnrollVoterSex = "male"; }
						else if ( $var["Raw_Voter_Gender"] == "F") {	$EnrollVoterSex = "female"; }
						else { $EnrollVoterSex = "other"; }
						
						?>
						
						
								
           
					 			
								<div class="list-group-item f60">
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									<?= $var["Raw_Voter_ID"] ?><BR>
									
					
									
									Stats: Stats <?= $ResultStats[0]["Count"] ?> Registered <?= NewYork_PrintParty($ResultStats[0][Raw_Voter_EnrollPolParty]) ?><BR>
									Required Signatures: <?= intval(($ResultStats[0][Count]) * $SignaturesRequired) + 1 ?><BR>

									
									Last: <?= $var["Raw_Voter_LastName"] ?>	First: <?= $var["Raw_Voter_FirstName"] ?>	Middle: <?= $var["Raw_Voter_MiddleName"] ?> Suffix: <?= $var["Raw_Voter_Suffix"] ?><BR>
									<?php if (! empty ($var["Raw_Voter_ResHouseNumber"])) echo $var["Raw_Voter_ResHouseNumber"]; ?>
									<?php if (! empty ($var["Raw_Voter_ResFracAddress"]))  echo $var["Raw_Voter_ResFracAddress"]; ?>
									<?php if (! empty ($var["Raw_Voter_ResPreStreet"])) echo $var["Raw_Voter_ResPreStreet"]; ?>
									<?php if (! empty ($var["Raw_Voter_ResStreetName"])) echo $var["Raw_Voter_ResStreetName"]; ?>
									<?php if (! empty ($var["Raw_Voter_ResPostStDir"])) echo $var["Raw_Voter_ResPostStDir"] . "<BR>"; ?>
									<?php if (! empty ($var["Raw_Voter_ResApartment"])) echo $var["Raw_Voter_ResApartment"] . "<BR>"; ?>

									<?= $var["Raw_Voter_ResCity"] ?>, NY
									<?= $var["Raw_Voter_ResZip"] ?> - <?= $var["Raw_Voter_ResZip4"] ?><BR>
									<?= $var["Raw_Voter_DOB"] ?> - <?= $var["Raw_Voter_Gender"] ?> - <?= $var["Raw_Voter_EnrollPolParty"] ?><BR>
									Cty: <?= $var["Raw_Voter_CountyCode"] ?> 
									AD: <?= $var["Raw_Voter_AssemblyDistr"] ?>
									ED:<?= $var["Raw_Voter_ElectDistr"] ?>
									Legist: <?= $var["Raw_Voter_LegisDistr"] ?>
									Town: <?= $var["Raw_Voter_TownCity"] ?>
									Ward: <?= $var["Raw_Voter_Ward"] ?>
									Congress: <?= $var["Raw_Voter_CongressDistr"] ?>
									Senate: <?= $var["Raw_Voter_SenateDistr"] ?>
									Status: <?= $var["Raw_Voter_Status"] ?><BR>

									<?php $MySpecialK = EncryptURL("Raw_Voter_ID=" . $var["Raw_Voter_ID"] . "&RawDatedFiles=" .  $DatedFiles . 
									                               "&ED=" . $var["Raw_Voter_ElectDistr"] . "&AD=" . $var["Raw_Voter_AssemblyDistr"] .
									                               "&Raw_Voter_EnrollPolParty=" . $var["Raw_Voter_EnrollPolParty"]); ?>
								
									<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
									Download 
									
									<?php if (! empty ($var["CanPetitionSet_ID"])) { ?>
										
										<a class="mr-1" TARGET="Petition" href="<?= $FrontEndPDF ?>/multipetitions/?petid=<?= $var["CanPetitionSet_ID"] ?>">Petition</A>
							
										
										<a class="mr-1" TARGET="Petition" href="<?= $FrontEndPDF ?>/voterlist/?k=<?= EncryptURL("CanPetitionSet_ID=" . $var["CanPetitionSet_ID"]); ?>">Walking List</a> 
									<?php } else { ?>
										
										<a class="mr-1" TARGET="Petition" href="<?= $FrontEndPDF ?>/raw_voterlist/?k=<?= $MySpecialK ?>">Walking List</a> 
									<?php } ?>
										
								
									<BR>
									<?php if ( ! empty ($EmailSend)) { echo $EmailSend . "<BR>"; } ?>
									</div>
									
										<?php
										 if ( ! empty ($ResultElections)) {
				foreach ($ResultElections as $varelection) {
					if ( ! empty ($varelection)) { 
						
						print "<PRE>" . print_r($varelection, 1) . "</PRE>";
						
						if ($EnrollVoterParty  == $varelection["varelection"] ) {
							
		
							
						if  (empty ($varelection["CandidateElection_Sex"]) || ( $EnrollVoterSex == $varelection["CandidateElection_Sex"] )) {
						
							
						
						?>
						
						
					
						
						<div class="list-group-item f60">	
									CandidateElection_ID: <?= $varelection["CandidateElection_ID"] ?> - ElectionID: <?= $varelection["Elections_ID"] ?><BR>
									Election Name: <?= $varelection["Elections_Text"] ?> - Date: <?= PrintShortDate($varelection["Elections_Date"]) ?> - 
									Type: <?= $varelection["Elections_Type"] ?><BR>
									Type: <?= $varelection["CandidateElection_PositionType"] ?> - Party: <?= $varelection["CandidateElection_Party"] ?><BR>
									Position: <?= $varelection["CandidateElection_Text"] ?><BR>
									Name of Petition: <?= $varelection["CandidateElection_PetitionText"] ?><BR>
									Number of position in district: <?= $varelection["CandidateElection_Number"] ?><BR>
									Gender for position: <?= $varelection["CandidateElection_Sex"] ?><BR>
									Total Stats: <?= $varelection["CandidateElection_CountVoter"] ?><BR>
									Select the three checkboxes:
									<UL>
										<INPUT TYPE="checkbox" NAME="candidateelection" VALUE="<?= $varelection["CandidateElection_ID"] ?>"> Select for <B><?= $varelection["CandidateElection_Text"] ?><BR>
										<INPUT TYPE="checkbox" NAME="candidateDBTable" VALUE="<?= $varelection["CandidateElection_DBTable"] ?>"> District: <?= $varelection["CandidateElection_DBTable"] ?><BR>
										<INPUT TYPE="checkbox" NAME="DBTableValue" VALUE="<?= $varelection["CandidateElection_DBTableValue"] ?>"> Value: <?= $varelection["CandidateElection_DBTableValue"] ?><BR>
									</UL>
								
									</DIV>
          <?php } 
        }
        					} }

      }
      ?>
      
      	<?php if ( count($ResultElections) > 0) { ?>
									<div class="list-group-item f60">	
            <dl class="form-group col-3 d-inline-block"> 
								<dd>
									<button type="submit" class="btn btn-primary">Attach this voter to candidate</button>
								</dd>
							</dl>
			
								<?php } ?>
									
			<?php	}	 
				} 

	}?>
					</DIV>
					</DIV>
						</DIV>

</FORM>
</DIV>
</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>
