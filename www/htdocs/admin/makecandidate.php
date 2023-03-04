<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "admin";
	$BigMenu = "represent";	
	 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php"; 
	
	// Verify that the person is or has not beeing a candidate already.
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new RMBAdmin();
	
	if ( ! empty ($_POST)) {		
		if (! empty ($_POST["ElectionsPosition_ID"])) {
			foreach ($_POST["ElectionsPosition_ID"] as $index => $var) {
				
				// Check that the position actually exist.
				$result = $rmb->FindElectionFromPositionID($_POST["ElectionID"], $index, $_POST["ElectionsPosition_ID"][$index], $_POST["Districts_ID"][$index]);
			
				WriteStderr($result, "PetitionData");		
				$PetitionData = array (	
						"County_ID" => $_POST["County"],
						"Elections_ID" => $_POST["ElectionID"],
						"TypeElection" => $_POST["ElectionsPosition_ID"][$index],
						"TypeValue" => $_POST["Districts_ID"][$index],
						"Voters_RegParty" => $_POST["EnrollPolParty"], 
						"ActiveTeam_ID" => $_POST["ActiveTeam_ID"], 
						"AddressLine1" => $_POST["Address1"], 
						"AddressLine2" => $_POST["Address2"], 
						"CPrep_Party" => $_POST["EnrollPolParty"], 
						"FullName" => $_POST["FullName"], 
						"SystemUser_ID"  => $URIEncryptedString["SystemUser_ID"], 
						"UniqNYSVoterID"  => $_POST["UniqNYSVoterID"], 
						"Voters_ID" => $_POST["Voters_ID"], 
				);				
				require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/candidatelogic/NY_CreatePosition.php";	
			}
		}
		header("Location: /" . CreateEncoded ( array( 
						"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
						"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
						"UniqNYSVoterID" =>$_POST["UniqNYSVoterID"],
		))  . "/admin/voterlist");
		exit();
	}

	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$rmbvoters = $rmb->ReturnVoterIndex($URIEncryptedString["VotersIndexes_ID"]);

	WriteStderr($rmbvoters, "rmbvoters");	
	
	// Check the number of voters in that district.
	$electiondistrict = $rmb->FindElectionsAvailable($rmbvoters["DataState_ID"], $rmbvoters["Voters_RegParty"]);
	WriteStderr($electiondistrict, "electiondistrict");	
	
	
	$EDAD = sprintf("%'.02d%'.03d", $rmbvoters["DataDistrict_StateAssembly"], $rmbvoters["DataDistrict_Electoral"]);
	$PartyCall = $rmb->FindRacesInPartyCallInfo($CurrentElectionID, "ADED", $EDAD);
	
	if ( ! empty ($PartyCall)) {
		foreach ($PartyCall as $var) {
			
			if ( empty ($Position[$var["ElectionsDistrictsConv_DBTable"]]["Posname"])) {
					$Position[$var["ElectionsDistrictsConv_DBTable"]]["Posname"] = "County Committee";
					$Position[$var["ElectionsDistrictsConv_DBTable"]]["ID"] = $var["CandidatePositions_ID"];
					$Position[$var["ElectionsDistrictsConv_DBTable"]]["Type"] = $var["ElectionsPartyCall_PositionType"];
					$Position[$var["ElectionsDistrictsConv_DBTable"]]["District"] = $EDAD;
					$Position[$var["ElectionsDistrictsConv_DBTable"]]["Candidates"] = $var["ElectionsPartyCall_NumberUnixSex"];
					$Position[$var["ElectionsDistrictsConv_DBTable"]]["Order"] = "0";	
			}
			
			if ($var["ElectionsPartyCall_Party"] == $rmbvoters["Voters_RegParty"]) {
				$Position[$var["ElectionsPosition_DBTable"]]["Posname"] = $var["ElectionsPosition_Name"];
				$Position[$var["ElectionsPosition_DBTable"]]["ID"] = $var["ElectionsPosition_ID"];
				$Position[$var["ElectionsPosition_DBTable"]]["Type"] = $var["ElectionsPosition_Type"];
				$Position[$var["ElectionsPosition_DBTable"]]["District"] = $var["ElectionsDistricts_DBTableValue"];
				$Position[$var["ElectionsPosition_DBTable"]]["Order"] = $var["ElectionsPosition_Order"];	
			}		
		}		
	}
	
	
	WriteStderr($Position, "PartyCall");	
		
	

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Create a Candidate</h2>
				</div>
					
						 <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">

								
            
						<div class="list-group-item filtered f60 hundred">
							<span><B><FONT SIZE=+1>Voter</FONT></B></span>  	          			
						</div>
							
					 <DIV class="panels">
				<?php
						if ( ! empty ($rmbvoters)) {		 	
					
							preg_match('/^NY0+(.*)/', $rmbvoters["Voters_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
							$UniqVoterID = "NY" . $UniqMatches[1][0];
						
							// Address Line 1
							if (! empty ($rmbvoters["DataAddress_HouseNumber"])) $VoterAddress_Line1 = $rmbvoters["DataAddress_HouseNumber"];
							if (! empty ($rmbvoters["DataAddress_FracAddress"]))  $VoterAddress_Line1 .= " " . $rmbvoters["DataAddress_FracAddress"]; 
							if (! empty ($rmbvoters["DataAddress_PreStreet"])) $VoterAddress_Line1 .= " " . $rmbvoters["DataAddress_PreStreet"]; 
							if (! empty ($rmbvoters["DataStreet_Name"])) $VoterAddress_Line1 .= " " . $rmbvoters["DataStreet_Name"]; 
							if (! empty ($rmbvoters["DataAddress_PostStreet"])) $VoterAddress_Line1 .= " " . $rmbvoters["DataAddress_PostStreet"]; 
							if (! empty ($rmbvoters["DataHouse_Apt"])) $VoterAddress_Line1 .= " - Apt " . $rmbvoters["DataHouse_Apt"]; 
											
							// Adress Line 2		
							$VoterAddress_Line2 = $rmbvoters["DataCity_Name"] . ", " . $rmbvoters["DataState_Abbrev"];
							$VoterAddress_Line2 .= " " . $rmbvoters["DataAddress_zipcode"];
							if (! empty ($rmbvoters["DataAddress_zipcode"])) $VoterAddress_Line2 .= " - " . $rmbvoters["DataAddress_zip4"];
							
							// Full Voter Name
							$VoterFullName = $rmbvoters["DataFirstName_Text"];
							if ( ! empty ($rmbvoters["DataMiddleName_Text"])) { $VoterFullName .= " " . substr($rmbvoters["DataMiddleName_Text"], 0, 1) . "."; }
							$VoterFullName .= " " . $rmbvoters["DataLastName_Text"];
							if ( ! empty ($rmbvoters["VotersIndexes_Suffix"])) { $VoterFullName .= strtoupper($rmbvoters["VotersIndexes_Suffix"]); }
							
					?>
						
						
								<INPUT TYPE="hidden" NAME="VotersIndexes_ID" VALUE="<?= $rmbvoters["VotersIndexes_ID"] ?>">
								<INPUT TYPE="hidden" NAME="Voters_ID" VALUE="<?= $rmbvoters["Voters_ID"] ?>">
								<INPUT TYPE="hidden" NAME="UniqNYSVoterID" VALUE="<?= $rmbvoters["VotersIndexes_UniqStateVoterID"] ?>">
								<INPUT TYPE="hidden" NAME="EnrollPolParty" VALUE="<?= $rmbvoters["Voters_RegParty"] ?>">
								<INPUT TYPE="hidden" NAME="FullName" VALUE="<?= $VoterFullName ?>">     
								<INPUT TYPE="hidden" NAME="Address1" VALUE="<?= $VoterAddress_Line1 ?>">     
								<INPUT TYPE="hidden" NAME="Address2" VALUE="<?= $VoterAddress_Line2 ?>">     
								<INPUT TYPE="hidden" NAME="County" VALUE="<?= $rmbvoters["DataCounty_ID"] ?>">     
								<INPUT TYPE="hidden" NAME="ED" VALUE="<?= $rmbvoters["DataDistrict_Electoral"] ?>">     
								<INPUT TYPE="hidden" NAME="AD" VALUE="<?= $rmbvoters["DataDistrict_StateAssembly"] ?>">     
								<INPUT TYPE="hidden" NAME="ElectionID" VALUE="<?= $CurrentElectionID ?>">     
						
						
								<div class="list-group-item f60">
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $rmbvoters["Voters_Status"] ?></FONT>
									<BR>
						
									<B><?= $ResultStats[0]["Count"] ?></B> registered <?= PrintParty($rmbvoters["Voters_RegParty"]) ?> - 
									<B><FONT COLOR=BROWN><?= intval(($ResultStats[0][Count]) * $SignaturesRequired) + 1 ?></FONT></B> required signatures.<BR>
									
									<BR>
									
									
						
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">First</TH>
										<TH style="padding:0px 10px;">Middle</TH>
										<TH style="padding:0px 10px;">Last</TH>
										<TH style="padding:0px 10px;">Suffix</TH>
									</TR>
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataFirstName_Text"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataMiddleName_Text"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataLastName_Text"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["VotersIndexes_Suffix"] ?></TD>
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
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataDistrict_StateAssembly"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataDistrict_Electoral"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataDistrict_Congress"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataCounty_Name"] ?></TD>
									</TR>
								</TABLE>
								
									<BR>
										
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">Address</TH>
							
									</TR>
									<TR>
										<TD style="padding:0px 10px;">		
											<?= $VoterAddress_Line1 ?><BR>
											<?= $VoterAddress_Line2 ?>
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
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataDistrict_Legislative"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataDistrictTown_Name"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataDistrict_Ward"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["DataDistrict_StateSenate"] ?></TD>
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
										$dob = new DateTime($rmbvoters["VotersIndexes_DOB"]);
	 									$now = new DateTime();
	 									$difference = $now->diff($dob);
									?>
									
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= PrintShortDate($rmbvoters["VotersIndexes_DOB"]); ?></TD>
										<TD style="padding:0px 10px;"><?= $difference->y; ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Voters_Gender"] ?></TD>
										<TD style="padding:0px 10px;"><?= PrintParty($rmbvoters["Voters_RegParty"]) ?></TD>
									</TR>
								</TABLE>
									<BR>
									
									
										<?php if (! empty ($Position)) { ?>
											
												<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">Position to Petition</TH>
										<TH style="padding:0px 10px;">Type</TH>
										<TH style="padding:0px 10px;" COLSPAN=2>District</TH>
										<TH style="padding:0px 10px;">Signatures</TH>
									</TR>
									
									
								
											
<?php								foreach ($Position as $vor => $pos) {
									

										?>
										
										
										<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;text-align:left">
											<INPUT TYPE="hidden" NAME="Districts_ID[<?= $pos["ID"] ?>]" VALUE="<?= $pos["District"] ?>">
											<INPUT TYPE="checkbox" NAME="ElectionsPosition_ID[<?= $pos["ID"] ?>]" VALUE="<?= $vor ?>">&nbsp;<?= $pos["Posname"] ?></TD>
										<TD style="padding:0px 10px;text-align:left"><?= $pos["Type"] ?> </TD>
										<TD style="padding:0px 10px;text-align:left"><?= $vor ?></TD>
										<TD style="padding:0px 10px;text-align:left"><?= $pos["District"] ?></TD>
										<TD style="padding:0px 10px;text-align:left"><?= $pos["Signatures"] ?></TD>
									</TR>
										
										<?php 
										
									
								}
						
												 	?>
														
														
														</TABLE>
								
									<BR>
								
									<button class="submitred">Create the petitions</BUTTON>
										
										<BR>
									
			<?php	}

	}?>
					</DIV>
					</DIV>
						</DIV>

</FORM>
</DIV>
</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
