<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WipeURLEncrypted();
	
	//$result = $r->GetSignedElectors($Candidate_ID);
	$EncryptURL = EncryptURL("CandidateID=" . $Candidate_ID . "&PetitionSetID=" . $CandidatePetitionSet_ID);
	
	$TopMenus = array ( 
		array("k" => $k, "url" => "team/index", "text" => "Team Members"),
		array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
		array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
	);			
	WriteStderr($TopMenus, "Top Menu");		
	
	$ListPetitions = $rmb->ListCandidateInformation($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($ListPetitions, "ListPetitions");	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Manage Petitions</h2>
			  </div>
			    
		<?php PlurialMenu($k, $TopMenus); ?>
		
		 <dl class="form-group f60">
  	<dt><label for="user_profile_email">Petition list created</label></dt>
    <dd class="d-inline-block f40">       	
    				
		<P>
		
		<UL>
		<?php 
			if ( ! empty ($ListPetitions) ) {
				foreach ($ListPetitions as $var) {
					if ($var["Candidate_Status"] != "deleted") {
						
							
						$NewKEncrypt = CreateEncoded(array(
														"CandidatePetitionSet_ID" => $var["CandidatePetitionSet_ID"],	
														"Candidate_ID" => $var["Candidate_ID"],	
														"PendingBypass" => "yes"								
													));
		?>
				
		<LI><A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= $NewKEncrypt ?>/NY/petition">		
		<?= $var["Candidate_DispName"] ?>
		<?php if ( ! empty ($var["Candidate_PetitionNameset"])) { echo "(" . $var["Candidate_PetitionNameset"] . ")"; } ?>
		in <B><?= $var["Candidate_Status"] ?></B> status.</A>
							
			<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= $NewKEncrypt ?>/NY/petition"><i class="fa fa-download"></i></A>
				
			<A TARGET="NEWWALKSHEET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded ( array( 
											"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
											"VoterSystemUser_ID" => $rmbteammember["SystemUser_ID"],
											"VotersIndexes_ID" => $rmbteammember["Voters_ID"],
											"UniqNYSVoterID" => $rmbteammember["VotersIndexes_UniqStateVoterID"],						
									    "PetitionStateID" => $rmbteammember["ElectionStateID"],
									    "FirstName" => $rmbteammember["DataFirstName_Text"],
									    "LastName" => $rmbteammember["DataLastName_Text"],
									    "PreparedFor" => $VoterFullName,
									    "DataDistrict_ID" => $rmbteammember["DataDistrict_ID"],
									    "DataDistrictTown_ID" => $rmbteammember["DataDistrictTown_ID"],
											"Party" => $rmbteammember["Voters_RegParty"],
											"TeamName" => $ActiveTeam,
											"TeamPerson" =>  $rmbperson["DataFirstName_Text"] . " " . $rmbperson["DataLastName_Text"],
								)) . "/rmb/voterlist" ?>">Download a walksheet</A>
				</LI> 
				
									<?php
					}
				}
			}
		?>
	</UL>
		</P>				
		

    </dd>
  </dl>
			
	
		
</DIV>
</DIV>
</DIV>
</DIV>

	
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
