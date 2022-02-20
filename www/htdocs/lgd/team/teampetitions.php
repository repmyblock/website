<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";	
	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	
	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WipeURLEncrypted();
	
	//$result = $r->GetSignedElectors($Candidate_ID);
	$EncryptURL = EncryptURL("CandidateID=" . $Candidate_ID . "&PetitionSetID=" . $CandidatePetitionSet_ID);
	
	$TopMenus = array ( 
		array("k" => $k, "url" => "team/index", "text" => "Manage Pledges"),
		array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
		array("k" => $k, "url" => "team/teamcandidate", "text" => "Manage Candidates")
	);			
	WriteStderr($TopMenus, "Top Menu");		
	
	$ListPetitions = $rmb->ListCandidateInformation($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($ListPetitions, "ListPetitions");	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";		
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Manage Petitions</h2>
			  </div>
			    
		<?php PlurialMenu($k, $TopMenus); ?>
		
		 <dl class="form-group">
  	<dt><label for="user_profile_email">Petition list created</label></dt>
    <dd class="d-inline-block">       	
    				
		<P>
		
		<?php 
			if ( ! empty ($ListPetitions) ) {
				foreach ($ListPetitions as $var) {
					if ( ! empty ($var)) {
						$NewKEncrypt = EncryptURL($NewK . "&CandidatePetitionSet_ID=" . $var["CandidatePetitionSet_ID"] . 
																											   "&Candidate_ID=" . $var["Candidate_ID"] );
		?>
						
		<?= $var["Candidate_PetitionNameset"] ?> in <?= $var["Candidate_Status"] ?> status.</A>
							
		<?php if ($var["Candidate_Status"] == "published") { ?>	
			<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/NY/E<?= $var["Candidate_ID"] ?>/petition"><i class="fa fa-download"></i></A> 
		<?php } ?>																																																
							<BR>
		<?php
					}
				}
			}
		?>

		</P>				
		

    </dd>
  </dl>
			
	
		
</DIV>
</DIV>
</DIV>
</DIV>

	
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>