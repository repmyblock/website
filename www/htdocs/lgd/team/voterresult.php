<?php
	$Menu = "team";  
	//$BigMenu = "represent";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
		
	WriteStderr($_POST, " ========== I AM IN POST PETITION ===========");
		
	if ( ! empty ($_POST)) {
		if ($_POST["voterreg"] == "Create a petition") {
			WriteStderr($_POST, " ========== I AM IN CREATE PETITION ===========");
			
			if ( empty ($_POST["positionid"])) {
				
				header("Location: /" .  CreateEncoded ( array( 
									"SystemUser_ID" => $_POST["SystemUser_ID"],
									"Voters_ID" => $_POST["Voters_ID"],
									"VotersIndexes_ID" => $_POST["VotersIndexes_ID"],
    							"ActiveTeam_ID" => $_POST["ActiveTeam_ID"],
									"errormsg" => "You did not select a position for this person.",
				)) . "/lgd/team/voterresult");
				
			} else {		

				//I don't care anymore about the number of voters in the district.																						
				header("Location: /" .  CreateEncoded ( array( 
									"SystemUser_ID" => $_POST["SystemUser_ID"],
									"Voters_ID" => $_POST["Voters_ID"],
									"UniqNYSVoterID" => $_POST["VotersIndexes_UniqStateVoterID"],						
							    "PetitionStateID" => $_POST["ElectionStateID"],
							    "Voters_RegParty" => $_POST["Voters_RegParty"],
							    "DataState_Abbrev" => $_POST["DataState_Abbrev"],
							    "DataState_ID" => $_POST["DataState_ID"],
							    "AD" => $_POST["AD"],
							    "ED" => $_POST["ED"],
							    "TypeValue[0]" => $_POST["TypeValue"][0],
							    "TypeElection[0]" => $_POST["TypeElection"][0],
							    "PetitionBypass" => 1,
							    "CPrep_District" => $_POST["DataDistrict_ID"],
									"CPrep_PositionCode" => $_POST["positionid"],
									"CPrep_Party" => 	$_POST["Voters_RegParty"],
									"FullName" => 	$_POST["FullName"],
									"AddressLine1" => 	$_POST["AddressLine1"],
									"AddressLine2" => 	$_POST["AddressLine2"],
									"ActiveTeam_ID" => $_POST["ActiveTeam_ID"],
									"County_ID" => $_POST["DataCounty_ID"],
									"Elections_ID" => "1374",
						)) . "/lgd/team/petitionsetup");
				exit();
			}
		} else {
			print "We need to flag the information.";
			exit();
		}
	}
	
	if ( empty ($URIEncryptedString["VotersIndexes_ID"] )) {
		include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
		echo "We did not find the Voter ID information. We Return";
		include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";
		exit();
	} 
		
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$rmbvoters = $rmb->ReturnVoterIndex($URIEncryptedString["VotersIndexes_ID"]);
	WriteStderr($rmbvoters, "ReturnIndex");
	
	if ( empty ($rmbvoters["VotersIndexes_UniqStateVoterID"])) {
		$rmbvoteridx = $rmb->SearchLocalRawDBbyNYSID($rmbvoters["VotersIndexes_UniqStateVoterID"]);
		WriteStderr($rmbvoters, "SearchLocalRawDBbyNYSID");
	
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
	
	// Calculate the address
	

	
	$TopMenus = array ( 
						array("k" => $k, "url" => "team/index", "text" => "Team Members"),
						array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
						array("k" => $k, "url" => "team/teamcandidate", "text" => "Setup Teams")
					);
	WriteStderr($TopMenus, "Top Menu");	

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; $Width="64";} else { $Cols = "col-9"; $Width="16"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Voter Profile</h2>
			  </div>
			    
<?php 
			PlurialMenu($k, $TopMenus);
?>
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
							<?php
							
						if ( ! empty ($rmbvoters )) {
							$var =$rmbvoters;
							WriteStderr($var, "Voter Found");
							
							if ( ! empty ($var)) { 
								
								$ElectionsTypes = $rmb->ListElectedPositions($var["DataState_ID"], "id");
								WriteStderr($ElectionsTypes, "ElectionsTypes");	

								
								
								if (empty ($Query_AD) || ( $var["Raw_Voter_AssemblyDistr"] == $Query_AD)  ) {	
									if ( empty ($Query_ED) || ( $var["Voters_RegParty"] == $Query_ED)  ) {	
										if ( empty ($PARTY) || ($var["Voters_RegParty"] == $PARTY) ) {
															
											$EnrollVoterParty = $var["Voters_RegParty"];
									
											preg_match('/^NY0+(.*)/', $var["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
											$UniqVoterID = "NY" . $UniqMatches[1][0];
											
											$AddressLine1 = "";
											if (! empty ($var["DataAddress_HouseNumber"])) $AddressLine1 .= $var["DataAddress_HouseNumber"] . " "; 
											if (! empty ($var["DataAddress_FracAddress"])) $AddressLine1 .= $var["DataAddress_FracAddress"] . " "; 
											if (! empty ($var["DataAddress_PreStreet"])) $AddressLine1 .= $var["DataAddress_PreStreet"] . " "; 
											if (! empty ($var["DataStreet_Name"])) $AddressLine1 .=  $var["DataStreet_Name"] . " "; 
											if (! empty ($var["DataAddress_PostStreet"])) $AddressLine1 .= $var["DataAddress_PostStreet"] . " "; 
											if (! empty ($var["DataHouse_Apt"])) $AddressLine1 .= "- Apt " . $var["DataHouse_Apt"]; 
											
											$AddressLine2 = $var["DataCity_Name"] . ", " . $var["DataState_Abbrev"] . " ";
											$AddressLine2 .= $var["DataAddress_zipcode"];
											if (! empty ($var["Raw_Voter_ResZip4"])) $AddressLine2 .= " - " . $var["Raw_Voter_ResZip4"];
											
											$FullName = "";
											if ( ! empty ($var["DataFirstName_Text"])) $FullName .= $var["DataFirstName_Text"] . " ";
											if ( ! empty ($var["DataMiddleName_Text"])) { 
												if (strlen($var["DataMiddleName_Text"]) == 1) {
													$FullName .= $var["DataMiddleName_Text"] . ". ";
												} else {													
													$FullName .= $var["DataMiddleName_Text"] . " ";
												}												
										 	}
											if ( ! empty ($var["DataLastName_Text"])) $FullName .= $var["DataLastName_Text"];
											if ( ! empty ($var["VotersIndexes_Suffix"])) $FullName .= $var["VotersIndexes_Suffix"];
											
											
						if ( ! empty ($URIEncryptedString["errormsg"])) {
							
								print "<P CLASS=\"f60\"><FONT COLOR=BROWN><B>" . $URIEncryptedString["errormsg"] . "</B></FONT></P>";
							
							
						}
											
											
				?>
				
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["VotersIndexes_UniqStateVoterID"] ?>" NAME="VotersIndexes_UniqStateVoterID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["DataDistrict_StateAssembly"] ?>" NAME="AD">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["DataDistrict_Electoral"] ?>" NAME="ED">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["Voters_ID"] ?>" NAME="Voters_ID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["VotersIndexes_ID"] ?>" NAME="VotersIndexes_ID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $URIEncryptedString["SystemUser_ID"] ?>" NAME="SystemUser_ID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["Voters_RegParty"] ?>" NAME="Voters_RegParty">		
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["DataState_Abbrev"] ?>" NAME="DataState_Abbrev">				
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["DataState_ID"] ?>" NAME="DataState_ID">	
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["DataDistrict_ID"] ?>" NAME="DataDistrict_ID">				
				<INPUT TYPE="HIDDEN" VALUE="<?= $FullName ?>" NAME="FullName">	
				<INPUT TYPE="HIDDEN" VALUE="<?= $AddressLine1 ?>" NAME="AddressLine1">	
				<INPUT TYPE="HIDDEN" VALUE="<?= $AddressLine2 ?>" NAME="AddressLine2">	
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["DataCounty_ID"] ?>" NAME="DataCounty_ID">	
				<INPUT TYPE="HIDDEN" VALUE="<?= $URIEncryptedString["ActiveTeam_ID"] ?>" NAME="ActiveTeam_ID">	
							
							
							
							
				
				<P>
					<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="<?= $Width ?>" height="<?= $Width ?>" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
					<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $var["Voters_Status"] ?></FONT>
				</P>
					
					<P>
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">First</div>
											<div class="table-header-cell">Middle</div>
											<div class="table-header-cell">Last</div>
											<div class="table-header-cell">Suffix</div>
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["DataFirstName_Text"] ?></div>
												<div class="table-body-cell"><?= $var["DataMiddleName_Text"] ?></div>
												<div class="table-body-cell"><?= $var["DataLastName_Text"] ?></div>
												<div class="table-body-cell"><?= $var["VotersIndexes_Suffix"] ?></div>
											</div>													
										</div>
									</div>
								</P>	
								
								<P>
								
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Assembly</div>
											<div class="table-header-cell">ED</div>
											<div class="table-header-cell">Congress</div>
											<div class="table-header-cell">County</div>
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["DataDistrict_StateAssembly"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Electoral"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Congress"] ?></div>
												<div class="table-body-cell"><?= $var["DataCounty_Name"] ?></div>
											</div>													
										</div>
									</div>
								</P>	
								
								<P>
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Address</div>
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $AddressLine1 ?><BR><?= $AddressLine2 ?></div>
											</div>													
										</div>
									</div>
								</P>	
								
								<P>
								
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Legis</div>
											<div class="table-header-cell">Town</div>
											<div class="table-header-cell">Ward</div>
											<div class="table-header-cell">Senate</div>
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["DataDistrict_Legislative"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrictTown_Name"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Ward"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_StateSenate"] ?></div>
											</div>													
										</div>
									</div>
							
									</P>	
								
								<P>
									
									
									<?php
										$dob = new DateTime($var["VotersIndexes_DOB"]);
	 									$now = new DateTime();
	 									$difference = $now->diff($dob);
									?>
									
								
								
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Date of Birth</div>
											<div class="table-header-cell">Age</div>
											<div class="table-header-cell">Gender</div>
											<div class="table-header-cell">Party</div>
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= PrintShortDate($var["VotersIndexes_DOB"]);  ?></div>
												<div class="table-body-cell"><?= $difference->y; ?></div>
												<div class="table-body-cell"><?= $var["Voters_Gender"] ?></div>
												<div class="table-body-cell"><?= PrintParty($var["Voters_RegParty"]) ?></div>
											</div>													
										</div>
									</div>
								</P>	
								
								<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Council</div>
											<div class="table-header-cell">Civil Court</div>
											<div class="table-header-cell">Judicial</div>
										
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["DataDistrict_Council"] ?>&nbsp;</div>
												<div class="table-body-cell"><?= $var["DataDistrict_CivilCourt"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Judicial"] ?></div>
												
											</div>													
										</div>
									</div>
								
								<P>
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Board of Election ID #</div>
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["Voters_CountyVoterNumber"] ?></div>
											</div>													
										</div>
									</div>
									
								</P>
								
									<P>
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Select Petitions to Create</div>
											<div class="table-header-cell">district</div>
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell-left">
													
													<?php foreach ($ElectionsTypes as $vor) {
														if ( $vor["DataState_ID"] == $var["DataState_ID"]) {
															if (! empty ($vor["ElectionsPosition_Party"])) {
																if ($vor["ElectionsPosition_Party"] == $var["Voters_RegParty"]) {
																	if ($vor["ElectionsPosition_Name"] == "County Committee") {
																		print "<INPUT TYPE=checkbox NAME=positionid VALUE=" . $vor["ElectionsPosition_ID"] . ">&nbsp;";
																		print $vor["ElectionsPosition_Party"] . " " . $vor["ElectionsPosition_Name"] . "&nbsp;";
																		print "<BR>";
																	}
																}
															} else {
																if ($vor["ElectionsPosition_Name"] == "County Committee") {
																	print "<INPUT TYPE=checkbox NAME=positionid VALUE=" . $vor["ElectionsPosition_ID"] . ">&nbsp;";
																	print $var["Voters_RegParty"] . " Primary for " . $vor["ElectionsPosition_Name"] . "&nbsp;";
																	print "<BR>";
																}
															}
														}
													} 
													
													$PetitionDistrict = sprintf('%02d%03d', $var["DataDistrict_StateAssembly"], $var["DataDistrict_Electoral"]);
													
													?>
													</div>
														<INPUT TYPE="hidden" SIZE="4" NAME="TypeElection[0]" VALUE="ADED">
														<div class="table-body-cell"><INPUT TYPE="TEXT" SIZE="4" NAME="TypeValue[0]" VALUE="<?= $PetitionDistrict ?>"></DIV>
											</div>													
										</div>
									</div>
									
								</P>
								
						</div>
						
												<?php		
								}
							}
						}
					}
				}
				?>
		<P class="f60"><CENTER>
						<INPUT type="submit" class="" name="voterreg" VALUE="Create a petition">
					&nbsp;
							<INPUT type="submit" class="" name="voterreg"  VALUE="This voter data need updating">
							<CENTER>
						</P>
					
					
									</FORM>
				</DIV>
				</DIV>
				</DIV>
				</DIV>
				

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
