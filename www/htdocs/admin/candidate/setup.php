<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}

	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($URIEncryptedString["UserParty"]);

	$result = $rmb->ListCandidates();
	//WriteStderr($result, "ListCandidates");
			
					//print "<PRE>" . print_r($URIEncryptedString, 1) . "</PRE>";
					//print "<PRE>" . print_r($result, 1) . "</PRE>";
			
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Candidates Maintenance</h2>
			  </div>

			  <div class="clearfix gutter d-flex flex-shrink-0">

				<div class="Box">
			  	<div class="Box-header pl-0">
			    	<div class="table-list-filters d-flex">
			  			<div class="table-list-header-toggle states flex-justify-start pl-3">Candidates</div>
			  		</div>
			    </div>
		 			    
	   	 		<div class="clearfix gutter d-flex flex-shrink-0">
						<div class="col-12">

						<P>
						<div id="resp-table">
							<div id="resp-table-header">
								<div class="table-header-cell">District</div>
								<div class="table-header-cell">Candidate</div>
								<div class="table-header-cell">Actions</div>
								<div class="table-header-cell">Election Date</div>
							</div>

							<?php 			
								$Counter = 0;
								if ( ! empty ($result)) {
									foreach ($result as $var) {
										WriteStderr($var, "Candidates in the Loop");
							?>		
										<div id="resp-table-body">
											<div class="resp-table-row">
													<div class="table-body-cell-left"><?= $var["CandidateElection_DBTable"] ?> <?= $var["CandidateElection_DBTableValue"] ?></div>	
											<div class="table-body-cell-left"><A HREF="/<?= CreateEncoded (
												array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
															"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
															"UniqNYSVoterID" => $var["Candidate_UniqStateVoterID"],
															"Candidate_ID" => $var["Candidate_ID"],
														
												)); ?>/admin/candidate/detail"><?= $var["Candidate_DispName"] ?></A></DIV>
												<div class="table-body-cell">
													<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
												array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
															"Raw_Voter_ID" => $URIEncryptedString["SystemUser_Priv"],
															
															"SpecialRequest" => $var["FillingDoc_Fld1"],
															"DateEvent" => $var["FillingDoc_Fld2"],
															"PrintName" => $var["FillingDoc_Fld3"],
															"AddressLine1" => $var["FillingDoc_Fld4"],
															"AddressLine2" => $var["FillingDoc_Fld5"],
															"Representing" => $var["FillingDoc_Fld6"],
															"PetWithoutID" => $var["FillingDoc_Fld7"],
															"Election" => $var["FillingDoc_Fld8"],
															"PartyName" => $var["FillingDoc_Fld9"],
															"XonDesign" => $var["FillingDoc_Fld10"],
															"XonIndepend" => $var["FillingDoc_Fld11"],
															"XonOpportunity" => $var["FillingDoc_Fld12"],
															"TotalBX" => $var["FillingDoc_Fld13"],
															"TotalNY" => $var["FillingDoc_Fld14"],
															"TotalKG" => $var["FillingDoc_Fld15"],
															"TotalQN" => $var["FillingDoc_Fld16"],
															"TotalRC" => $var["FillingDoc_Fld17"],												
															"Candidate_ID" => $var["Candidate_ID"])); ?>/NY/NYC/CRU_PreFile" TARGET=NEW>CRUFm</A>
											
													<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("Candidate_ID" => $var["Candidate_ID"])); ?>/NY/petition" TARGET=NEW>Pets</A>
														
									<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemUser_Priv"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/rmb/voterlist" TARGET=NEW>WlkShts</A>
													
							 	
												
									<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemUser_Priv"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/NY/coversheet" TARGET=NEW>Cvr Shts</A>	
									
									<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemUser_Priv"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/NY/coversheet" TARGET=NEW>(Nrow)</A>	
												
								
						 		<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemUser_Priv"],
													"AmmendCoverSheet" => "yes",
												"Candidate_ID" => $var["Candidate_ID"])); ?>/NY/coversheet" TARGET=NEW>Amend</A>		
												
								<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemUser_Priv"],
													"AmmendCoverSheet" => "yes",
												"Candidate_ID" => $var["Candidate_ID"])); ?>/NY/acceptcertif" TARGET=NEW>Accept Cert</A>
												
										</div>
											<div class="table-body-cell-left"><?= $var["Elections_Date"] ?></div>	
										</div>
									</DIV>
							<?php
											}
										} 
							?>
		</DIV>
</P>			
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>