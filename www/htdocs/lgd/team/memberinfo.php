<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_teams.php";
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  
  $rmb = new Teams();
  
  if (! empty ($_POST)) {
  	WriteStderr($URIEncryptedString, "URIEncryptedString");
  	WriteStderr($_POST, "POST to ... ");
  	
  	switch($_POST["Invitation"]) {
  		case 'yes':
  			$rmb->UpdateVolunteerTeam($_POST["Invitation"], $URIEncryptedString["TeamMember_ID"], $URIEncryptedString["SystemUser_ID"], trim($_POST["RMBNote"]));
  			header("Location: memberinfo");
  			break;
				
			case 'no':
  		case 'declined':
  		case 'banned':
  			$rmb->UpdateVolunteerTeam($_POST["Invitation"], $URIEncryptedString["TeamMember_ID"], $URIEncryptedString["SystemUser_ID"], trim($_POST["RMBNote"]));  			
  			header("Location: index");
  			break;  			
  	}
  		  	
  	
  		  	
  	exit();

  } else {
 		$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
		$rmbteamuser = $rmb->ReturnMemberFromTeam($URIEncryptedString["TeamMember_ID"]);
		WriteStderr($rmbteamuser, "RMBTEAMUSER:");
		$ActiveTeam = $rmbteamuser["Team_Name"];
		$ActiveTeamID = $rmbteamuser["Team_ID"];
		$StatusMemberActive = $rmbteamuser["TeamMember_Active"];
		$FullName = $rmbteamuser["SystemUser_FirstName"] . " " . $rmbteamuser["SystemUser_LastName"];
		$rmbteammember = $rmb->SearchUserVoterCard($rmbteamuser["TeamSystemUser_ID"]);
	}
	
	
	$PrevMenu = "index";
	if (! empty ($URIEncryptedString["ReturnToScript"])) {
		$PrevMenu = $URIEncryptedString["ReturnToScript"];
	}
	
	// This is to prepare the information so it display correctly
	
	// Address Line 1
	if (! empty ($rmbteammember["DataAddress_HouseNumber"])) $VoterAddress_Line1 = $rmbteammember["DataAddress_HouseNumber"];
	if (! empty ($rmbteammember["DataAddress_FracAddress"]))  $VoterAddress_Line1 .= " " . $rmbteammember["DataAddress_FracAddress"]; 
	if (! empty ($rmbteammember["DataAddress_PreStreet"])) $VoterAddress_Line1 .= " " . $rmbteammember["DataAddress_PreStreet"]; 
	if (! empty ($rmbteammember["DataStreet_Name"])) $VoterAddress_Line1 .= " " . $rmbteammember["DataStreet_Name"]; 
	if (! empty ($rmbteammember["DataAddress_PostStreet"])) $VoterAddress_Line1 .= " " . $rmbteammember["DataAddress_PostStreet"]; 
	if (! empty ($rmbteammember["DataHouse_Apt"])) $VoterAddress_Line1 .= " - Apt " . $rmbteammember["DataHouse_Apt"]; 
					
	// Adress Line 2		
	$VoterAddress_Line2 = $rmbteammember["DataCity_Name"] . ", " . $rmbteammember["DataState_Abbrev"];
	$VoterAddress_Line2 .= " " . $rmbteammember["DataAddress_zipcode"];
	if (! empty ($rmbteammember["DataAddress_zipcode"])) $VoterAddress_Line2 .= " - " . $rmbteammember["DataAddress_zip4"];
	
	// Full Voter Name
	$VoterFullName = $rmbteammember["DataFirstName_Text"];
	if ( ! empty ($rmbteammember["DataMiddleName_Text"])) { $VoterFullName .= " " . substr($rmbteammember["DataMiddleName_Text"], 0, 1) . "."; }
	$VoterFullName .= " " . $rmbteammember["DataLastName_Text"];
	if ( ! empty ($rmbteammember["VotersIndexes_Suffix"])) { $VoterFullName .= strtoupper($rmbteammember["VotersIndexes_Suffix"]); }
	

	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left col-full">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 class="Subhead-heading">Voter Information</h2>
				</DIV>

				<div class="clearfix gutter">
			  	<div class="row">
				  <div class="main">
			  	
			  	<DIV>
				<P class="f40">
		   		 <B>Current Team:</B> <?= $ActiveTeam ?>
     		</P>

			  <div class="clearfix gutter">

		<div class="row">
		  <div class="main">
				<div class="Box">
			  	<div class="Box-header pl-0">
			    	<div class="table-list-filters d-flex">
			  			<div class="table-list-header-toggle states flex-justify-start pl-3">Voter Information for <B><?= $FullName  ?></B></div>
			  		</div>
			    </div>
			    
			     <div class="Box-body  js-collaborated-repos-empty">
			     	<?php if($rmbteamuser["TeamSystemUser_ID"] == $rmbperson["SystemUser_ID"]) { ?>
			     		<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 2px;" BGCOLOR=BLACK ALIGN=RIGHT><FONT COLOR=WHITE>You are the team owner</FONT></TH>
							</TR>
						</TABLE>
						<?php } ?>
					
					 	&nbsp;<a href="<?= $PrevMenu ?>">Return to previous screen</a>
					 </div>

			    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
			      We don't know your district <a href="/voter">create one</a>?
			    </div>
			    
					<?php 			
						$Counter = 0;
						//if ( ! empty ($rmbteaminfo)) {								
					?>
					
					

					
					<div id="voters">
					<div class="list-group-item filtered">						
						
						
							
						<?php 
							// This need to be updated for the right state						
							preg_match('/^NY0+(.*)/', $rmbteammember["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
							$UniqVoterID = $rmbteammember["DataState_Abbrev"] . $UniqMatches[1][0]; 
						?>
						
						<P>
							<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
							<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $rmbperson["Voters_Status"] ?></FONT>
						</P>
						
						
						<?php if ($StatusMemberActive == "pending") { ?>
							<FORM ACTION="" METHOD="POST">
							<P CLASS="f60">
								This user is in pending mode
								
								<dt><p>
									<SELECT NAME="Invitation">
										<OPTION VALUE="">&nbsp;</OPTION>
										<OPTION VALUE="yes">Accept</OPTION>
										<OPTION VALUE="declined">Decline</OPTION>
										<OPTION VALUE="banned">Ban</OPTION>
									</SELECT>
									<button class="submitred">Accept the request</BUTTON></p>
										
							<P CLASS="f60">
									Optional note for other admins
								</P>
								
								
									<INPUT TYPE="text" NAME="RMBNote" VALUE="" size="50%" Placeholder="Type an optional note for other admins">
								
							</DT>
							</FORM>
							</P>
						<?php } ?>		
						
						
					
						
						<BR>
						
						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">First</TH>
								<TH style="padding:0px 10px;">Middle</TH>
								<TH style="padding:0px 10px;">Last</TH>
								<TH style="padding:0px 10px;">Suffix</TH>
							</TR>
							<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataFirstName_Text"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataMiddleName_Text"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataLastName_Text"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["VotersIndexes_Suffix"] ?></TD>
							</TR>
						</TABLE>

						<BR>

						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Email Address</TH>
							</TR>
							<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= $rmbteammember["SystemUser_email"] ?></TD>
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
								$dob = new DateTime($rmbteammember["VotersIndexes_DOB"]);
								$now = new DateTime();
								$difference = $now->diff($dob);
							?>
							<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= PrintShortDate($rmbteammember["VotersIndexes_DOB"]); ?></TD>
								<TD style="padding:0px 10px;"><?= $difference->y; ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["Voters_Gender"] ?></TD>
								<TD style="padding:0px 10px;"><?= PrintParty($rmbteammember["Voters_RegParty"]) ?></TD>
							</TR>
						</TABLE>					

						<BR>

						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Address</TH>
							</TR>

							<TR>
								<TD style="padding:0px 10px;">		
									<?= $VoterAddress_Line1 ?>
									<BR>
									<?= $VoterAddress_Line2 ?>
									<BR>
								</TD>
							</TR>
						</TABLE>
					
						<BR>

						<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Board of Election ID #</TH>
							</TR>
								<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><?= $rmbteammember["Voters_CountyVoterNumber"] ?></TD>
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
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataDistrict_StateAssembly"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataDistrict_Electoral"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataDistrict_Congress"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataCounty_Name"] ?></TD>
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
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataDistrict_Legislative"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataDistrictTown_Name"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataDistrict_Ward"] ?></TD>
								<TD style="padding:0px 10px;"><?= $rmbteammember["DataDistrict_StateSenate"] ?></TD>
							</TR>
						</TABLE>
			
						<BR>
						
						
						<?php if ($StatusMemberActive == "yes") { 
							
								
							
							
							?>
							<P CLASS="f60">
								
														
	
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
			
			
		
														
														
								<A HREF="/<?= CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
									"VoterSystemUser_ID" => $rmbteammember["SystemUser_ID"],
									"VotersIndexes_ID" => $rmbteammember["Voters_ID"],
									"UniqNYSVoterID" => $rmbteammember["VotersIndexes_UniqStateVoterID"],						
							    "PetitionStateID" => $rmbteammember["ElectionStateID"],
							    "CPrep_First" => $rmbteammember["DataFirstName_Text"],
							    "CPrep_Last" => $rmbteammember["DataLastName_Text"],
							    "CPrep_Full" => $VoterFullName,
							    "CPrep_Address1" => $VoterAddress_Line1,
							    "CPrep_Address2" => $VoterAddress_Line2,
							    "CPrep_District" => $rmbteammember["DataDistrict_ID"],
									"CPrep_PositionCode" => "ADED",
									"CPrep_Party" => $rmbteammember["Voters_RegParty"],
									"CPrep_Gender" => $rmbteammember["Voters_Gender"],
									"CPrep_State" => $rmbteammember["DataState_Abbrev"],
									"Voters_ID" => $rmbteammember["Voters_ID"],
									"Team_ID" => $ActiveTeamID,
	
									"Voters_ID" => $rmbteammember["Voters_ID"],
									"VotersIndexes_ID" => $vrmbteammemberar["VotersIndexes_ID"],
									"ED" =>  $rmbteammember["DataDistrict_Electoral"],
									"AD" => $rmbteammember["DataDistrict_StateAssembly"],
									"Party" => $rmbteammember["Voters_RegParty"],
									"PreparedFor" => $rmbteammember["DataFirstName_Text"] . " " . $rmbteammember["DataLastName_Text"],
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"], 
									"SystemAdmin" =>  $URIEncryptedString["SystemAdmin"],
									"ActiveTeam_ID" => $ActiveTeamID,
									"PetitionBypass" => true,

						)) . "/lgd/team/petitionsetup" ?>">Prepare a petition</A>
						

						
								<A TARGET="NEWWALKSHEET" HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded ( array( 
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
											"ActiveTeam_ID" => $ActiveTeamID,
											"TeamPerson" =>  $rmbperson["DataFirstName_Text"] . " " . $rmbperson["DataLastName_Text"],
										
											"Voters_ID" => $rmbteammember["Voters_ID"],
											"VotersIndexes_ID" => $vrmbteammemberar["VotersIndexes_ID"],
						          "ED" =>  $rmbteammember["DataDistrict_Electoral"],
						          "AD" => $rmbteammember["DataDistrict_StateAssembly"],
						          "Party" => $rmbteammember["Voters_RegParty"],
											"PreparedFor" => $rmbteammember["DataFirstName_Text"] . " " . $rmbteammember["DataLastName_Text"],
											"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"], 
											"SystemAdmin" =>  $URIEncryptedString["SystemAdmin"],
													
								)) . "/rmb/voterlist" ?>">Prepare a walksheet</A>
							</P>
							
							<?php if($rmbteamuser["TeamSystemUser_ID"] == $rmbperson["SystemUser_ID"]) { ?>
								<A HREF="">Turn onwership of the <?= $ActiveTeamMember ?> to another admin</A><BR>
							<?php } ?>
							
							<?php 
									// If am an admin, I can give the access to someone to help
							
							
							?>
									
					 		<a href="<?= $PrevMenu ?>">Return to previous screen</a>

						<?php } ?>
					</span>
				</div>

				<?php						
				///			} 
				?>
								</div>
							</div>
							<BR>

					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>

</DIV>
</div>
</div>
</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
