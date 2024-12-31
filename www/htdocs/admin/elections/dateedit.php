<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
 	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php"; 
 
  if ( empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	
	$rmb = new RMBAdmin();	
	$rmbstates = $rmb->ListStates();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$rmbdate = $rmb->ListElectionsDates(NULL, NULL, NULL, NULL, $URIEncryptedString["Elections_ID"])[0];
	
	WriteStderr($rmbdate, "Date Table");
	
	if (! empty($_POST)) {
		// Need to add or update depending.
		
		print "<PRE>" . print_r($_POST, 1) . "</PRE>";
		
		if ($_POST["Election_Date"] != $_POST["Election_Date_Orig"]) {
			$NewElectionDate = $_POST["Election_Date"];
		} else {
			$NewElectionDate = NULL;
		}
		
		if ($_POST["Election_Text"] != $_POST["Election_Text_Orig"]) {
			$NewElectionsText = $_POST["Election_Text"];
		} else {
			$NewElectionsText = NULL;
		}
		
		if ($_POST["Election_StateID"] != $_POST["Election_StateID_Orig"]) {
			$NewStateID = $_POST["Election_StateID"];
		} else {
			$NewStateID = NULL;
		}
		
		if ($_POST["Election_Type"] != $_POST["Election_Type_Orig"]) {
			$NewElectionType = $_POST["Election_Type"];
		} else {
			$NewElectionType = NULL;
		}
		
		$rmb->UpdateElectionDate($URIEncryptedString["Elections_ID"], $NewElectionDate, $NewElectionsText, $NewStateID, $NewElectionType);
		
		header("Location: /" .  CreateEncoded ( array( 
									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
									"SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"]
					)) . "/admin/elections/datemgmt");
		exit();
	}
	
	$ButtonText = "Update Date";
	$FormFieldParty = $URIEncryptedString["UserParty"];

/*
	if ( ! empty ($result["CandidatePositions_Name"])) { $FormFieldPositionName = $result["CandidatePositions_Name"]; }
	if ( ! empty ($result["CandidateElection_DBTable"])) { $FormFieldDBTable = $result["CandidateElection_DBTable"]; }
	if ( ! empty ($result["CandidatePositions_State"])) { $FormFieldState = $result["CandidatePositions_State"];  }
	if ( ! empty ($result["CandidatePositions_Order"])) { $FormFieldPosition = $result["CandidatePositions_Order"]; }
	if ( ! empty ($result["CandidatePositions_Explanation"])) { $FormFieldExplanation = $result["CandidatePositions_Explanation"]; }
	if ( ! empty ($result["CandidatePositions_Type"])) { $FormFieldType = $result["CandidatePositions_Type"]; }
*/
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="<?= $DIVCol ?> float-left">

				<div class="Subhead">
			  	<h2 class="Subhead-heading">Elections Dates</h2>
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
				
				<B>Edit elections dates</B>
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Election Date</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Election Date" name="Election_Date" VALUE="<?= $rmbdate["Elections_Date"] ?>" id="">
									<input type="hidden" name="Election_Date_Orig" VALUE="<?= $rmbdate["Elections_Date"] ?>">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Election Text Description</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Election Text Description" name="Election_Text" VALUE="<?= $rmbdate["Elections_Text"] ?>" id="">
									<input type="hidden" name="Election_Text_Orig" VALUE="<?= $rmbdate["Elections_Text"] ?>">
								</dd>
							</dl>
							
							</div>
							
						
								<div>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Position State</label><DT>
								<dd>
									<SELECT class="" NAME="Election_StateID">
										<OPTION VALUE="">&nbsp;</OPTION>
										<?php if (! empty ($rmbstates)) {
														foreach ($rmbstates as $state) {
															if (! empty ($state)) {	?>
											<OPTION VALUE="<?= $state["DataState_ID"] ?>"<?php if ( $rmbdate["DataState_Abbrev"] == $state["DataState_Abbrev"] ) { echo " SELECTED"; } ?>><?= $state["DataState_Name"] ?></OPTION>
										<?php 		} 
														}
													} ?>
									</SELECT>
									<input type="hidden" name="Election_StateID_Orig" VALUE="<?= $rmbdate["DataState_ID"] ?>">
								</dd>
							</dl>
							
									
								</dd>
							</dl>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Election Type</label><DT>
								<dd>
									<SELECT class="" NAME="Election_Type">
										<OPTION VALUE="">&nbsp;</OPTION>
										<OPTION VALUE="primary"<?php if ($rmbdate["Elections_Type"] == "primary") { echo " SELECTED"; } ?>>Primary</OPTION>
										<OPTION VALUE="general"<?php if ($rmbdate["Elections_Type"] == "general") { echo " SELECTED"; } ?>>General</OPTION>
										<OPTION VALUE="special"<?php if ($rmbdate["Elections_Type"] == "special") { echo " SELECTED"; } ?>>Special</OPTION>
										<OPTION VALUE="runoff"<?php if ($rmbdate["Elections_Type"] == "runoff") { echo " SELECTED"; } ?>>Runoff</OPTION>
										<OPTION VALUE="other"<?php if ($rmbdate["Elections_Type"] == "other") { echo " SELECTED"; } ?>>Other</OPTION>									
									</SELECT>
									<input type="hidden" name="Election_Type_Orig" VALUE="<?= $rmbdate["Elections_Type"] ?>">
								</dd>
							</dl>
							
						</DIV>


						<p><button type="submit" class="submitred">Update election dates</button></p>
						
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