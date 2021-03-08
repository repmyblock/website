<?php
	$Menu = "admin";
	$BigMenu = "represent";	
		 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	
	$rmb = new repmyblock();
	$Party = NewYork_PrintParty($UserParty);
	
	if (! empty($_POST)) {	
		
		
		echo "<PRE>" . print_r($_POST,1 ) . "</PRE>";
														
		$result = $rmb->InsertCandidateSet($_POST["Candidate_ID"], $_POST["CandidatePetitionSet_ID"], $_POST["Party"], $_POST["County_ID"]);		
		echo "<PRE>" . print_r($result, 1 ) . "</PRE>";
		
		
		$svar = "https://pdf.repmyblock.nyc/NYS/s" . $_POST["CandidatePetitionSet_ID"] . "/multipetitions";
		$pvar = "https://pdf.repmyblock.nyc/NYS/p" . $result["CanPetitionSet_ID"] . "/multipetitions";
		
		echo "<A HREF=\"" . $svar . "\">" . $svar . "</A><BR>";
		echo "<A HREF=\"" . $pvar . "\">" . $pvar . "</A><BR>";
		
		
		exit();
		
		exit();
		
			
		header("Location: /admin/" .  CreateEncoded ( array( 
								"Query_Username" => $_POST["Username"],
								"Query_Email" => $_POST["Email"],
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
					)) . "/userlist");
		exit();
	}

	$FormFieldParty = $URIEncryptedString["UserParty"];

	if ( ! empty ($URIEncryptedString["RetReturnFirstName"])) { $FormFieldFirstName = $URIEncryptedString["RetReturnFirstName"]; }
	if ( ! empty ($URIEncryptedString["RetReturnLastName"])) { $FormFieldLastName = $URIEncryptedString["RetReturnLastName"]; }
	if ( ! empty ($URIEncryptedString["RetReturnAD"])) { $FormFieldAD = $URIEncryptedString["RetReturnAD"];  }
	if ( ! empty ($URIEncryptedString["RetReturnED"])) { $FormFieldED = $URIEncryptedString["RetReturnED"]; }
	if ( ! empty ($URIEncryptedString["RetReturnZIP"])) { $FormFieldZIP = $URIEncryptedString["RetReturnZIP"]; }
	if ( ! empty ($URIEncryptedString["RetReturnCOUNTY"])) { $FormFieldCounty = $URIEncryptedString["RetReturnCOUNTY"]; }
	if ( ! empty ($URIEncryptedString["RetReturnNYSBOEID"])) { $FormFieldNYSBOEID = $URIEncryptedString["RetReturnNYSBOEID"]; }
	if ( ! empty ($URIEncryptedString["RetReturnCongress"])) { $FormFieldCongress = $URIEncryptedString["RetReturnCongress"]; }
	if ( ! empty ($URIEncryptedString["RetReturnPARTY"])) { $FormFieldParty = $URIEncryptedString["RetReturnPARTY"]; }
	if ( ! empty ($URIEncryptedString["RetReturnUsername"])) { $FormFieldUsername = $URIEncryptedString["RetReturnUsername"]; }
	if ( ! empty ($URIEncryptedString["RetReturnEmail"])) { $FormFieldEmail = $URIEncryptedString["RetReturnEmail"]; }
	
$TopMenus = array ( 
							array("k" => $k, "url" => "create_petition", "text" => "Petitions"),
							array("k" => $k, "url" => "create_witnesses", "text" => "Witnesses"),
							array("k" => $k, "url" => "create_election", "text" => "Election"),
							array("k" => $k, "url" => "create_candidateset", "text" => "Petition Set"),
							array("k" => $k, "url" => "copy_candidateset", "text" => "Copy Set")
						);			
	
													
	WriteStderr($TopMenus, "Top Menu");		

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="<?= $DIVCol ?> float-left">

				<div class="Subhead">
			  	<h2 class="Subhead-heading">Create Petition</h2>
				</div>
			
		<?php
				PrintVerifMenu($VerifEmail, $VerifVoter);
			 	PlurialMenu($k, $TopMenus, "admin");
			?>
			
			<?php if (! empty ($URIEncryptedString["ErrorMsg"])) {
		    	
		    	echo "<FONT COLOR=BROWN SIZE=+1><B>" . $URIEncryptedString["ErrorMsg"] . "</B></FONT>";
		    	echo "<BR><BR>";	
		    } ?>
				
				
			
				    
				<div class="clearfix gutter d-flex flex-shrink-0">
									
				<div class="col-12">
				  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
				
							
							<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">CandidatePetitionSet_ID</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="CandidatePetitionSet_ID" name="CandidatePetitionSet_ID" VALUE="<?= $FormFieldCandidate_DispName ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Candidate_ID</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Candidate_ID" name="Candidate_ID" VALUE="<?= $FormFieldCandidate_DispResidence ?>" id="">
								</dd>
							</dl>
							
							</div>
							
						
							
									<div>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">County ID</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="County ID" name="County_ID" VALUE="<?= $FormFieldCandidateElection_ID ?>" id="">
								</dd>
							</dl>

							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Party</label><DT>
								<dd>
									<SELECT  CLASS="mobilebig" NAME="Party">
										<OPTION VALUE="">All</OPTION>
										<OPTION VALUE="DEM"<?php if ($FormFieldParty == "DEM") { echo " SELECTED"; } ?>>Democratic</OPTION>
										<OPTION VALUE="REP"<?php if ($FormFieldParty == "REP") { echo " SELECTED"; } ?>>Republican</OPTION>
										<OPTION VALUE="BLK"<?php if ($FormFieldParty == "BLK") { echo " SELECTED"; } ?>>No Affiliation</OPTION>
										<OPTION VALUE="GRE"<?php if ($FormFieldParty == "GRE") { echo " SELECTED"; } ?>>Green</OPTION>
										<OPTION VALUE="LBT"<?php if ($FormFieldParty == "LBT") { echo " SELECTED"; } ?>>Libertarian</OPTION>
										<OPTION VALUE="CON"<?php if ($FormFieldParty == "CON") { echo " SELECTED"; } ?>>Conservatives</OPTION>
										<OPTION VALUE="IND"<?php if ($FormFieldParty == "IND") { echo " SELECTED"; } ?>>Independence Party</OPTION>
										<OPTION VALUE="WOR"<?php if ($FormFieldParty == "WOR") { echo " SELECTED"; } ?>>Working Families</OPTION>
										<OPTION VALUE="WEP"<?php if ($FormFieldParty == "WEP") { echo " SELECTED"; } ?>>Women's Equality Party</OPTION>
										<OPTION VALUE="REF"<?php if ($FormFieldParty == "REF") { echo " SELECTED"; } ?>>Reform</OPTION>
										<OPTION VALUE="SAM"<?php if ($FormFieldParty == "SAM") { echo " SELECTED"; } ?>>SAM</OPTION>													
										<OPTION VALUE="OTH"<?php if ($FormFieldParty == "OTH") { echo " SELECTED"; } ?>>Other</OPTION>
									</SELECT>
								</dd>
							</dl>
					
							</div>
							
							
						
							

					<DIV>
							<dl class="form-group col-48 d-inline-block"> 
								<dt class="mobilemenu"><label for="user_profile_name">Order</label><DT>
								<dd>
									<input class="form-control" type="text" Placeholder="Order" name="Order" VALUE="<?= $FormFieldNYSBOEID ?>" id="">
								</dd>
							</dl>
				
								</div>

					

						<div>						
							<dl class="form-group col-12 d-inline-block"> 
								<dd>
									<button type="submit" class="btn btn-primary mobilemenu">Search User</button>
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