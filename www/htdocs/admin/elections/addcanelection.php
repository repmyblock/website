<?php
	$Menu = "admin";
		 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
	
  if ( empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	
	$rmb = new repmyblock();	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	
	if ( ! empty ($URIEncryptedString["CandidatePositions_ID"])) {		
		$result = $rmb->DisplayElectionPositions($URIEncryptedString["CandidatePositions_ID"]);
		WriteStderr($result, "DisplayElectionPositions");
	}
	
	if (! empty($_POST)) {
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
															"CandidateElection_ID" => $CandidateElection_ID,							
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
			  	<h2 class="Subhead-heading">Political Positions</h2>
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
				
				
					
				<B>Add a candidate election</B>
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Position Name</label><DT>
								<dd>
									
									<SELECT NAME="CandidateElection">
										<OPTION VALUE="">&nbsp;</OPTION>
										<?php 
											if ( ! empty ($rmbpositions)) {
												foreach($rmbpositions as $var) {
													if (! empty ($var)) { ?>
														<OPTION VALUE="<?= $var["ElectionsPosition_ID"] ?>"><?= ( $var["ElectionsPosition_DBTable"] ? $var["ElectionsPosition_DBTable"] . " - " : NULL ) . $var["ElectionsPosition_Name"] . " (" . $var["ElectionsPosition_Type"] . ( $var["ElectionsPosition_Party"] ? " - " . $var["ElectionsPosition_Party"] : NULL ) . ")" ?></OPTION>
										<?php } 
											} 
										} ?>
									</SELECT>
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Election Dates</label><DT>
								<dd>
									
											
									<SELECT NAME="ElectionID">
										<OPTION VALUE="">&nbsp;</OPTION>
										<?php 
											if ( ! empty ($rmbelections)) {
												foreach($rmbelections as $var) {
													if (! empty ($var)) { ?>
														<OPTION VALUE="<?= $var["Elections_ID"] ?>"><?= ( $var["ElectionsPosition_DBTable"] ? $var["ElectionsPosition_DBTable"] . " - " : NULL ) . $var["Elections_Text"] . " " . $var["ElectionsPosition_Type"] . ( $var["Elections_Date"] ? " (" . $var["Elections_Date"] . ")" : NULL ) ?></OPTION>
										<?php } 
											} 
										} ?>
									</SELECT>

								</dd>
							</dl>
						</div>

						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Type of Position</label><DT>
								<dd>
									<SELECT class="mobilebig" NAME="PositionType">
									<OPTION VALUE="">&nbsp;</OPTION>
									<OPTION VALUE="party"<?php if ($FormFieldType == "party") { echo " SELECTED"; } ?>>Party Position</OPTION>
									<OPTION VALUE="electoral"<?php if ($FormFieldType == "electoral") { echo " SELECTED"; } ?>>Elected Position</OPTION>
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
								<dt class="mobilemenu"><label for="user_profile_name">CandidateElection_Text</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Candidate" name="CandidateElection_Text" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">CandidateElection_PetitionText</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Petition Position Tex" name="CandidateElection_PetitionText" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
						</DIV>
						
						<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Position Display Order</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position Order" name="DisplayOrder" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">CandidateElection_SignDeadline</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position Order" name="DeadLine" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
						</DIV>
						
						<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">URL Explanation</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position Order" name="URL" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Position #s of candidates</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position Order" name="NumberCandidates" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
						</DIV>
						
						<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">DB Table VALUE</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position Order" name="DBTableValue" VALUE="<?= $FormFieldPosition ?>" id="">
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