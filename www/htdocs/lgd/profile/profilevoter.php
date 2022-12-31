<?php
	$Menu = "profile";  
	$BigMenu = "profile";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/DeadlineDates.php"; 
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if (empty ($URIEncryptedString["VotersIndexes_ID"])) { header("Location: /" . $k . "/lgd/profile/input"); exit(); }
	
	$rmb = new repmyblock();
	$Party = PrintParty($URIEncryptedString["UserParty"]);
	//	$rmbperson = $rmb->SearchVotersBySingleIndex($URIEncryptedString["VotersIndexes_ID"], $DatedFiles);
	//$rmbperson = $rmb->SearchVoterDBbyNYSID($URIEncryptedString["UniqNYSVoterID"], $DatedFiles);

	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($rmbperson, "SearchUserVoterCard");
	
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
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
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
											
						<div class="list-group-item filtered f40">
							
							<?php 
								// This need to be updated for the right state						
								preg_match('/^NY0+(.*)/', $rmbperson["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
								$UniqVoterID = $rmbperson["DataState_Abbrev"] . $UniqMatches[1][0]; 
						?>
						
									<P>
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $rmbperson["Voters_Status"] ?></FONT>
									</P>
									
									
									
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">First</TH>
										<TH style="padding:0px 10px;">Middle</TH>
										<TH style="padding:0px 10px;">Last</TH>
										<TH style="padding:0px 10px;">Suffix</TH>
									</TR>
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataFirstName_Text"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataMiddleName_Text"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataLastName_Text"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["VotersIndexes_Suffix"] ?></TD>
									</TR>
								</TABLE>
									
									<BR>
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">Assembly</TH>
										<TH style="padding:0px 10px;">Electoral</TH>
										<TH style="padding:0px 10px;">Congress</TH>
										<TH style="padding:0px 10px;">County</TH>
									</TR>
																		
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataDistrict_StateAssembly"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataDistrict_Electoral"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataDistrict_Congress"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataCounty_Name"] ?></TD>
									</TR>
								</TABLE>
									<BR>
								
													
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">Address</TH>
							
									</TR>
									<TR>
										<TD style="padding:0px 10px;">		
											<?php if (! empty ($rmbperson["DataAddress_HouseNumber"])) echo $rmbperson["DataAddress_HouseNumber"]; ?>
											<?php if (! empty ($rmbperson["DataAddress_FracAddress"]))  echo $rmbperson["DataAddress_FracAddress"]; ?>
											<?php if (! empty ($rmbperson["DataAddress_PreStreet"])) echo $rmbperson["DataAddress_PreStreet"]; ?>
											<?php if (! empty ($rmbperson["DataStreet_Name"])) echo $rmbperson["DataStreet_Name"]; ?>
											<?php if (! empty ($rmbperson["DataAddress_PostStreet"])) echo $rmbperson["DataAddress_PostStreet"]; ?>
											<?php if (! empty ($rmbperson["DataHouse_Apt"])) echo " - Apt " . $rmbperson["DataHouse_Apt"]; ?>
											<BR>
											<?= $rmbperson["DataCity_Name"] . ", " . $rmbperson["DataState_Abbrev"] ?>
												<?= $rmbperson["DataAddress_zipcode"] ?>
											<?php if (! empty ($rmbperson["Raw_Voter_ResZip4"])) echo " - " . $rmbperson["Raw_Voter_ResZip4"]; ?>
											<BR>
										</TD>
									</TR>
								</TABLE>
								
								
								
								
								<BR>
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">Legis #</TH>
										<TH style="padding:0px 10px;">Town</TH>
										<TH style="padding:0px 10px;">Ward</TH>
										<TH style="padding:0px 10px;">Senate</TH>
									</TR>
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataDistrict_Legislative"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataDistrictTown_Name"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataDistrict_Ward"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["DataDistrict_StateSenate"] ?></TD>
					
									</TR>
								</TABLE>
									<BR>
									
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">Date of Birth</TH>
										<TH style="padding:0px 10px;">Age</TH>
										<TH style="padding:0px 10px;">Gender</TH>
										<TH style="padding:0px 10px;">Party</TH>
									</TR>
									<?php
										$dob = new DateTime($rmbperson["VotersIndexes_DOB"]);
	 									$now = new DateTime();
	 									$difference = $now->diff($dob);
									?>
									
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= PrintShortDate($rmbperson["VotersIndexes_DOB"]); ?></TD>
										<TD style="padding:0px 10px;"><?= $difference->y; ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbperson["Voters_Gender"] ?></TD>
										<TD style="padding:0px 10px;"><?= PrintParty($rmbperson["Voters_RegParty"]) ?></TD>
									</TR>
								</TABLE>
									<BR>
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">Board of Election ID #</TH>
									</TR>
									
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= $rmbperson["Voters_CountyVoterNumber"] ?></TD>
									</TR>
								</TABLE>
								
								
				
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
