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

	$CandidateSetToGoTo = $URIEncryptedString["CandidateSetID"];

	if ( ! empty ($_POST)) {
		
		WriteStderr($_POST, "_POST");	
		
		if ( ! empty($_POST["CandidateToAdd"])) {
		
			// Add the candidates.
			foreach ($_POST["CandidateToAdd"] as $var) {
				$CandidatesCheck[] = $var;
			}
			
			$CheckCandidates = $rmb->CheckCandidateGroups($CandidatesCheck);
			
			foreach ($CheckCandidates as $var) {
				$Check[$var["CandidateSet_ID"]][$var["Candidate_ID"]] = $var["CandidateGroup_ID"];
			}
			
			foreach ($Check as $var => $index) {
				$AllFound = 0;

				foreach ($CandidatesCheck as $vor) {				
					if (empty ($index[$vor])) {
						$AllFound = 1;
					} else {
						if ( $AllFound == 0 ) $AllFound = 2;
					}
				}
				if ( $AllFound == 2 ) { break; }	
			}
			
	
		
			if ( $AllFound != 2 ) {	
				$Number = $rmb->NextPetitionSet($URIEncryptedString["SystemUser_ID"]);		
				$Counter = 1;
				
				/// I NEED TO SORT BY THE ORDER OF THE DOCUMENT
				foreach ($CandidatesCheck as $var) {					
					$rmb->InsertCandidateSet($var, $Number["CandidateSet"], $URIEncryptedString["Party"], 
																																	$URIEncryptedString["CountyID"], $Counter++, "yes");
				}
				$CandidateSetToGoTo = $Number["CandidateSet"];
			}
		}
		
		// This is the reodering normal.
		foreach ($_POST["New"] as $index => $var) {
			if ( $_POST["Orig"][$index] != $var) { 
				$rmb->updatecandidatesetorder($index, $var);
			}	
		}
		
		WriteStderr($URIEncryptedString, "ADTER POST URIEncryptedString");	
		
		header("Location: /" . CreateEncoded ( array( 	
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
								"UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
								"CandidateSetID" => $CandidateSetToGoTo, 
								"CountyID" => $URIEncryptedString["CountyID"],
								"Party" => $URIEncryptedString["Party"],
					)) . "/admin/organizepetitions");
		exit();		
	}

	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$rmbvoters = $rmb->ListPetitionCandidateSet($URIEncryptedString["CandidateSetID"]);
	WriteStderr($rmbvoters, "rmbvoters");	
	
	
	// I NEED TO FIX THE PARTY HERE
	$OtherCandidatesConvTo = $rmb->FindPositionsInToConv($CurrentElectionID, $rmbvoters[0]["Voters_RegParty"], $URIEncryptedString["CandidateID"]);
	$OtherCandidatesSame = $rmb->FindPositionsInSame($CurrentElectionID, NULL, $URIEncryptedString["CandidateID"]);
	$OtherCandidatesConvFrom = $rmb->FindPositionsInFromConv($CurrentElectionID, $rmbvoters[0]["Voters_RegParty"], $URIEncryptedString["CandidateID"]);

	WriteStderr($OtherCandidatesConvTo, "OtherCandidatesConvTo");	
	WriteStderr($OtherCandidatesSame, "OtherCandidatesSame");	
	WriteStderr($OtherCandidatesConvFrom, "OtherCandidatesConvFrom");	
	
	$OtherCandidates = array_merge($OtherCandidatesConvFrom, $OtherCandidatesConvTo, $OtherCandidatesSame);

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<FORM ACTION="" METHOD="POST">
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Organize a petition set</h2>
				</div>
					
					<?php if ( ! empty ($OtherCandidates) ) { ?>
					
					<DIV class="f60">
							Other Candidate in district
						</P>
					
									
									<DIV class="f40">
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">&nbsp;</div>
											<div class="table-header-cell">Party</div>
											<div class="table-header-cell">Candidate Name</div>
											<div class="table-header-cell">Type</div>
											<div class="table-header-cell">District</div>
											<div class="table-header-cell">Town</div>
											<div class="table-header-cell">Status</div>
										
										</div>

									
							
									
									<?php 
			
				foreach ($OtherCandidates as $var) {
										
		?>
							
									
									
									
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><INPUT TYPE="CHECKBOX" NAME="CandidateToAdd[]" VALUE="<?= $var["FindCandidate_ID"] ?>"></div>
												<div class="table-body-cell"><?= $var["FindCandidate_Party"] ?></div>
												<div class="table-body-cell-left"><?= $var["FindCandidate_DispName"] ?></div>
												<div class="table-body-cell"><?= $var["FindCandidate_DBTable"] ?></div>
												<div class="table-body-cell"><?= $var["FindCandidate_DBTableValue"] ?></div>
												<div class="table-body-cell"><?= $var["DataDistrict_Electoral"] ?></div>
												<div class="table-body-cell"><?= $var["FindCandidate_Status"] ?></div>
											
											</DIV>	
										</div>
								
								
									
								
									
								<?php }
								
								
								
								echo "</DIV>";
								
							}   
										
										
									
										
							?>
								

							
							

						<p>		
            
						<div class="list-group-item filtered f60 hundred">
							<span><B><FONT SIZE=+1>Petition Set <?= $URIEncryptedString["CandidateSetID"] ?></FONT></B></span>  	          			
						</div>
							
					 <DIV class="panels">
				<?php
						if ( ! empty ($rmbvoters)) {		 								
					?>
						
		
						
								<div class="list-group-item f60">
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									Petition Status: <FONT COLOR=BROWN><B><?= $rmbvoters[0]["Candidate_Status"] ?></B></FONT>
								 - 
									<A HREF="<?= $FrontEndPDF ?>/<?= $rmbvoters[0]["CandidateSet_Random"] ?>/NY/petition" TARGET="PDF_Petition">Download petition <B><?= $rmbvoters[0]["CandidateSet_Random"] ?></B></A>
									<BR>
			

								<?php foreach ($rmbvoters as $var) {
									if (! empty ($var)) {
										
										
										
										?>
																	<BR>		
									<TABLE BORDER=1>
									<TR>
										<TH style="padding:0px 10px;">&nbsp;</TH>
										<TH style="padding:0px 10px;">First</TH>
										<TH style="padding:0px 10px;">Middle</TH>
										<TH style="padding:0px 10px;">Last</TH>
										<TH style="padding:0px 10px;">Suffix</TH>
									</TR>
									<TR ALIGN=CENTER>
										<TD style="padding:0px 10px;">
											<INPUT TYPE="hidden" NAME="CandidateToAdd[]" VALUE="<?= $var["Candidate_ID"] ?>">
											<INPUT TYPE="hidden" NAME="Orig[<?= $var["CandidateGroup_ID"] ?>]" VALUE="<?= $var["CandidateGroup_Order"] ?>">
											<INPUT TYPE="TEXT" SIZE="1" NAME="New[<?= $var["CandidateGroup_ID"] ?>]" VALUE="<?= $var["CandidateGroup_Order"] ?>">
										</TD>
										<TD style="padding:0px 10px;text-align:left;vertical-align:top"><B><?= $var["Candidate_DispName"] ?></B></TD>
										<TD style="padding:0px 10px;text-align:left;vertical-align:top"><?= nl2br($var["Candidate_DispResidence"]) ?></TD>
										<TD style="padding:0px 10px;vertical-align:top"><?= $var["CandidateElection_DBTable"] ?></TD>
										<TD style="padding:0px 10px;vertical-align:top"><?= $var["CandidateElection_DBTableValue"] ?></TD>
									</TR>
							
									<TR>
										<TD style="padding:0px 10px;text-align:left;vertical-align:top" COLSPAN=1><?= $var["CandidateElection_PositionType"] ?></TD>
										<TD style="padding:0px 10px;" COLSPAN=4><?= $var["CandidateElection_PetitionText"] ?></TH>
									
									</TR>
								</TABLE>
								
							
							
									
			<?php	

	
								}
							}
						

	}?>
	
</P>
		
								<P CLASS="f80">	
									<BUTTON class="submitred">Reorder Petitions</BUTTON>
								</P>
										
										
										<P CLASS="f80">	
		<B><A HREF="/<?= CreateEncoded ( array( 	
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"SystemAdmin" => $URIEncryptedString["SystemAdmin"],
								"UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
							
					))?>/admin/voterlist">Return to previous screen</A></B>
	</P>
	
										
										


					</DIV>
					</DIV>
						</DIV>

</FORM>
</DIV>
</DIV>
</DIV></FORM>

</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
