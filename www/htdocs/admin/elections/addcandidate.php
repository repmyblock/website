<?php
	$Menu = "admin";
		 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
	
  if ( empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	
	$rmb = new repmyblock();	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	
	if ( ! empty ($URIEncryptedString["CandidateElection_ID"])) {		
		$result = $rmb->ListOnlyElections($URIEncryptedString["CandidateElection_ID"]);
		print "<PRE>" . print_r($result, 1) . "</PRE>";
		WriteStderr($result, "DisplayElectionPositions");
	}
	
	if (! empty($_POST)) {

		print "<PRE>" . print_r($_POST, 1) . "</PRE>";
		
		/*
			[CandidateElection_ID] => 16186
	    [Elections_ID] => 1410
	    [ElectionsPosition_ID] => 385
	    [CandidateElection_PositionType] => electoral
	    [CandidateElection_Party] => DEM
	    [CandidateElection_Text] => US Congress
	    [CandidateElection_PetitionText] => US Congress for district
	    [CandidateElection_URLExplain] => 
	    [CandidateElection_Number] => 1
	    [CandidateElection_DisplayOrder] => 1
	    [CandidateElection_SignDeadline] => 
	    [CandidateElection_Display] => no
	    [CandidateElection_Sex] => 
	    [CandidateElection_DBTable] => MSGV
	    [CandidateElection_DBTableValue] => 2
	    [CandidateElection_CountVoter] => 
		*/
		
		
		exit(1);

		// Need to add or update depending.
		$rmbpositions = $rmb->FindElectionsAvailable(NULL, NULL, $_POST["CandidateElection"])[0];		
		$MatchTableName = array(
					"ElectionID" =>  $_POST["ElectionID"], 
					"ElectPosID" => $_POST["CandidateElection"],
					"PosType" => $_POST["PositionType"], 
					"Party" => $_POST["PartyName"], 
					"PosText" => $_POST["CandidateElection_Text"], 
					"PetText" => $_POST["CandidateElection_PetitionText"],
					"URLExplain" => $_POST["URL"], 
					"Number" => $_POST["NumberCandidates"], 
					"Order" => $_POST["DisplayOrder"], 
					"DBTable" => $rmbpositions["ElectionsPosition_DBTable"], 
					"DBValue" => $_POST["DBTableValue"], 
					"NbrVoters" => $_POST["NbrVoters"],
					"SignDeadline" => $_POST["DeadLine"],
		);
		
		$CandidateElection_ID = $rmb->InsertCandidateElection($MatchTableName);		
		
		header("Location: /" . MergeEncode(array(
															"DataState_ID" => $DataState,							
														)) . "/admin/elections/addcandidate");	
		exit();
	}
	
	$rmbpositions = $rmb->FindElectionsAvailable($URIEncryptedString["DataState_ID"]);
	$rmbelections = $rmb->ListAllElectionsDates(true, $URIEncryptedString["DataState_ID"]);
	
	$ButtonText = "Add Position";
	$FormFieldParty = $URIEncryptedString["UserParty"];

	if ( ! empty ($result["CandidatePositions_Name"])) { $FormFieldPositionName = $result["CandidatePositions_Name"]; }
	if ( ! empty ($result["CandidateElection_DBTable"])) { $FormFieldDBTable = $result["CandidateElection_DBTable"]; }
	if ( ! empty ($result["CandidatePositions_State"])) { $FormFieldState = $result["CandidatePositions_State"];  }
	if ( ! empty ($result["CandidatePositions_Order"])) { $FormFieldPosition = $result["CandidatePositions_Order"]; }
	if ( ! empty ($result["CandidatePositions_Explanation"])) { $FormFieldExplanation = $result["CandidatePositions_Explanation"]; }
	if ( ! empty ($result["CandidatePositions_Type"])) { $FormFieldType = $result["CandidatePositions_Type"]; }

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="<?= $DIVCol ?> float-left">

				<div class="Subhead">
			  	<h2 class="Subhead-heading">Candidate for office</h2>
				</div>
			
			<?php 
				if ($VerifEmail == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
				} else if ($VerifVoter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
				} 
			?>          
			
			<?php if (! empty ($URIEncryptedString["ErrorMsg"])) {
		    	
		    	echo "<FONT COLOR=BROWN SIZE=+1><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>";
		    	echo "<BR><BR>";	
		    } ?>
				
				
					
				<B>Add a candidate to an election</B>
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						
						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Team ID</label><DT>
								<dd>
									<SELECT class="mobilebig" NAME="TeamID">
										<OPTION VALUE="">&nbsp;</OPTION>
										<OPTION VALUE="24">Pirate</OPTION>
										<OPTION VALUE="69">International People's Party</OPTION>
										<OPTION VALUE="25">Socialist Alternative</OPTION>
										<OPTION VALUE="26">Communists</OPTION>
										<OPTION VALUE="27">Progressive International</OPTION>
										<OPTION VALUE="28">Greens</OPTION>
										<OPTION VALUE="29">Socialists</OPTION>
										<OPTION VALUE="30">Progressive Alliance</OPTION>
										<OPTION VALUE="31">Liberals</OPTION>
										<OPTION VALUE="33">Christian Democrats</OPTION>
										<OPTION VALUE="35">Libertarians</OPTION>
										<OPTION VALUE="32">Democratic Union</OPTION>
										<OPTION VALUE="34">Indentity and Democracy</OPTION>
									</SELECT>
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">3 letters party</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Party 3 letters party" name="PartyName" VALUE="<?= $FormFieldState ?>" id="">
								</dd>
							</dl>
						</DIV>
						
							<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">First Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Candidate" name="CandidateElection_Text" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Last Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Petition Position Tex" name="CandidateElection_PetitionText" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
						</DIV>

						<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Candidate Full Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Candidate" name="CandidateElection_Text" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Candidate Address Line 1</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Petition Position Tex" name="CandidateElection_PetitionText" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
						</DIV>
						
						<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Candidate Address Line 2</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position Order" name="DisplayOrder" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Candidate Address Line 3</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Petition Position Tex" name="CandidateElection_PetitionText" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
						</DIV>
						
						<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">3 letters party</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Party 3 letters party" name="PartyName" VALUE="<?= $FormFieldState ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Uniq State VoterID</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Petition Position Tex" name="Candidate_UniqStateVoterID" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
						</DIV>
						
						<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Team ID</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position Order" name="DisplayOrder" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">CandidateElection_PetitionText</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Petition Position Tex" name="CandidateElection_PetitionText" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
						</DIV>
						
						

						<div>						
							<dl class="form-group col-12 d-inline-block"> 
								<dd>
									<button type="submit" class="submitred"><?= $ButtonText ?></button>
								</dd>
							</dl>
						</div>
					</form> 


				</div>
			</div>
		</div>
	</DIV>
</div>	

</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>