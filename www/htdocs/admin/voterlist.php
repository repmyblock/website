<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
		 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php"; 
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	
	$rmb = new RMBAdmin();
		
	WriteStderr($URIEncryptedString["Query_DBType"], "Query_DBType Variable");
	
	// This is the query search.
	// need to calculate the County Code from $URIEncryptedString["Query_COUNTY"] to
	//CountyCode
		
	$QueryFields = array(	
		"UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
		"FirstName" => $URIEncryptedString["Query_FirstName"], 
		"LastName" => $URIEncryptedString["Query_LastName"],
		"ResZip" => $URIEncryptedString["Query_ZIP"], 
		"CountyCode" => $CountyCode,
		"EnrollPolParty" => $URIEncryptedString["Query_PARTY"], 
		"AssemblyDistr" => $URIEncryptedString["Query_AD"],
		"ElectDistr" => $URIEncryptedString["Query_ED"], 
		"CongressDistr" => $URIEncryptedString["Query_Congress"],
		"HouseNumber" => $URIEncryptedString["Query_HouseNumber"],
		"Address" => $URIEncryptedString["Query_Address"],
	);
	
	WriteStderr($QueryFields, "Query to be sent");
	$Result = $rmb->AdminSearchVoterDB($QueryFields);
		
	WriteStderr($Result, "RESULT to check if empty");
	if ( empty ($Result)) {
		$ErrorMsg = "Voter not found";
		header("Location: /" .  CreateEncoded ( array( 	
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
								"FirstName" => $URIEncryptedString["FirstName"],
								"LastName" => $URIEncryptedString["LastName"],
								"UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
								"UserParty" => $URIEncryptedString["UserParty"],
								"MenuDescription" => $URIEncryptedString["MenuDescription"],
								"RetReturnFirstName" => $URIEncryptedString["Query_FirstName"],
								"RetReturnLastName" => $URIEncryptedString["Query_LastName"],
								"RetReturnAD" => $URIEncryptedString["Query_AD"],
								"RetReturnED" => $URIEncryptedString["Query_ED"],
								"RetReturnZIP" => $URIEncryptedString["Query_ZIP"],
								"RetReturnCOUNTY" => $URIEncryptedString["Query_COUNTY"],
								"RetReturnPARTY" => $URIEncryptedString["Query_PARTY"],
								"RetReturnNYSBOEID" => $URIEncryptedString["Query_NYSBOEID"],
								"RetReturnCongress" => $URIEncryptedString["Query_Congress"],
								"ErrorMsg" => $ErrorMsg								
					)) . "/admin/voterlookup");
		exit();
	}
	
	$Party = PrintParty($UserParty);
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($URIEncryptedString, "URIEncryptedString");
	WriteStderr($rmbperson, "rmbperson");
	WriteStderr($Result, "Result of the QUery");
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Voter Lookup Result</h2>
				</div>

				<form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
				<div class="list-group-item filtered f60 hundred">
					<span><B>Voter List</B></span>  	          			
				</div>
					
			 	<DIV class="panels">		
				<?php

				if ( ! empty ($Result)) {
					
					// Check the entries;
					foreach ($Result as $index => $var) {
						if ($VoterProfile[$var["VotersIndexes_UniqStateVoterID"]] >  $var["Voters_RecLastSeen"]) {
							$VoterProfile[$var["VotersIndexes_UniqStateVoterID"]] = $var["Voters_RecLastSeen"];
							$VoterIndexToShow[$var["VotersIndexes_UniqStateVoterID"]] = $index;
						} else {
							$VoterProfile[$var["VotersIndexes_UniqStateVoterID"]] = $var["Voters_RecLastSeen"];
							$VoterIndexToShow[$var["VotersIndexes_UniqStateVoterID"]] = $index;
						}
					}
						
					#echo "INDEX : " . $VoterIndexToShow[$var["VotersIndexes_UniqStateVoterID"]] . "<BR>";
					#echo "PROFILE: " . $Result[$VoterIndexToShow[$var["VotersIndexes_UniqStateVoterID"]]]["VotersIndexes_UniqStateVoterID"] . " => " . $VoterProfile[$var["VotersIndexes_UniqStateVoterID"]] . "<BR>";
					
					// This is to print if the count is more than 1
					if ( count($VoterIndexToShow) > 1) {
						
						// We need to organize the data 
						
						
					
						
						
						?>
						
						<div class="list-group-item f60">
							<TABLE BORDER=1>
							<TR>
								<TH style="padding:0px 10px;">Voter ID</TH>
								<TH style="padding:0px 10px;">Status</TH>					
								<TH style="padding:0px 10px;">First</TH>
								<TH style="padding:0px 10px;">Middle</TH>
								<TH style="padding:0px 10px;">Last</TH>
								<TH style="padding:0px 10px;">Suffix</TH>
								<TH style="padding:0px 10px;">AD</TH>
								<TH style="padding:0px 10px;">ED</TH>
								<TH style="padding:0px 10px;">County</TH>
								<TH style="padding:0px 10px;">Age</TH>
								<TH style="padding:0px 10px;">Sex</TH>
								<TH style="padding:0px 10px;">Party</TH>
								<TH style="padding:0px 10px;">City</TH>
								<TH style="padding:0px 10px;">State</TH>
								<TH style="padding:0px 10px;">Zip</TH>
							</TR>
						
						
						<?php 
						
						
					
						foreach ($Result as $var) {
							
							if ( ! empty ($var)) { 
								if (empty ($Query_AD) || ( $var["Raw_Voter_AssemblyDistr"] == $Query_AD)  ) {	
									if ( empty ($Query_ED) || ( $var["Raw_Voter_ElectDistr"] == $Query_ED)  ) {	
										if ( empty ($PARTY) || ($var["Raw_Voter_EnrollPolParty"] == $PARTY) ) {
															
											preg_match('/^NY0+(.*)/', $var["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
											$UniqVoterID = "NY" . $UniqMatches[1][0];
										}
									}
								}
							}
						?>
						
						
							<TR ALIGN=CENTER>
								<TD style="padding:0px 10px;"><A HREF="/<?= CreateEncoded ( array( 	
																"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
																"UserDetail" => $var["SystemUser_ID"],
																"UniqNYSVoterID" => $var["VotersIndexes_UniqStateVoterID"],
																)) ?>/admin/voterlist"><?= $UniqVoterID ?></A></TD>
								<TD style="padding:0px 10px;"><?= $var["Voters_Status"] ?></TD>
							
								<TD style="padding:0px 10px;"><?= $var["DataFirstName_Text"] ?></TD>
								<TD style="padding:0px 10px;"><?= $var["DataMiddleName_Text"] ?></TD>
								<TD style="padding:0px 10px;"><?= $var["DataLastName_Text"] ?></TD>
								<TD style="padding:0px 10px;"><?= $var["VotersIndexes_Suffix"] ?></TD>
							
								<TD style="padding:0px 10px;"><?= $var["DataDistrict_StateAssembly"] ?></TD>
								<TD style="padding:0px 10px;"><?= $var["DataDistrict_Electoral"] ?></TD>
								<TD style="padding:0px 10px;"><?= $var["DataCounty_Name"] ?></TD>
											
											

								<TD style="padding:0px 10px;"><?php
												$dob = new DateTime($var["VotersIndexes_DOB"]);
			 									$now = new DateTime();
			 									$difference = $now->diff($dob);
			 									echo $difference->y;				
											?></TD>
								<TD style="padding:0px 10px;"><?= $var["Voters_Gender"] ?></TD>
								<TD style="padding:0px 10px;"><?= $var["Voters_RegParty"] ?></TD>
											
									
									
								<TD style="padding:0px 10px;"><?= $var["DataCity_Name"] ?></TD>
								<TD style="padding:0px 10px;"><?= $var["DataState_Abbrev"] ?></TD>
								<TD style="padding:0px 10px;"><?= $var["DataAddress_zipcode"] ?></TD>
									
									<?php 
									
						} ?>
						
						</TABLE>
						
						<BR>
						<B><A HREF="/<?= $k ?>/admin/voterlookup">Look for a new voter</A></B>
			
					</div>
						
						<?php 
							
						
					} else {
						
						$var = $Result[$VoterIndexToShow[$var["VotersIndexes_UniqStateVoterID"]]];			
							if ( ! empty ($var)) { 
								if (empty ($Query_AD) || ( $var["Raw_Voter_AssemblyDistr"] == $Query_AD)  ) {	
									if ( empty ($Query_ED) || ( $var["Raw_Voter_ElectDistr"] == $Query_ED)  ) {	
										if ( empty ($PARTY) || ($var["Raw_Voter_EnrollPolParty"] == $PARTY) ) {
															
											preg_match('/^NY0+(.*)/', $var["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
											$UniqVoterID = "NY" . $UniqMatches[1][0];
											
											$PartyCallEDAD = sprintf('%02d%03d', $var["DataDistrict_StateAssembly"], $var["DataDistrict_Electoral"]);
											$partycall = $rmb->ListCCPartyCall($var["Voters_RegParty"], $PartyCallEDAD, $CurrentElectionID);
											WriteStderr($partycall, "Party Call");
										
											$OtherCandidates = $rmb->FindPositionsByED($CurrentElectionID, $PartyCallEDAD );
											WriteStderr($OtherCandidates, "OtherCandidatesConvTo");	
										
											$MyCandidacy = $rmb->ListCandidateInformationByUNIQ($var["VotersIndexes_UniqStateVoterID"], $CurrentElectionID);
											WriteStderr($MyCandidacy, "MyCandidacy");	
										
											
				?>
				
				<div class="list-group-item f60">
					<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
					<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $var["Voters_Status"] ?></FONT>
					<BR><BR>
					<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">First</TH>
						<TH style="padding:0px 10px;">Middle</TH>
						<TH style="padding:0px 10px;">Last</TH>
						<TH style="padding:0px 10px;">Suffix</TH>
					</TR>
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= $var["DataFirstName_Text"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataMiddleName_Text"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataLastName_Text"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["VotersIndexes_Suffix"] ?></TD>
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
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= PrintShortDate($var["VotersIndexes_DOB"]); ?></TD>
						<TD style="padding:0px 10px;">	<?php
										$dob = new DateTime($var["VotersIndexes_DOB"]);
	 									$now = new DateTime();
	 									$difference = $now->diff($dob);
	 									echo $difference->y;				
									?>
						<TD style="padding:0px 10px;"><?= $var["Voters_Gender"] ?></TD>
						<TD style="padding:0px 10px;"><?=PrintParty($var["Voters_RegParty"]) ?></TD>
					</TR>
				</TABLE>
				<BR>
				<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">Assembly<BR>District</TH>
						<TH style="padding:0px 10px;">Electoral<BR>District</TH>
						<TH style="padding:0px 10px;">Congress</TH>
						<TH style="padding:0px 10px;">County</TH>
					</TR>
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= $var["DataDistrict_StateAssembly"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataDistrict_Electoral"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataDistrict_Congress"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["DataCounty_Name"] ?></TD>
					</TR>
				</TABLE>
				<BR>
						
				<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">Address</TH>
					</TR>
					<TR>
						<TD style="padding:0px 10px;">		
							<?php if (! empty ($var["DataAddress_HouseNumber"])) echo $var["DataAddress_HouseNumber"]; ?>
							<?php if (! empty ($var["DataAddress_FracAddress"]))  echo $var["DataAddress_FracAddress"]; ?>
							<?php if (! empty ($var["DataAddress_PreStreet"])) echo $var["DataAddress_PreStreet"]; ?>
							<?php if (! empty ($var["DataStreet_Name"])) echo $var["DataStreet_Name"]; ?>
							<?php if (! empty ($var["DataAddress_PostStreet"])) echo $var["DataAddress_PostStreet"]; ?>
							<?php if (! empty ($var["DataHouse_Apt"])) echo " - Apt " . $var["DataHouse_Apt"]; ?>
							<BR>
							<?= $var["DataCity_Name"] ?>, <?= $var["DataState_Abbrev"] ?>
							<?= $var["DataAddress_zipcode"] ?>
							<?php if (! empty ($var["DataAddress_zip4"])) echo " - " . $var["DataAddress_zip4"]; ?>
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
					<TD style="padding:0px 10px;"><?= $var["DataDistrict_Legislative"] ?></TD>
					<TD style="padding:0px 10px;"><?= $var["DataDistrictTown_Name"] ?></TD>
					<TD style="padding:0px 10px;"><?= $var["DataDistrict_Ward"] ?></TD>
					<TD style="padding:0px 10px;"><?= $var["DataDistrict_StateSenate"] ?></TD>
				</TR>
			</TABLE>
			
				<BR>
			<TABLE BORDER=1>
				<TR>
					<TH style="padding:0px 10px;">Record Date</TH>
					<TH style="padding:0px 10px;">Last Voter File</TH>
				</TR>
				<TR ALIGN=CENTER>
					<TD style="padding:0px 10px;"><?= PrintDate($var["Voters_RecFirstSeen"]) ?></TD>
					<TD style="padding:0px 10px;"><?= PrintDate($var["Voters_RecLastSeen"]) ?></TD>
				</TR>
			</TABLE>
			<BR>
			
			<TABLE BORDER=1>
				<TR>
					<TH style="padding:0px 10px;" COLSPAN=2>Party Call</TH>	
				</TR>
				
				<?php if (! empty ($partycall)) { ?> 
				
				<TR>
					<TH style="padding:0px 10px;">Position</TH>
					<TH style="padding:0px 10px;">Number Candidates</TH>
				</TR>
				
				
				
				
				<TR ALIGN=CENTER>
					<TD style="padding:0px 10px;"><?= $partycall[0]["ElectionsPosition_Name"] ?></TD>
					<TD style="padding:0px 10px;"><?=  $partycall[0]["ElectionsPartyCall_NumberUnixSex"] ?></TD>
				</TR>
				
				<?php } else { ?>
					
				<TR ALIGN=CENTER>
					<TD style="padding:0px 10px;" COLSPAN=2>No party call information for district <?= $PartyCallEDAD ?></TD>
				</TR>
				
					
				<?php } ?>
				
				
			</TABLE>
			
			<BR>
			
			<TABLE BORDER=1>
				<TR>
					<TH style="padding:0px 10px;" COLSPAN=4>Other Candidates running in district</TH>	
				</TR>
				
				<?php if (! empty ($OtherCandidates)) { ?> 
				
				<TR>
					<TH style="padding:0px 10px;">Position</TH>
					<TH style="padding:0px 10px;">District</TH>
					<TH style="padding:0px 10px;">Full Name</TH>
					<TH style="padding:0px 10px;">Team Name</TH>
				</TR>
				
				<?php foreach ($OtherCandidates as $multivar) { ?> 
				
				
				<TR ALIGN=CENTER>
					<TD style="padding:0px 10px;text-align:left"><?= $multivar["ElectionsPosition_Name"] ?></TD>
					<TD style="padding:0px 10px;"><?= $multivar["CandidateElection_DBTable"] . " " . $multivar["CandidateElection_DBTableValue"] ?></TD>
					<TD style="padding:0px 10px;text-align:left"><?= $multivar["Candidate_DispName"] ?></TD>
					<TD style="padding:0px 10px;"><?= $multivar["Team_AccessCode"] ?></TD>
				</TR>
				
				<?php }  } else { ?>
					
				<TR ALIGN=CENTER>
					<TD style="padding:0px 10px;" COLSPAN=4>No other candidates running for district <?= $PartyCallEDAD ?></TD>
				</TR>
				
					
				<?php } ?>
				
				
			</TABLE>
			
			<BR>
			
			<TABLE BORDER=1>
				<TR>
					<TH style="padding:0px 10px;" COLSPAN=4>Petitions for this candidate</TH>	
				</TR>
				
				<?php if (! empty ($MyCandidacy)) { ?> 
				
				<TR>
					<TH style="padding:0px 10px;">Set</TH>
					<TH style="padding:0px 10px;">District</TH>
					<TH style="padding:0px 10px;">Full Name</TH>
					<TH style="padding:0px 10px;">Team Name</TH>
				</TR>
				
				<?php foreach ($MyCandidacy as $multivar) { ?> 
				
				
				<TR ALIGN=CENTER>
					<TD style="padding:0px 10px;text-align:left"><a class="mr-1" href="<?= $FrontEndPDF ?>/<?= $multivar["CandidateSet_Random"] ?>/NY/petition" TARGET="PDF_Petition">S<?= $multivar["CandidateSet_ID"] ?></A></TD>
					<TD style="padding:0px 10px;"><?= $multivar["CandidateElection_DBTable"] . " " . $multivar["CandidateElection_DBTableValue"] ?></TD>
					<TD style="padding:0px 10px;text-align:left"><?= $multivar["Candidate_DispName"] ?></TD>
					<TD style="padding:0px 10px;text-align:left"><?= $multivar["Team_AccessCode"] ?></TD>
					<TD style="padding:0px 10px;"><A HREF="/<?= CreateEncoded ( array( 	
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
								"UniqNYSVoterID" => $var["VotersIndexes_UniqStateVoterID"],
								"CandidateID" => $multivar["Candidate_ID"],
								"CandidateSetID" => $multivar["CandidateSet_ID"],
								"Party" => $var["Voters_RegParty"],
								"CountyID" => $multivar["DataCounty_ID"],
					))?>/admin/organizepetitions">Organize Petition</a></TD>
				</TR>
				
				<?php }  } else { ?>
					
				<TR ALIGN=CENTER>
					<TD style="padding:0px 10px;" COLSPAN=4>No petitions where given to this voter</TD>
				</TR>
				
					
				<?php } ?>
				
				
			</TABLE>
			
			<BR>
			
			
			<?php 
						switch($var["Voters_RegParty"]) {
							case "DEM": $CountyCountyID = "1"; break;
							case "REP": $CountyCountyID = "13"; break;
						}
						
						$MySpecialK = urlencode(CreateEncoded (array( 	
								"ElectionPosition_ID" => $CountyCountyID, 
								"Voters_ID" => $var["Voters_ID"],
								"VotersIndexes_ID" => $var["VotersIndexes_ID"],
			          "ED" => $var["DataDistrict_Electoral"],
			          "AD" => $var["DataDistrict_StateAssembly"],
			          "Party" => $var["Voters_RegParty"],
								"PreparedFor" => $var["DataFirstName_Text"] . " " . $var["DataLastName_Text"],
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"], 
								"SystemAdmin" =>  $URIEncryptedString["SystemAdmin"],
						)));
			?>

			<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
			Download <a class="mr-1" href="<?= $FrontEndPDF ?>/<?= $MySpecialK ?>/rmb/voterlist" TARGET="PDF_Voter">Walking 
			List</a> <a class="mr-1" href="<?= $FrontEndPDF ?>/<?= $MySpecialK ?>/NY/petition" TARGET="PDF_Petition">Demo Petition</a>
			<a class="mr-1" href="/<?= $MySpecialK ?>/admin/makecandidate">Make Candidate</a>
			<BR>
			
			<?php 
			
				$TheNewK = EncryptURL(	
					"SystemUser_ID=" . $URIEncryptedString["SystemUser_ID"]. 
					"&SystemAdmin=" .  $URIEncryptedString["SystemAdmin"] . 
					"&FirstName=" . $URIEncryptedString["FirstName"] . 
					"&LastName=" . $URIEncryptedString["LastName"] . 
					"&UniqNYSVoterID=" . $URIEncryptedString["UniqNYSVoterID"]. 
					"&UserParty=" . $URIEncryptedString["UserParty"]. 
					"&MenuDescription=" . $URIEncryptedString["MenuDescription"]
				); ?>
			
			
			
		</div>
		
		
		
																	
			<?php
						}
					}
				}
			}	 
		} 
	} else { ?>
			<div class="list-group-item f60">
				No voter found.
			</div>
	<?php } ?>
	
	<BR>
	
	<P CLASS="f80">	
		<B><A HREF="/<?= $k ?>/admin/voterlookup">Look for a new voter</A></B>
	</P>
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
