<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new Teams();
	
	
	
	if ( ! empty ($_POST)) {		
		
		WriteStderr($URIEncryptedString, "URIEncryptedString");	
		WriteStderr($_POST, "$_POST");	
		
		echo "<PRE>" . print_r($_POST,1 ) . "</PRE>";

		/// Check that the Group doesn't exist.
		$CandidatesCheck[] = $URIEncryptedString["CandidateID"][0];
		if ( ! empty ($_POST)) {
			foreach ($_POST["CandidateToAdd"] as $var) {
				$CandidatesCheck[] = $var;
			}
		}
				
		$CheckCandidates = $rmb->CheckCandidateGroups($CandidatesCheck);
		WriteStderr($CheckCandidates, "CheckCandidates");	
		
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
			WriteStderr($CandidatesCheck, "CandidatesCheck");	
			
			/// I NEED TO SORT BY THE ORDER OF THE DOCUMENT
			foreach ($CandidatesCheck as $var) {
				
			
				$rmb->InsertCandidateSet($var, $Number["CandidateSet"], $URIEncryptedString["Party"], $URIEncryptedString["DataCountyID"], $Counter++, "yes");
			}
		}
		
		
		header("Location: /" .  CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
		)) . "/lgd/team/teampetitions");
	
		exit();
	}
	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WipeURLEncrypted( array("ActiveTeam", "ActiveTeam_ID", "Election_ID", "Party", "CandidateID", "DataCountyID", "Candidate_ID") );
	
	// We need to find all the petition that can be put together.
	WriteStderr($URIEncryptedString, "URIEncryptedString");	
	
	/*
		[LastTimeUser] => 1678555168
	  [CurrentSelectDate] => 2023-06-27
    [SystemUser_ID] => 106
    [ActiveTeam_ID] => 62
    [Party] => DEM
	*/
	
	#$Candidate

	// I NEED TO FIX THE PARTY HERE
	$IDTOCHECK = $URIEncryptedString["CandidateID"][0];
	#print "IDTOCHECK: $IDTOCHECK<BR>";
	
	$CandidateInfo = $rmb->ReturnCandidateInformation($IDTOCHECK);
	$OtherCandidatesToAdd = $rmb->FindPositions($URIEncryptedString["Election_ID"], $URIEncryptedString["Party"], $CandidateInfo["CandidateElection_DBTable"], $CandidateInfo["CandidateElection_DBTableValue"]);
	WriteStderr($OtherCandidatesToAdd, "OtherCandidatesToAdd");	
	
	#print "<PRE>" . print_r($OtherCandidatesToAdd, 1) . "</PRE>";
	#exit();

	$EncryptURL = EncryptURL("CandidateID=" . $Candidate_ID . "&PetitionSetID=" . $CandidatePetitionSet_ID);
	
	$TopMenus = array ( 
		array("k" => $k, "url" => "team/index", "text" => "Team Members"),
		array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
		array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
	);			
	WriteStderr($TopMenus, "Top Menu");		
	
	#$ListPetitions = $rmb->ListCandidateTeamInformation($URIEncryptedString["ActiveTeam_ID"]);
	#WriteStderr($ListPetitions, "ListPetitions");	
	
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
									$CounterPrintedCandidate = 0;
			if ( ! empty ($OtherCandidatesToAdd) ) {
				foreach ($OtherCandidatesToAdd as $var) {
						WriteStderr($var, "var"); 
						
						if ( $var["Team_ID"] == $URIEncryptedString["ActiveTeam_ID"] && $var["Candidate_ID"] != $IDTOCHECK) {
						#print "<PRE>" . print_r($OtherCandidatesToAdd, 1) . "</PRE>";
						#echo "nothing?<PRE>" . print_r($var, 1) . "</PRE>";
							$CounterPrintedCandidate++;
						$NewKEncrypt = CreateEncoded(array(
														"CandidatePetitionSet_ID" => $var["CandidatePetitionSet_ID"],	
														"Candidate_ID" => $var["Candidate_ID"],	
														"Party" => $var["Candidate_Party"],
														"CountyID" => $var["DataCounty_ID"],	
													));
													
						#						$style = "color:brown;style:bold;background-color:lightgrey;font-weight: bold;";
											
		?>		
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><INPUT TYPE="CHECKBOX" NAME="CandidateToAdd[]" VALUE="<?= $var["Candidate_ID"] ?>"></div>
												<div class="table-body-cell"><?= $var["Candidate_Party"] ?></div>
												<div class="table-body-cell-left"><?= $var["Candidate_DispName"] ?></div>
												<div class="table-body-cell"><?= $var["CandidateElection_DBTable"] ?></div>
												<div class="table-body-cell"><?= $var["CandidateElection_DBTableValue"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Electoral"] ?></div>
												<div class="table-body-cell"><?= $var["Candidate_Status"] ?></div>
											
											</DIV>	
										</div>
								
								
									
								
									
								<?php }
							}   
						} 
						
						
						
						if ( $CounterPrintedCandidate == 0) {
						  ?>
							
							
							<div class="table-body-cell-wide"><BR>No candidates are in the district to create an omnibus petition<BR><A HREF="/<?= $k ?>/lgd/team/target">Create petition</A><BR><BR></div>
							
							
							
							<?php 
							} 
										
										
										
										
							?>
								

							</DIV>
							
							
	</DIV>
	<?php if ( $CounterPrintedCandidate > 0) {
						  ?>
	<p><button type="submit" class="submitred">Congretate these candidates</button></p>
	
<?php } ?>
	
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