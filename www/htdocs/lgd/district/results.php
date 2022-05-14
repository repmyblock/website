<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_district.php";  

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
	$rmb = new RMBdistrict();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($URIEncryptedString["UserParty"]);

	$result = $rmb->ListResultsByEDAD("71", "2");
	WriteStderr($result, "Candidates in the Loop");

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Election Results</h2>
			  </div>
     
				<?php	PlurialMenu($k, $TopMenus); ?>   

			  <div class="clearfix gutter d-flex flex-shrink-0">

				<div class="row">
				  <div class="main">
						<FORM ACTION="" METHOD="POST">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3">Results for <?= $result[0]["CandidateElection_PetitionText"] ?></div>
					  		</div>
					    </div>
				    
					    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
					      We don't know your district <a href="/voter">create one</a>?
					    </div>

							<?php 			
										$Counter = 0;
										if ( ! empty ($result)) {
											foreach ($result as $var) {
												
												WriteStderr($result, "Candidates in the Loop");
												
							?>		
								<div class="flex-items-left">	
								
									
									<span class="ml-4 flex-items-baseline">
											<?= $var["CandidateSet_ID"] ?>
											
						
									
												
				
									<?= $var["CandidateElection_Text"] ?> <?= $var["CandidateElection_DBTableValue"] ?></span>
									
									<?= $var["DataDistrict_Electoral"] ?> <?= $var["DataDistrict_StateAssembly"] ?> 




						 	
									<span class="ml-4 flex-items-baseline"><?= $var["Candidate_DispName"] ?></span>


									<?= $var["ElectResultAdmin_PubCounter"] ?>
			            <?= $var["ElectResultAdmin_ManualEmerg"] ?>
			            <?= $var["ElectResultAdmin_AbsMili"] ?>
			            <?= $var["ElectResultAdmin_Affidavit"] ?>
			            <?= $var["ElectResultAdmin_Scattered"] ?>

									
									
								</div>

							<?php
											}
										} 
							?>

							</div>
			
					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>