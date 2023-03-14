<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
	$rmb = new RMBAdmin();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($URIEncryptedString["UserParty"]);

	$result = $rmb->ListPetitionGroup();
	WriteStderr($result, "ListCandidates");
	
	/*
	$TopMenus = array ( 						
		array("k" => $k, "url" => "../admin/setup_candidate", "text" => "Candidate Profile"),
		array("k" => $k, "url" => "../admin/setup_dates", "text" => "Elections Dates"),
		array("k" => $k, "url" => "../admin/setup_elections", "text" => "Race Type"),
	);
	*/

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Petition Set Maintenance</h2>
			  </div>
     
				<?php	PlurialMenu($k, $TopMenus); ?>   

			  <div class="clearfix gutter d-flex flex-shrink-0">

				<div class="row">
				  <div class="main">
						<FORM ACTION="" METHOD="POST">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3">Petition Group</div>
					  		</div>
					    </div>
				    
					    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
					      We don't know your district <a href="/voter">create one</a>?
					    </div>


			    
						<P>
						<div id="resp-table">
							<div id="resp-table-header">
								<div class="table-header-cell">ID</div>
								<div class="table-header-cell">Action</div>
								<div class="table-header-cell">District</div>
								<div class="table-header-cell">Candidate Name</div>
							</div>


							<?php 			
										$Counter = 0;
										if ( ! empty ($result)) {
											foreach ($result as $var) {
												
												WriteStderr($var, "Candidates in the Loop");
												
							?>		
								
										<div id="resp-table-body">
											<div class="resp-table-row">
												
												
													<div class="table-body-cell"><?= $var["CandidateSet_ID"] ?></DIV>
											
										<div class="table-body-cell"><A HREF="<?= $FrontEndPDF ?>/<?= $var["CandidateSet_Random"] ?>/NY/petition" TARGET=NEW>Petitions</A>
														
									<A HREF="<?= $FrontEndPDF ?>/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
												"Candidate_ID" => $var["Candidate_ID"])); ?>/rmb/voterlist" TARGET=NEW>WlkShts</A></DIV>
												
				
									<div class="table-body-cell-left"><?= $var["CandidateElection_DBTable"] ?> <?= $var["CandidateElection_DBTableValue"] ?>	</div>
						 	
									<div class="table-body-cell-left"><A HREF="/<?= CreateEncoded (
										array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
													"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
													"Candidate_ID" => $var["Candidate_ID"])); ?>/admin/edit_candidates"><?= $var["Candidate_DispName"] ?></A></div>
							
						</DIV>
					</DIV>

							<?php
											}
										} 
							?>
							</DIV>
							</div>
							
					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>