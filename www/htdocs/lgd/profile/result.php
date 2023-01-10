<?php
	$Menu = "profile";  
	$BigMenu = "represent";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 


  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new RepMyBlock();
	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($rmbperson, "SearchUserVoterCard");
	
	$TopMenus = array (
						array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
						array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
						array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
						array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
					);
							
	if ( ! empty ($_POST)) {
		WriteStderr($_POST, "Post");
		if ($_POST["voterreg"] == "This is my voter registration card") {
			$NumberOfVoterInDistrict = $rmb->FindVotersForEDAD($_POST["AD"], $_POST["ED"], $_POST["Voters_RegParty"]);	
			
			$EDAD =  sprintf('%02d%03d', $_POST["AD"], $_POST["ED"]);
			
			$rmb->UpdateSystemUserWithVoterCard($_POST["SystemUser_ID"], $_POST["Voters_ID"], 
																					$_POST["VotersIndexes_UniqStateVoterID"], $EDAD, 
																					$_POST["DataState_Abbrev"], $_POST["Voters_RegParty"], 
																					count($NumberOfVoterInDistrict));
																							
			header("Location: /" .  CreateEncoded ( array( 
									"SystemUser_ID" => $_POST["SystemUser_ID"],
									"FirstName" => $_POST["FirstName"], 
									"LastName" => $_POST["LastName"],
									"VotersIndexes_ID" => $_POST["Voters_ID"],
									"UniqNYSVoterID" => $_POST["VotersIndexes_UniqStateVoterID"],
									"EDAD" => $EDAD,
									"UserParty" => $_POST["Voters_RegParty"]
						)) . "/lgd/profile/profilevoter");
			exit();
		} else {
			
			
			
			
		}
	}
	
	if ( empty ($URIEncryptedString["VotersIndexes_ID"] )) {
		include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
		echo "We did not find the Voter ID information. We Return";
		include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";
		exit();
	} 
	
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
	
	
	// To be removed later on when I finihs fixing the table.
	$RawVoterNY = $rmb->SearchRawVoterInfo($rmbvoters["VotersIndexes_UniqStateVoterID"]);
	$RawVoterNY = $RawVoterNY[0];
	WriteStderr($RawVoterNY, "RawVoterNY");

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

				<div class="col-12">
			     
				<div class="Box">
					<div class="Box-header pl-0">
						<div class="table-list-filters d-flex">
							<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Voter Card</div>
						</div>
					</div>
				
					<div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
						We don't know your district <a href="/voter">create one</a>?
					</div>
					
					<FORM ACTION="" METHOD=POST>
						<div id="voters">
							<div class="list-group-item filtered f60">
							<?php
							
						if ( ! empty ($rmbvoters )) {
							$var =$rmbvoters;
							WriteStderr($var, "Voter Found");
							
							if ( ! empty ($var)) { 
								if (empty ($Query_AD) || ( $var["Raw_Voter_AssemblyDistr"] == $Query_AD)  ) {	
									if ( empty ($Query_ED) || ( $var["Voters_RegParty"] == $Query_ED)  ) {	
										if ( empty ($PARTY) || ($var["Voters_RegParty"] == $PARTY) ) {
															
											$EnrollVoterParty = $var["Voters_RegParty"];
									
											preg_match('/^NY0+(.*)/', $var["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
											$UniqVoterID = "NY" . $UniqMatches[1][0];
				?>
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["VotersIndexes_UniqStateVoterID"] ?>" NAME="VotersIndexes_UniqStateVoterID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["DataDistrict_StateAssembly"] ?>" NAME="AD">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["DataDistrict_Electoral"] ?>" NAME="ED">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["Voters_ID"] ?>" NAME="Voters_ID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $URIEncryptedString["SystemUser_ID"] ?>" NAME="SystemUser_ID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["Voters_RegParty"] ?>" NAME="Voters_RegParty">		
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["DataState_Abbrev"] ?>" NAME="DataState_Abbrev">				
				
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
												<div class="table-body-cell"><?php if (! empty ($var["DataAddress_HouseNumber"])) echo $var["DataAddress_HouseNumber"]; ?>
											<?php if (! empty ($var["DataAddress_FracAddress"]))  echo $var["DataAddress_FracAddress"]; ?>
											<?php if (! empty ($var["DataAddress_PreStreet"])) echo $var["DataAddress_PreStreet"]; ?>
											<?php if (! empty ($var["DataStreet_Name"])) echo $var["DataStreet_Name"]; ?>
											<?php if (! empty ($var["DataAddress_PostStreet"])) echo $var["DataAddress_PostStreet"]; ?>
											<?php if (! empty ($var["DataHouse_Apt"])) echo " - Apt " . $var["DataHouse_Apt"]; ?>
											<BR>
											<?= $var["DataCity_Name"] . ", " . $var["DataState_Abbrev"] ?>
												<?= $var["DataAddress_zipcode"] ?>
											<?php if (! empty ($var["Raw_Voter_ResZip4"])) echo " - " . $var["Raw_Voter_ResZip4"]; ?></div>
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
								
						</div>
						
												<?php		
								}
							}
						}
					}
				}
					
			?>

						
					<P class="f60"><CENTER>
						<INPUT type="submit" class="" name="voterreg" VALUE="This is my voter registration card">
					&nbsp;
							<INPUT type="submit" class="" name="voterreg"  VALUE="This is NOT my registration card">
							<CENTER>
						</P>
					
				</div>
									</FORM>
				</DIV>
				</DIV>
				</DIV>
				</DIV>
			</DIV>
		</DIV>

	
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
