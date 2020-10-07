<?php
	$Menu = "admin";
	$BigMenu = "represent";	
		 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
	
  if ( empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	
	$rmb = new repmyblock();	
	if ( ! empty ($URIEncryptedString["CandidatePositions_ID"])) {		
		$result = $rmb->DisplayElectionPositions($URIEncryptedString["CandidatePositions_ID"]);
		WriteStderr($result, "DisplayElectionPositions");
	}
	
	if (! empty($_POST)) {	
		
		// Need to add or update depending.
		
		/*	
		header("Location: /admin/" .  CreateEncoded ( array( 
								"Query_FirstName" => $_POST["FirstName"],
								"Query_LastName" => $_POST["LastName"], 
								"Query_AD" => $_POST["AD"],
								"Query_ED" => $_POST["ED"],
								"Query_ZIP" => $_POST["ZIP"],
								"Query_COUNTY" => $_POST["COUNTY"],
								"Query_PARTY" => $_POST["Party"],
								"Query_NYSBOEID" => $_POST["UniqNYS"],
								"Query_Congress" => $_POST["Congress"],
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
						    "FirstName" => $URIEncryptedString["FirstName"],
						    "LastName" => $URIEncryptedString["LastName"],
						    "UniqNYSVoterID" => $URIEncryptedString["UniqNYSVoterID"],
						   	"SystemAdmin" => $URIEncryptedString["SystemAdmin"]
					)) . "/setup_elections");
			*/
		exit();
	}
	
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
				
				
					
				<B>Add a Candidate position</B>
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Position Name</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position Name" name="State" VALUE="<?= $FormFieldPositionName ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">DB Table Abbreviation</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="DB Table Abbreviation" name="LastName" VALUE="<?= $FormFieldDBTable ?>" id="">
								</dd>
							</dl>
							
							</div>
							
						
								<div>
							
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Position State</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position State" name="ZIP" VALUE="<?= $FormFieldState ?>" id="">
								</dd>
							</dl>
							
								<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Type of Position</label><DT>
								<dd>
									<SELECT CLASS="mobilebig" NAME="COUNTY">
									<OPTION VALUE="">&nbsp;</OPTION>
									<OPTION VALUE="Party Position"<?php if ($FormFieldType == "party") { echo " SELECTED"; } ?>>Party Position</OPTION>
									<OPTION VALUE="Elected Office"<?php if ($FormFieldType == "office") { echo " SELECTED"; } ?>>Elected Position</OPTION>
									</SELECT>
								</dd>
							</dl>
							
						</DIV>

					<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Position Order</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Position Order" name="UniqNYS" VALUE="<?= $FormFieldPosition ?>" id="">
								</dd>
							</dl>
				
						</DIV>
						
						
								
						<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Congressional District</label><DT>
								<dd>
									<textarea class="form-control user-profile-bio-field js-length-limited-input" placeholder="Description of the position" data-input-max-length="160" data-warning-text="{{remaining}} remaining" name="profile_bio" id="user_profile_bio"><?= $FormFieldExplanation ?></textarea>
									<p class="js-length-limited-input-warning user-profile-bio-message d-none"></p>
								</dd>
							</dl>
						</div>

						<div>						
							<dl class="form-group col-12 d-inline-block"> 
								<dd>
									<button type="submit" class="btn btn-primary mobilemenu"><?= $ButtonText ?></button>
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