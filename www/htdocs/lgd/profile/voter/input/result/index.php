<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "profile";  
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();
	
	if ( ! empty ($_POST)) {
    $ADED = sprintf('%02d%03d', $_POST["Raw_Voter_AssemblyDistr"], $_POST["Raw_Voter_ElectDistr"]);		
    $District = sprintf('AD %02d / ED %03d', $_POST["Raw_Voter_AssemblyDistr"], $_POST["Raw_Voter_ElectDistr"]);		

		$rmb->UpdateSystemUserWithVoterCard($SystemUser_ID, $_POST["RawVoterID"], 
																				$_POST["Raw_Voter_UniqNYSVoterID"], $ADED);
																				
		$EncryptedURL = "SystemUser_ID=" . $SystemUser_ID .
										"&FirstName=" . $FirstName . 
										"&LastName=" . $LastName .
										"&VotersIndexes_ID=" . $VotersIndexes_ID . 
										"&UniqNYSVoterID=" . $_POST["Raw_Voter_UniqNYSVoterID"] . 
										"&MenuDescription=" . urlencode($District) . 
										"&UserParty=" . $_POST["Raw_Voter_EnrollPolParty"];
		
		header("Location: /lgd/profile/voter/?k=" . EncryptURL($EncryptedURL));
		exit();
	}
	
	if ( empty ($VotersIndexes_ID )) {
		include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
		echo "We did not find the Voter ID information. We Return";
		include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";
		exit();
	} 
	
	$rmbvoters = $rmb->SearchVotersBySingleIndex($VotersIndexes_ID, $DatedFiles);
	
	/*
		print "RESULT: ";
		echo "<PRE>";
		print_r($rmbvoters);
		echo "</PRE>";
*/

	
	if (! empty ($rmbvoters["Raw_Voter_UniqNYSVoterID"])) {
		$rmbvoteridx = $rmb->SearchLocalRawDBbyNYSID($rmbvoters["Raw_Voter_UniqNYSVoterID"]);
	
	
	/*
		print "RESULT: ";
		echo "<PRE>";
		print_r($rmbvoteridx);
		echo "</PRE>";
	*/
	
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
	
	
	

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);

	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Voter Profile</h2>
			  </div>
			     
				<nav class="UnderlineNav pt-1 mb-4" aria-label="Billing navigation">
					<div class="UnderlineNav-body">
						<a href="/lgd/profile/?k=<?= $k ?>" class="mobilemenu UnderlineNav-item">Public Profile</a>
						<a href="/lgd/profile/voter/?k=<?= $k ?>" class="mobilemenu UnderlineNav-item selected">Voter Profile</a>
						<a href="/lgd/profile/candidate/?k=<?= $k ?>" class="mobilemenu UnderlineNav-item">Candidate Profile</a>
					</div>
				</nav>

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
										
										?>
																											<?php 
								preg_match('/^NY0+(.*)/', $rmbvoters["Raw_Voter_UniqNYSVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
								$UniqVoterID = "NY" . $UniqMatches[1][0];
						?>

														<div class="list-group-item">
														
														<INPUT TYPE="radio" NAME="SelectAllAddresses" VALUE="<?= $rmbvoters["Raw_Voter_UniqNYSVoterID"] ?>">&nbsp;&nbsp;
														<INPUT TYPE="hidden" NAME="VoterIndexes_ID" VALUE="<?= $rmbvoters["VotersIndexes_ID"] ?>">
														<INPUT TYPE="hidden" NAME="Raw_Voter_ID" VALUE="<?= $rmbvoters["Raw_Voter_ID"] ?>">
														<INPUT TYPE="hidden" NAME="RawVoterID" VALUE="<?= $RawVoterID ?>">
														<INPUT TYPE="hidden" NAME="Raw_Voter_UniqNYSVoterID" VALUE="<?= $rmbvoters["Raw_Voter_UniqNYSVoterID"] ?>">
														<INPUT TYPE="hidden" NAME="Raw_Voter_ElectDistr" VALUE="<?= $rmbvoters["Raw_Voter_ElectDistr"] ?>">
														<INPUT TYPE="hidden" NAME="Raw_Voter_AssemblyDistr" VALUE="<?= $rmbvoters["Raw_Voter_AssemblyDistr"] ?>">
														<INPUT TYPE="hidden" NAME="Raw_Voter_EnrollPolParty" VALUE="<?= $rmbvoters["Raw_Voter_EnrollPolParty"] ?>">
														
												
						
						
												
														
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									<?= $UniqVoterID ?> Status: <FONT COLOR=BROWN><?= $rmbvoters["Raw_Voter_Status"] ?></FONT>
									</P>
									
									
									
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">First</TH>
										<TH style="padding:0px 10px;">Middle</TH>
										<TH style="padding:0px 10px;">Last</TH>
										<TH style="padding:0px 10px;">Suffix</TH>
									</TR>
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_FirstName"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_MiddleName"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_LastName"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_Suffix"] ?></TD>
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
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_AssemblyDistr"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_ElectDistr"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_CongressDistr"] ?></TD>
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
											<?php if (! empty ($rmbvoters["Raw_Voter_ResHouseNumber"])) echo $rmbvoters["Raw_Voter_ResHouseNumber"]; ?>
											<?php if (! empty ($rmbvoters["Raw_Voter_ResFracAddress"]))  echo $rmbvoters["Raw_Voter_ResFracAddress"]; ?>
											<?php if (! empty ($rmbvoters["Raw_Voter_ResPreStreet"])) echo $rmbvoters["Raw_Voter_ResPreStreet"]; ?>
											<?php if (! empty ($rmbvoters["Raw_Voter_ResStreetName"])) echo $rmbvoters["Raw_Voter_ResStreetName"]; ?>
											<?php if (! empty ($rmbvoters["Raw_Voter_ResPostStDir"])) echo $rmbvoters["Raw_Voter_ResPostStDir"]; ?>
											<?php if (! empty ($rmbvoters["Raw_Voter_ResApartment"])) echo " - Apt " . $rmbvoters["Raw_Voter_ResApartment"]; ?>
											<BR>
											<?= $rmbvoters["Raw_Voter_ResCity"] ?>, NY
												<?= $rmbvoters["Raw_Voter_ResZip"] ?>
											<?php if (! empty ($rmbvoters["Raw_Voter_ResZip4"])) echo " - " . $rmbvoters["Raw_Voter_ResZip4"]; ?>
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
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_LegisDistr"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_TownCity"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_Ward"] ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_SenateDistr"] ?></TD>
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
										$dob = new DateTime($rmbvoters["Raw_Voter_DOB"]);
	 									$now = new DateTime();
	 									$difference = $now->diff($dob);
									?>
									
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;"><?= PrintShortDate($rmbvoters["Raw_Voter_DOB"]); ?></TD>
										<TD style="padding:0px 10px;"><?= $difference->y; ?></TD>
										<TD style="padding:0px 10px;"><?= $rmbvoters["Raw_Voter_Gender"] ?></TD>
										<TD style="padding:0px 10px;"><?= NewYork_PrintParty($rmbvoters["Raw_Voter_EnrollPolParty"]) ?></TD>
									</TR>
								</TABLE>
									<BR>
									
								
								
									
								</div>			
														
												<?php		
												
									
									}
							?>
						
							
							
					 	
					</div>
					
					<div id="list-group-item filtered">
						<p><button type="submit" class="btn btn-primary">This is my voter registration card</button></p>
					</DIV>
					
				</FORM>
				</div>
			</div>		
		</div>
	</div>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>