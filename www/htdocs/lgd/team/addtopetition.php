<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new Teams();
	
	if ( ! empty ($_POST)) {

		// This need to be fixed.		
		$Party = "DEM";
		$CountyID = '120';
		
		/// Check that the Group doesn't exist.
		$CandidatesCheck[] = $URIEncryptedString["Candidate_ID"];
		if ( ! empty ($_POST)) {
			foreach ($_POST["CandidateToAdd"] as $var) {
				$CandidatesCheck[] = $var;
			}
		}
				
		$CheckCandidates = $rmb->CheckCandidateGroups($CandidatesCheck);
		
		foreach ($CheckCandidates as $var) {
			$Check[$var["CandidateSet_ID"]][$var["Candidate_ID"]] = $var["CandidateGroup_ID"];
		}
		
		foreach ($Check as $var => $index) {
			$AllFound = 0;

			foreach ($CandidatesCheck as $vor) {				
				if (empty ($index[$vor])) {
					$AllFound = 1;
				} else {
					if ( $AllFound == 0 ) $AllFound = 2;
				}
			}			
		
			if ( $AllFound == 2 ) { break; }	
		}
	
			
		if ( $AllFound != 2 ) {	
			$Number = $rmb->NextPetitionSet($URIEncryptedString["SystemUser_ID"]);		
			$Counter = 1;
			
			/// I NEED TO SORT BY THE ORDER OF THE DOCUMENT
			foreach ($CandidatesCheck as $var) {
				$rmb->InsertCandidateSet($var, $Number["CandidateSet"], $Party, $CountyID, $Counter++, "yes");
			}
		}
		
		header("Location: /" .  CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
		)) . "/lgd/team/teampetitions");
	
		exit();
	}
	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WipeURLEncrypted( array("ActiveTeam", "ActiveTeam_ID", "Candidate_ID") );
	
	// We need to find all the petition that can be put together.
	WriteStderr($URIEncryptedString, "URIEncryptedString");	

	// I NEED TO FIX THE PARTY HERE
	$OtherCandidatesConvTo = $rmb->FindPositionsInToConv($CurrentElectionID, "DEM", $URIEncryptedString["Candidate_ID"]);
	$OtherCandidatesSame = $rmb->FindPositionsInSame($CurrentElectionID, $URIEncryptedString["ActiveTeam_ID"], $URIEncryptedString["Candidate_ID"]);
	$OtherCandidatesConvFrom = $rmb->FindPositionsInFromConv($CurrentElectionID, "DEM", $URIEncryptedString["Candidate_ID"]);

	WriteStderr($OtherCandidatesConvTo, "OtherCandidatesConvTo");	
	WriteStderr($OtherCandidatesSame, "OtherCandidatesSame");	
	WriteStderr($OtherCandidatesConvFrom, "OtherCandidatesConvFrom");	
	
	$OtherCandidates = array_merge($OtherCandidatesConvFrom, $OtherCandidatesConvTo, $OtherCandidatesSame);

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
			    <h2 class="Subhead-heading">Combine Petitions</h2>
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

				<FORM ACTION="" METHOD="POST">
					
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
											<div class="table-header-cell">&nbsp;</div>
											<div class="table-header-cell">Party</div>
											<div class="table-header-cell">Candidate Name</div>
											<div class="table-header-cell">Type</div>
											<div class="table-header-cell">District</div>
											<div class="table-header-cell">Town</div>
											<div class="table-header-cell">Status</div>
										
										</div>

									
							
									
									<?php 
			if ( ! empty ($OtherCandidates) ) {
				foreach ($OtherCandidates as $var) {
						
							
						$NewKEncrypt = CreateEncoded(array(
														"CandidatePetitionSet_ID" => $var["CandidatePetitionSet_ID"],	
														"Candidate_ID" => $var["Candidate_ID"],	
														"PendingBypass" => "yes"								
													));
													
						#						$style = "color:brown;style:bold;background-color:lightgrey;font-weight: bold;";
											
		?>
							
									
									
									
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><INPUT TYPE="CHECKBOX" NAME="CandidateToAdd[]" VALUE="<?= $var["FindCandidate_ID"] ?>"></div>
												<div class="table-body-cell"><?= $var["FindCandidate_Party"] ?></div>
												<div class="table-body-cell-left"><?= $var["FindCandidate_DispName"] ?></div>
												<div class="table-body-cell"><?= $var["FindCandidate_DBTable"] ?></div>
												<div class="table-body-cell"><?= $var["FindCandidate_DBTableValue"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Electoral"] ?></div>
												<div class="table-body-cell"><?= $var["FindCandidate_Status"] ?></div>
											
											</DIV>	
										</div>
								
								
									
								
									
								<?php }
							}   
										
										
										
										
							?>
								

							</DIV>
							
							
	</DIV>
	
	<p><button type="submit" class="submitred">Congretate these candidates</button></p>
	
	</DIV>
</DIV>

</DIV>
</DIV>
</DIV>
				</DIV>

		</DIV>
</FORM>

	</DIV>

	</DIV>



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>