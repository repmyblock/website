<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	$State = "NY";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($URIEncryptedString["UserParty"]);

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
			    <h2 id="public-profile-heading" class="Subhead-heading">Candidate Profile</h2>
			  </div>
     
<?php 
				if ($VerifEmail == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
				} else if ($VerifVoter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
				} 
?>		
  
				<nav class="UnderlineNav pt-1 mb-4" aria-label="Billing navigation">
					<div class="UnderlineNav-body">
						<a href="/admin/<?= $k ?>/setup_elections" class="mobilemenu UnderlineNav-item select">Race Type</a>
						<a href="/admin/<?= $k ?>/setup_dates" class="mobilemenu UnderlineNav-item">Elections Dates</a>
						<a href="/admin/<?= $k ?>/setup_candidate" class="mobilemenu UnderlineNav-item selected">Candidate Profile</a>
					</div>
				</nav>

			  <div class="clearfix gutter d-flex flex-shrink-0">

				<div class="row">
				  <div class="main">
						<FORM ACTION="" METHOD="POST">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3">Candidate List</div>
					  		</div>
					    </div>
				    
					    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
					      We don't know your district <a href="/voter">create one</a>?
					    </div>
	    
	    
	    
<?php 			
			$Counter = 0;
			if ( ! empty ($result)) {
				foreach ($result as $var) {
?>		
	<div class="flex-items-left">
	 	<span class="ml-4 flex-items-baseline"><A HREF="/admin/<?= CreateEncoded (
				array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
							"Raw_Voter_ID" => $URIEncryptedString["SystemAdmin"],
							"Candidate_ID" => $var["Candidate_ID"])); ?>/edit_candidates">Select</A></span>
		<span class="ml-4"><?= PrintDate($var["Elections_Date"]) ?></span>
	  <span class="ml-4 ext-gray"><?= $var["CandidateElection_DBTable"] ?></span>
	 	<span class="ml-4 user-mention"><?= $var["CandidateElection_DBTableValue"] ?></span>
	  <span class="ml-4"><?= $var["Candidate_DispName"] ?></span>
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