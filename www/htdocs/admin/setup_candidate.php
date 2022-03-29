<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	$State = "NY";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($URIEncryptedString["UserParty"]);

	$result = $rmb->ListCandidates();
	WriteStderr($result, "ListCandidates");
	
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
     
				<?php	PlurialMenu($k, $TopMenus); ?>   

			  <div class="clearfix gutter d-flex flex-shrink-0">

				<div class="row">
				  <div class="main">
						<FORM ACTION="" METHOD="POST">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3">Candidates</div>
					  		</div>
					    </div>
				    
					    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
					      We don't know your district <a href="/voter">create one</a>?
					    </div>

							<?php 			
										$Counter = 0;
										if ( ! empty ($result)) {
											foreach ($result as $var) {
												
												WriteStderr($var, "Candidates in the Loop");
												
							?>		
								<div class="flex-items-left">	
									<span class="ml-4 flex-items-baseline"><A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("Candidate_ID" => $var["Candidate_ID"])); ?>/NY/petition" TARGET=NEW>Pets</A>
														
									<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/rmb/voterlist" TARGET=NEW>WlkShts</A>
												
									<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
													
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
													/*
													"SpecialRequest" => $URIEncryptedString["SpecialRequest"],
													"DateEvent" =>  PrintNormalDate($var["Elections_Date"]),
													"PrintName" => "Theo Chino",
													"AddressLine1" => "640 Riverside Drive - 10B",
													"AddressLine2" => "New York, NY 10031",
													"Representing" => $var["Candidate_DispName"],
													"PetWithoutID" => NULL,
													"Election" => ucfirst($var["Elections_Type"]),
													"PartyName" => PrintPartyAdjective($var["Candidate_Party"]),
													"XonDesign" => "X",
													"XonIndepend" => NULL,
													"XonOpportunity" => NULL,
													"TotalBX" => NULL,
													"TotalNY" => 40,
													"TotalKG" => NULL,
													"TotalQN" => NULL,
													"TotalRC" => NULL,
													*/
													
													"Candidate_ID" => $var["Candidate_ID"])); ?>/NY/NYC/CRU_PreFile" TARGET=NEW>CRUFm</A>
												
									<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/NY/NYC/coversheet" TARGET=NEW>Cvr Shts</A>
									
									<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/NY/NYC/coversheet" TARGET=NEW>(Nrow)</A>
				
									<?= $var["CandidateElection_DBTable"] ?> <?= $var["CandidateElection_DBTableValue"] ?></span>
						 	
									<span class="ml-4 flex-items-baseline"><A HREF="/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/admin/edit_candidates"><?= $var["Candidate_DispName"] ?></A></span>
								</div>

							<?php
											}
										} 
							?>

							</div>
							<BR>
							<p><button type="submit" class="btn btn-primary">Add a new Candidate</button></p>
					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>