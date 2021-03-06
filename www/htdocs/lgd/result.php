<?php
	$Menu = "profile";  
	$BigMenu = "represent";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	
	$TopMenus = array ( 
								array("k" => $k, "url" => "profile", "text" => "Public Profile"),
								array("k" => $k, "url" => "profilevoter", "text" => "Voter Profile"),
								array("k" => $k, "url" => "profilecandidate", "text" => "Candidate Profile")
							);			

	WriteStderr($_POST, "Post");
	if ( ! empty ($_POST)) {
		if ($_POST["voterreg"] == "yes") {
		  $ADED = sprintf('%02d%03d', $_POST["Raw_Voter_AssemblyDistr"], $_POST["Raw_Voter_ElectDistr"]);		
			$NumberOfVoterInDistrict = $rmb->FindVotersInRawForEDAD($ADED, $_POST["Raw_Voter_EnrollPolParty"], $DatedFiles);
		

			$rmb->UpdateSystemUserWithVoterCard($_POST["SystemUser_ID"], $_POST["Raw_Voter_ID"], 
																					$_POST["Raw_Voter_UniqNYSVoterID"], $ADED, $_POST["Raw_Voter_EnrollPolParty"], count($NumberOfVoterInDistrict));
																							
			header("Location: /lgd/" .  CreateEncoded ( array( 
									"SystemUser_ID" => $_POST["SystemUser_ID"],
									"FirstName" => $_POST["FirstName"], 
									"LastName" => $_POST["LastName"],
									"VotersIndexes_ID" => $_POST["VotersIndexes_ID"],
									"UniqNYSVoterID" => $_POST["Raw_Voter_UniqNYSVoterID"],
									"EDAD" => $ADED, 
									"UserParty" => $_POST["Raw_Voter_EnrollPolParty"]
						)) . "/profilevoter");
			exit();
		}
	}
	
	if ( empty ($URIEncryptedString["VotersIndexes_ID"] )) {
		include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
		echo "We did not find the Voter ID information. We Return";
		include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";
		exit();
	} 
	
	$rmbvoters = $rmb->ReturnVoterIndex($URIEncryptedString["VotersIndexes_ID"]);
	WriteStderr($rmbvoters, "ReturnVoterIndex");
	
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
			    
<?php 
			PrintVerifMenu($VerifEmail, $VerifVoter);	
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
								if (empty ($Query_AD) || ( $var["Raw_Voter_AssemblyDistr"] == $Query_AD)  ) {	
									if ( empty ($Query_ED) || ( $var["Voters_RegParty"] == $Query_ED)  ) {	
										if ( empty ($PARTY) || ($var["Voters_RegParty"] == $PARTY) ) {
															
											$EnrollVoterParty = $var["Voters_RegParty"];
									
											preg_match('/^NY0+(.*)/', $var["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
											$UniqVoterID = "NY" . $UniqMatches[1][0];
				?>
				
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["VotersIndexes_UniqStateVoterID"] ?>" NAME="VotersIndexes_UniqStateVoterID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["ElectionsDistricts_DBTable"] ?>" NAME="ElectionsDistricts_DBTable">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["ElectionsDistricts_DBTableValue"] ?>" NAME="ElectionsDistricts_DBTableValue">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["VotersIndexes_ID"] ?>" NAME="VotersIndexes_ID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $URIEncryptedString["SystemUser_ID"] ?>" NAME="SystemUser_ID">
				<INPUT TYPE="HIDDEN" VALUE="<?= $var["Voters_RegParty"] ?>" NAME="Voters_RegParty">				
				
				<div class="list-group-item f60">
					<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
					<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $var["Voters_Status"] ?></FONT>
					<BR><BR>
					
					<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">Board of Election ID #</TH>
									</TR>
									
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= $var["Voters_CountyVoterNumber"] ?></TD>
									</TR>
								</TABLE>
					<BR>
					<TABLE BORDER=1>
					<TR>
						<TH style="padding:0px 10px;">First</TH>
						<TH style="padding:0px 10px;">Middle</TH>
						<TH style="padding:0px 10px;">Last</TH>
						<TH style="padding:0px 10px;">Suffix</TH>
					</TR>
					<TR ALIGN=CENTER>
						<TD style="padding:0px 10px;"><?= $var["VotersFirstName_Text"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["VotersMiddleName_Text"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["VotersLastName_Text"] ?></TD>
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
						<TD style="padding:0px 10px;"><?= NewYork_PrintParty($var["Voters_RegParty"]) ?></TD>
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
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_AssemblyDistr"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_ElectDistr"] ?></TD>
						<TD style="padding:0px 10px;"><?= $var["Raw_Voter_CongressDistr"] ?></TD>
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
							<?php if (! empty ($var["DataHouse_Apt"])) echo " - Apt " .  strtoupper($var["DataHouse_Apt"]); ?>
							<BR>
							<?= $var["DataCity_Name"] ?>, NY
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
					<TD style="padding:0px 10px;"><?= $var["Raw_Voter_LegisDistr"] ?></TD>
					<TD style="padding:0px 10px;"><?= $var["Raw_Voter_TownCity"] ?></TD>
					<TD style="padding:0px 10px;"><?= $var["Raw_Voter_Ward"] ?></TD>
					<TD style="padding:0px 10px;"><?= $var["Raw_Voter_SenateDistr"] ?></TD>
				</TR>
			</TABLE>
			
		</div>
												<?php		
								}
							}
						}
					}
				}
					
			?>

					<div id="">
						<BR>
						<p>
							&nbsp;<button type="submit" class="btn btn-primary" name="voterreg" value="yes">This is my voter registration card</button>
							<button type="submit" class="btn btn-primary" name="voterreg" value="not">NOT my registration card</button>
						</P>
					</DIV>
				</div>
									</FORM>
				</DIV>
				</DIV>
				</DIV>
				</DIV>
				

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>