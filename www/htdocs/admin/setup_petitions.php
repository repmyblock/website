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
	
	if ( ! empty ($_POST)) {
		header("Location: /admin/" . $k  . "/add_position");
		exit();
	}

	$result = $rmb->ListPetitionGroup();
	WriteStderr($result, "ListElectedPositions");
	

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">List Petitions Set</h2>
			  </div>
				
					  <div class="clearfix gutter d-flex flex-shrink-0">
	
	


<div class="row">
  <div class="main">


		<FORM ACTION="" METHOD="POST">
			<INPUT TYPE="HIDDEN" NAME="setup_elections" VALUE="add">
		<div class="Box">
	  	<div class="Box-header pl-0">
	    	<div class="table-list-filters d-flex">
	  			<div class="table-list-header-toggle states flex-justify-start pl-3">Petition Set Defined</div>
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
	 	<span class="ml-4 flex-items-baseline"><A HREF="<?= $FrontEndPDF ?>/NY/<?= CreateEncoded(array(
														"CandidateSet_ID" => $var["CandidateSet_ID"],	
														"Candidate_ID" => $var["Candidate_ID"],	
														"PendingBypass" => "yes"								
													)); ?>/petition">Select</A></span>
	 	<span class="ml-4 user-mention"><?= $var["CandidateSet_ID"] ?></span>
	 	<span class="ml-4 user-mention"><?= $var["CandidatePositions_Type"] ?></span>
	  <span class="ml-4 ext-gray"><?= $var["CandidatePositions_Name"] ?></span>
	  <span class="ml-4"><?= $var["Candidate_DispName"] ?></span>
	</div>
					
						
							
					
<?php
					
				}
			} ?>
	 
		
	 
		</div>
		<BR>
		<p><button type="submit" class="btn btn-primary">Add a new position</button></p>
</div>
</FORM>
</div>
</DIV>
</DIV>
</DIV>
</DIV>

[CandidateGroup_ID] => 15
            [CandidateSet_ID] => 15
            [Candidate_ID] => 17
            [CandidateGroup_Order] => 1
            [DataCounty_ID] => 120
            [CandidateGroup_Party] => DEM
            [CandidateGroup_Watermark] => yes
            [SystemUser_ID] => 1
            [CandidateProfile_ID] => 3
            [Candidate_PetitionNameset] => Luis Tejeada Assembly Petition
            [Candidate_UniqStateVoterID] => 
            [Voter_ID] => 
            [CandidateElection_ID] => 15688
            [Candidate_Party] => DEM
            [Candidate_FullPartyName] => 
            [PartySymbol_ID] => 
            [Candidate_DisplayMap] => 
            [Candidate_DispName] => Luis M. Tejada 
            [Candidate_DispResidence] => 157-10 Riverside Drive West - Apt 5N New York, NY 10031
            [CandidateElection_DBTable] => AD
            [CandidateElection_DBTableValue] => 71
            [Candidate_StatsVoters] => 
            [Candidate_Status] => pending
            [Candidate_LocalHash] => 
            [Candidate_NominatedBy] => 
            [DataState_ID] => 1
            [DataCounty_Name] => New York
            [DataCounty_BOEID] => 31
            [Elections_ID] => 1371
            [CandidateElection_PositionType] => electoral
            [CandidateElection_Party] => 
            [CandidateElection_Text] => New York State Assembly
            [CandidateElection_PetitionText] => Member of the New York State Assembly for the 71th Assembly District New York County, New York State
            [CandidateElection_URLExplain] => 
            [CandidateElection_Number] => 1
            [CandidateElection_DisplayOrder] => 600
            [CandidateElection_Display] => no
            [CandidateElection_Sex] => 
            [CandidateElection_CountVoter] => 
            [Elections_Text] => 2022 New York State Primary
            [Elections_Date] => 2022-06-28
            [Elections_Type] => primary
            [CandidateComRplceSet_ID] => 1
            [CandidateComRplce_ID] => 1
            [CandidateComRplce_Order] => 1
            [Voters_ID] => 
            [CandidateComRplce_FullName] => Jose Ramon Burgos
            [CandidateComRplce_Residence] => 125 E. 118th Street, New York, NY 10035
        )


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>