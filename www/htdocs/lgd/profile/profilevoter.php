<?php
	$Menu = "profile";  
	$BigMenu = "profile";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/DeadlineDates.php"; 
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
 
	
	$rmb = new repmyblock();
	$Party = PrintParty($URIEncryptedString["UserParty"]);
	//	$rmbperson = $rmb->SearchVotersBySingleIndex($URIEncryptedString["VotersIndexes_ID"], $DatedFiles);
	//$rmbperson = $rmb->SearchVoterDBbyNYSID($URIEncryptedString["UniqNYSVoterID"], $DatedFiles);

	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($rmbperson, "SearchUserVoterCard");
	
	 if (empty ($rmbperson["VotersIndexes_ID"]) && empty ($rmbperson["SystemUserSelfDistrict_ID"])) {
	 	 header("Location: /" . $k . "/lgd/profile/input"); 
	 	 exit(); 
	 }
	 
	 if ( empty ($rmbperson["Voters_Status"]) && ! empty($rmbperson["SystemUserSelfDistrict_ID"] )) {
			$rmbperson["Voters_Status"] = "User not in the Voter File";
			$rmbperson["DataLastName_Text"] = ucwords($rmbperson["SystemUser_LastName"]);
			$rmbperson["DataFirstName_Text"] = ucwords($rmbperson["SystemUser_FirstName"]);
			$rmbperson["DataDistrict_StateAssembly"] = $rmbperson["SystemUserSelfDistrict_AD"];
			$rmbperson["DataDistrict_Electoral"] = $rmbperson["SystemUserSelfDistrict_ED"];
			$rmbperson["DataDistrict_Congress"] = $rmbperson["SystemUserSelfDistrict_CG"];
			$rmbperson["DataDistrict_StateSenate"] = $rmbperson["SystemUserSelfDistrict_SN"];
	 		
	 }
	
	// Check the other database
	// To be removed later on when I finihs fixing the table.
	// $RawVoterNY = $rmb->SearchRawVoterInfo($rmbperson["Voters_UniqStateVoterID"]);
	// $RawVoterNY = $RawVoterNY[0];
	// WriteStderr($RawVoterNY, "RawVoterNY");
	
	// Need to go find the right data.

	$TopMenus = array (
						array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
						array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
						array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
						array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
					);
					
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
			     
			<?php	PlurialMenu($k, $TopMenus); ?>
			
			<div class="col-12">

			<?php if (! empty ($ErrorMsg)) { ?>
				
				<div class="mt-0 mb-0">
			    <h3 id="" class="Subhead-heading"><?= $ErrorMsg ?></h3>
			  </div>
				
			<?php } ?>


				<div class="Box">
					<div class="Box-header pl-0">
						<div class="table-list-filters d-flex">
							<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Voter Card</div>
						</div>
					</div>
				
					<div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
						We don't know your district <a href="/voter">create one</a>?
					</div>
					
					<div id="voters">
						<div class="list-group-item filtered f60">
							
							<?php 
								// This need to be updated for the right state						
								preg_match('/^NY0+(.*)/', $rmbperson["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
								$UniqVoterID = $rmbperson["DataState_Abbrev"] . $UniqMatches[1][0]; 
						?>
						
									<P class="f60">
										
										
										<svg class="f60 octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="<?= $Width ?>" height="<?= $Width ?>" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
										<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $rmbperson["Voters_Status"] ?></FONT>
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
												<div class="table-body-cell"><?= $rmbperson["DataFirstName_Text"] ?></div>
												<div class="table-body-cell"><?= $rmbperson["DataMiddleName_Text"] ?></div>
												<div class="table-body-cell"><?= $rmbperson["DataLastName_Text"] ?></div>
												<div class="table-body-cell"><?= $rmbperson["VotersIndexes_Suffix"] ?></div>
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
												<div class="table-body-cell"><?= $rmbperson["DataDistrict_StateAssembly"] ?></div>
												<div class="table-body-cell"><?= $rmbperson["DataDistrict_Electoral"] ?></div>
												<div class="table-body-cell"><?= $rmbperson["DataDistrict_Congress"] ?></div>
												<div class="table-body-cell"><?= $rmbperson["DataCounty_Name"] ?></div>
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
												<div class="table-body-cell"><?php if (! empty ($rmbperson["DataAddress_HouseNumber"])) echo $rmbperson["DataAddress_HouseNumber"]; ?>
											<?php if (! empty ($rmbperson["DataAddress_FracAddress"]))  echo $rmbperson["DataAddress_FracAddress"]; ?>
											<?php if (! empty ($rmbperson["DataAddress_PreStreet"])) echo $rmbperson["DataAddress_PreStreet"]; ?>
											<?php if (! empty ($rmbperson["DataStreet_Name"])) echo $rmbperson["DataStreet_Name"]; ?>
											<?php if (! empty ($rmbperson["DataAddress_PostStreet"])) echo $rmbperson["DataAddress_PostStreet"]; ?>
											<?php if (! empty ($rmbperson["DataHouse_Apt"])) echo " - Apt " . $rmbperson["DataHouse_Apt"]; ?>
											<BR>
											<?= $rmbperson["DataCity_Name"] . ", " . $rmbperson["DataState_Abbrev"] ?>
												<?= $rmbperson["DataAddress_zipcode"] ?>
											<?php if (! empty ($rmbperson["Raw_Voter_ResZip4"])) echo " - " . $rmbperson["Raw_Voter_ResZip4"]; ?></div>
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
												<div class="table-body-cell"><?= $rmbperson["DataDistrict_Legislative"] ?></div>
												<div class="table-body-cell"><?= $rmbperson["DataDistrictTown_Name"] ?></div>
												<div class="table-body-cell"><?= $rmbperson["DataDistrict_Ward"] ?></div>
												<div class="table-body-cell"><?= $rmbperson["DataDistrict_StateSenate"] ?></div>
											</div>													
										</div>
									</div>
							
									</P>	
								
								<P>
									
									
									<?php
										$dob = new DateTime($rmbperson["VotersIndexes_DOB"]);
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
												<div class="table-body-cell"><?= PrintShortDate($rmbperson["VotersIndexes_DOB"]);  ?></div>
												<div class="table-body-cell"><?= $difference->y; ?></div>
												<div class="table-body-cell"><?= $rmbperson["Voters_Gender"] ?></div>
												<div class="table-body-cell"><?= PrintParty($rmbperson["Voters_RegParty"]) ?></div>
											</div>													
										</div>
									</div>
								</P>	
								
								<P>
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Board of Election ID #</div>
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $rmbperson["Voters_CountyVoterNumber"] ?></div>
											</div>													
										</div>
									</div>
									
								</P>
						</div>
						
						<?php /* 	<A HREF="input/?k=<?= $k ?>">
						<p><button type="submit" class="btn btn-primary">Select another Voter Card.</button></p>
						</A> */ ?>

					
					</div>

				</div>
			</div>		
		</div>
	</div>
</DIV>





<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
