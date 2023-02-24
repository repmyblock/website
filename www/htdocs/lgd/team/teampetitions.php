<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	$rmb = new Teams();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WipeURLEncrypted( array("ActiveTeam", "ActiveTeam_ID") );
	
	if (empty ($URIEncryptedString["ActiveTeam_ID"])) {
		print "<PRE>" . print_r($URIEncryptedString, 1) . "</PRE>";
		print "Problem with TeamID => " . $URIEncryptedString["ActiveTeam_ID"] . "<BR>";
		exit();
	}
	
	//$result = $r->GetSignedElectors($Candidate_ID);
	$EncryptURL = EncryptURL("CandidateID=" . $Candidate_ID . "&PetitionSetID=" . $CandidatePetitionSet_ID);
	
	$TopMenus = array ( 
		array("k" => $k, "url" => "team/index", "text" => "Team Members"),
		array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
		array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
	);			
	WriteStderr($TopMenus, "Top Menu");		
	
	$ListPetitions = $rmb->ListCandidateTeamInformation($URIEncryptedString["ActiveTeam_ID"]);
	WriteStderr($ListPetitions, "ListPetitions");	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Team Management</h2>
				</DIV>
				<?php	PlurialMenu($k, $TopMenus); ?>   
			  <div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
			  		<DIV>
				<P class="f40">
		   		 <B>Current Team:</B> <?= $ActiveTeam ?>
		   		 
		   	<?php WriteStderr($ListTeamNames, "List of name inside the code that are not appearing."); ?>

     	</P>
			</DIV>

				
					
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Team Members <B><?= $ActiveTeam ?></B></div>
					  		</div>
					    </div>
	
							
						<div class="Box-body js-collaborated-repos-empty">
							<div class="flex-items-left">	
								<span class="ml-0 flex-items-baseline ">
									
									
									<DIV class="f40">
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Party</div>
											<div class="table-header-cell">First</div>
											<div class="table-header-cell">Last</div>
											<div class="table-header-cell">AD</div>
											<div class="table-header-cell">ED</div>
											<div class="table-header-cell">TOWN</div>
											<div class="table-header-cell">Sigs.</div>
											<div class="table-header-cell">Done</div>
											<div class="table-header-cell">&nbsp;</div>
										</div>

									
							
									
									<?php 
			if ( ! empty ($ListPetitions) ) {
				foreach ($ListPetitions as $var) {
					if ( ! empty ($var["CandidateSet_Random"]) ) {
						
							
						$NewKEncrypt = CreateEncoded(array(
														"CandidatePetitionSet_ID" => $var["CandidatePetitionSet_ID"],	
														"Candidate_ID" => $var["Candidate_ID"],	
														"PendingBypass" => "yes"								
													));
													
						#						$style = "color:brown;style:bold;background-color:lightgrey;font-weight: bold;";
											
		?>
							
									
									
									
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["SystemUser_Party"] ?>
													
													
													<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= $var["CandidateSet_Random"] ?>/NY/petition">		
															<?= $var["Candidate_DispName"] ?>
															<?php if ( ! empty ($var["Candidate_PetitionNameset"])) { echo "(" . $var["Candidate_PetitionNameset"] . ")"; } ?>
															in <B><?= $var["Candidate_Status"] ?></B> status.</A>
																				
																<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= $var["CandidateSet_Random"] ?>/NY/petition"><i class="fa fa-download"></i></A>
																	
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
																										
													
													</div>
												<div class="table-body-cell"><?= $var["SystemUser_FirstName"] ?></div>
												<div class="table-body-cell"><?= $var["SystemUser_LastName"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_StateAssembly"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Electoral"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrictTown_Name"] ?></div>
												<div class="table-body-cell">0</div>
												<div class="table-body-cell">0</div>
												<div class="table-body-cell"><A HREF="/<?=  CreateEncoded (
																												array( 
																													"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																													"Team_ID" => $_POST["Team_ID"],
																											    "TeamMember_ID" => $var["TeamMember_ID"]
																												)
																									); ?>/lgd/team/memberinfo"">Member Info</A></div>
											</div>													
										</div>
								
								
									
								
									
								<?php }
							}   
										
										} 
							?>

							</DIV>
	</DIV>
	</DIV>
</DIV>

</DIV>
</DIV>
</DIV>
				</DIV>

		</DIV>


	</DIV>

	</DIV>



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>