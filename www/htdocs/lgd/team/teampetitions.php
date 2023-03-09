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
										
											<P CLASS="f60"><A HREF="/<?= $k ?>/lgd/team/target">Create petition</A></P>
										
										
										<DIV class="f40">
										<div id="resp-table">
											<div id="resp-table-header">
												<div class="table-header-cell">Party</div>
												<div class="table-header-cell">Candidate Name</div>
												<div class="table-header-cell">Type</div>
												<div class="table-header-cell">District</div>
												<div class="table-header-cell">Town</div>
												<div class="table-header-cell">Status</div>
												<div class="table-header-cell">Sigs.</div>
												<div class="table-header-cell">Done</div>
												<div class="table-header-cell">&nbsp;</div>
											</div>

									
							
									
									<?php 
			if ( ! empty ($ListPetitions) ) {
				foreach ($ListPetitions as $var) {
					if ( ! empty ($var["CandidateSet_ID"]) ) {
						
							WriteStderr($var, "VAR in Petitions");	
						$NewKEncrypt = CreateEncoded(array(
														"CandidatePetitionSet_ID" => $var["CandidatePetitionSet_ID"],	
														"Candidate_ID" => $var["Candidate_ID"],	
														"PendingBypass" => "yes"								
													));
													
						#						$style = "color:brown;style:bold;background-color:lightgrey;font-weight: bold;";
											 
													
						$GetCandidatesForSet = $rmb->ListPetitionGroup($var["CandidateSet_ID"]);
						WriteStderr($GetCandidatesForSet, "GetCandidatesForSet");	
						
						if ( ! empty ($var["CandidateElection_DBTable"])) {
							preg_match('/(\d{2})(\d{3})/', $var["CandidateElection_DBTableValue"], $District, PREG_OFFSET_CAPTURE);
						}
										
		?>
	
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["Candidate_Party"] ?></div>
												<div class="table-body-cell-left"><?php 
													foreach ($GetCandidatesForSet as $vor) { if (! empty ($vor)) { echo $vor["Candidate_DispName"] . "<BR>"; } }
												?><A HREF="/<?= CreateEncoded ( array( 
																								"SystemUser_ID" => $var["SystemUser_ID"],
																								"ActiveTeam_ID" => $var["Team_ID"],
																								"Candidate_ID" => $var["Candidate_ID"],
																								"ActiveTeam" => $URIEncryptedString["ActiveTeam"],
																					)) . "/lgd/team/addtopetition" ?>">(+ add folks)</A></div>
												<div class="table-body-cell"><?php 
													foreach ($GetCandidatesForSet as $vor) { if (! empty ($vor)) { echo $vor["CandidateElection_DBTable"] . "<BR>"; } }
												?></div>
												<div class="table-body-cell"><?php 
													foreach ($GetCandidatesForSet as $vor) { if (! empty ($vor)) { echo $vor["CandidateElection_DBTableValue"] . "<BR>"; } }
													
												?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Electoral"] ?></div>
												<div class="table-body-cell"><?= $var["Candidate_Status"] ?></div>
												<div class="table-body-cell">0</div>
												<div class="table-body-cell">0</div>
												<div class="table-body-cell">
													
														<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= $var["CandidateSet_Random"] ?>/NY/petition"><i class="fa fa-download"></i></A>
														
														<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= $var["CandidateSet_Random"] ?>/NY/petition">Petitions</A>
													
													<?php if ( ! empty ($var["CandidateElection_DBTable"])) { ?>			
														<BR><A TARGET="NEWWALKSHEET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded ( array( 
																								"DataDistrict_ID" => "1",
																								"PreparedFor" => $var["Candidate_DispName"],
																								"ED" => $District[2][0],
																							  "AD" => $District[1][0],
																							  "Party" => $var["Candidate_Party"],
																							  "SystemID" => $var["Candidate_ID"]
																							)) . "/rmb/voterlist" ?>">Walksheet</A><BR>
													<?php } ?>
													
												</div>
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