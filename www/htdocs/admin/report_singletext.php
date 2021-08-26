<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_sms.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$sms = new sms();



	$result = $sms->ListInboundSMSByCampaign($URIEncryptedString["SMSCampaign_ID"]);
	WriteStderr($result, "Report Single Text Campaign");
			
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Report on Text</h2>
			  </div>
  


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
			
			print "<PRE>" . print_r($result, 1) . "</PRE>";
			
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