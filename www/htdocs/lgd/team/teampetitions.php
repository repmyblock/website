<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	if (! empty ($URIEncryptedString["CurrentSelectDate"])) {
		$CurrentSelectDate = $URIEncryptedString["CurrentSelectDate"];
	}
	
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
	
	$prev_interval = "9223372036854775807";
	$prev_absinter = 0;
	$Petitions = array();
	if ( ! empty ($ListPetitions)) {
		foreach ($ListPetitions as $index => $var) {
			if ( ! empty ($var)) {
				
				if ( ! empty ($var["CandidateElection_DBTable"])) {
					preg_match('/(\d{2})(\d{3})/', $var["CandidateElection_DBTableValue"], $District, PREG_OFFSET_CAPTURE);
				}
				
				$interval = time() - strtotime($var["Elections_Date"]);
				if ($interval < $prev_interval ) { $prev_interval = $interval; }
				if ( $prev_interval < 0) {
					$absinter = abs($prev_interval);
					if ( $prev_absinter < $absinter) { $prev_absinter = $absinter; }
				}
				$DateListInterval[$interval] = $var["Elections_Date"];			
					
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["Interval"] = $interval;
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["CandidateID"] = $var["Candidate_ID"];
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["CandidateName"] = $var["Candidate_DispName"];
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["ElectionType"] = $var["CandidateElection_DBTable"];
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["ElectionDistrict"] = $var["CandidateElection_DBTableValue"];
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["Town"] = $var["DataDistrictTown_Name"];
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["TotalSigs"] =  $var["Candidate_StatsVoters"];
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["DoneSigs"] = "0";
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["ED"] = intval($District[2][0]);
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["AD"] = intval($District[1][0]);
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]][$var["Candidate_ID"]]["SystemID"]= $var["Candidate_ID"];			
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]]["Party"]= $var["Candidate_Party"];
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]]["Status"] = $var["Candidate_Status"];
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]]["Random"]= $var["CandidateSet_Random"];			
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]]["Elections_ID"] = $var["Elections_ID"];
				$Petitions[$var["Elections_Date"]][$var["CandidateSet_ID"]]["DataCountyID"] = $var["DataCounty_ID"];
			}
		}
	}
	
	asort($DateListInterval);
	WriteStderr($Petitions, "Petitions");	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Petition management</h2>
				</DIV>
				<?php	PlurialMenu($k, $TopMenus); ?>   
			  <div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
			  		<DIV>
				<P class="f40">
		   		 <B>Current Team:</B> <?= $URIEncryptedString["ActiveTeam"] ?>
		   		 
		   	<?php WriteStderr($ListTeamNames, "List of name inside the code that are not appearing."); ?>

     	</P>
			</DIV>

						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Petitions for <B><?= $URIEncryptedString["ActiveTeam"] ?></B></div>
					  		</div>
					    </div>
	
					
								
							<div class="Box-body js-collaborated-repos-empty">
								<div class="flex-items-left">	
									<span class="ml-0 flex-items-baseline ">
										
											
									<h2>Petitions for <?= PrintShortDate($CurrentSelectDate); ?> election</H2>
									<P CLASS="f60">
									<?php 
										
										foreach ($DateListInterval as $index => $var) {											
											if (! empty ($var)) { 
												if ( $index == -$absinter && empty ($CurrentSelectDate)) {
													$CurrentSelectDate = $var;
												}
												
												if ( $CurrentSelectDate != $var) {
													echo "<B><A HREF=\"/" . CreateEncoded(array(
												 										"CurrentSelectDate" => $var,
																						"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																						"ActiveTeam" => $URIEncryptedString["ActiveTeam"],
																						"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
																					)) . "/lgd/team/teampetitions\">" . PrintDate($var) . "</A></B>&nbsp;";
												}
											}
										}
										?>				
									
										<BR>
										<A HREF="/<?= $k ?>/lgd/team/target">Create petition</A></P>
																	
										<DIV class="p40">
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
											if ( ! empty ($Petitions) ) {
												
												
								
												foreach ($Petitions as $index => $PetitionSet) {
													if ( $index == $CurrentSelectDate) { 
														foreach ($PetitionSet as $SetID => $Candidate ) {
															
													
						
														WriteStderr($Candidate, "\n\n\nCandidate in Candidate");	
														WriteStderr($SetID, "SetID in Petitions");
														
														$NewKEncrypt = CreateEncoded(array(
																						"CandidatePetitionSet_ID" => $var["CandidatePetitionSet_ID"],	
																						"Candidate_ID" => $var["Candidate_ID"],	
																						"PendingBypass" => "yes"								
																					));
			
										?>
	
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $Candidate["Party"] ?></div>
												<div class="table-body-cell-left"><?php 
													
													$MyArrayToPass = array( 
														"CurrentSelectDate" => $CurrentSelectDate,
														"Election_ID" => $Candidate["Elections_ID"],
														"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
														"ActiveTeam" => $URIEncryptedString["ActiveTeam"],
														"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
														"Party" => $Candidate["Party"],
														"DataCountyID" => $Candidate["DataCountyID"],
														
													);
													
													foreach ($Candidate as $CanID => $vor ) { 
														if (! empty ( $Candidate[$CanID]["CandidateName"] )) { 
															echo $Candidate[$CanID]["CandidateName"] . "<BR>"; 
															$MyArrayToPass["CandidateID[]"] = $Candidate[$CanID]["CandidateID"];
														} 
													}
												?><A HREF="/<?= CreateEncoded ( $MyArrayToPass ) . "/lgd/team/addtopetition" ?>">(+ add folks)</A></div>
												<div class="table-body-cell"><?php 
													foreach ($Candidate as $CanID => $vor ) { if (! empty ( $Candidate[$CanID]["ElectionType"] )) { echo $Candidate[$CanID]["ElectionType"] . "<BR>"; } }
												?></div>
												<div class="table-body-cell"><?php 
													foreach ($Candidate as $CanID => $vor ) { if (! empty ( $Candidate[$CanID]["ElectionDistrict"] )) { echo $Candidate[$CanID]["ElectionDistrict"] . "<BR>"; } }
												?></div>
												<div class="table-body-cell"><?php 
													foreach ($Candidate as $CanID => $vor ) { if (! empty ( $Candidate[$CanID]["Town"] )) { echo $Candidate[$CanID]["Town"] . "<BR>"; } }
												?></div>
												<div class="table-body-cell"><?= $Candidate["Status"] ?></div>
												<div class="table-body-cell"><?php 
													foreach ($Candidate as $CanID => $vor ) { if (! empty ( $Candidate[$CanID]["TotalSigs"] )) { echo $Candidate[$CanID]["TotalSigs"] . "<BR>"; } }
												?></div>
												<div class="table-body-cell"><?php 
													foreach ($Candidate as $CanID => $vor ) { if (! empty ( $Candidate[$CanID]["DoneSigs"] )) { echo $Candidate[$CanID]["DoneSigs"] . "<BR>"; } }
												?></div>
												<div class="table-body-cell">
													
													<?php if ( $Candidate["Status"] == "published" ) { ?>
														<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= $Candidate["Random"] ?>/NY/petition"><i class="fa fa-download"></i></A>
														<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/<?= $Candidate["Random"] ?>/NY/petition">Petitions</A>
														<BR>
													<?php } ?>
													
												
													<?php 
													$PrintWalkSheet = false;
													if ( ! empty ($SetID)) { 
														
														foreach ($Candidate as $CanID => $vor ) { 
															if ( $Candidate[$CanID]["ElectionType"] == "ADED" ) { 
																$ED = $Candidate[$CanID]["ED"];
																$AD = $Candidate[$CanID]["AD"];
																$CandidateID = $CanID;
																// echo $Candidate[$CanID]["ElectionType"] . "<BR>"; 
																$PrintWalkSheet = true;
															}	
														}
												} ?>
														
													<?php if ($PrintWalkSheet == true) { ?>
													
													<A TARGET="NEWWALKSHEET<?= $SetID ?>" HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded ( array( 
																								"DataDistrict_ID" => "1",
																								"PreparedFor" => $Candidate[$CandidateID]["CandidateName"],
									
																								"ED" => $ED,
																							  "AD" => $AD,
																							  "Party" => $Candidate["Party"],
																							  "SystemID" => $Candidate["Candidate_ID"]
																							)) . "/rmb/voterlist" ?>">Walksheet</A><BR>
													<?php }  else { ?>
														
														<A TARGET="NEWWALKSHEET<?= $SetID ?>" HREF="/<?= CreateEncoded ( array( 
																								"DataDistrict_ID" => "1",
																								"PreparedFor" => $Candidate[$CandidateID]["CandidateName"],
																									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																									"ActiveTeam" => $URIEncryptedString["ActiveTeam"],
																									"ActiveTeam_ID" => $URIEncryptedString["ActiveTeam_ID"],
																									"ED" => $ED,
																								  "AD" => $AD,
																								  "Party" => $Candidate["Party"],
																								  "SystemID" => $Candidate["Candidate_ID"]
																							)) . "/lgd/walksheets/petitions" ?>">Walksheet</A><BR>
														
														
														
														
														
														
														
													<?php }	?>
													
												</div>
											</div>													
										</div>									
								<?php } }
							}   
										
										} else {
							?>
								<div class="table-body-cell-wide"><BR>No petitions have been defined for this election<BR><A HREF="/<?= $k ?>/lgd/team/target">Create petition</A><BR><BR></div>
							<?php } ?>

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