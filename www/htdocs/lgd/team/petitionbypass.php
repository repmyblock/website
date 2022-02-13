<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	// $BigMenu = "represent";
	$Menu = "team";  
	
 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	WriteStderr($URIEncryptedString, "URIEncryptedString");	
	
	
	if ( ! empty ($_POST)) {
		WriteStderr($_POST, "Input \$_POST");
	
		header("Location: /" . CreateEncoded ( array( 
								"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
								"Candidate_ID" => $return["Candidate_ID"],
								"CandidateProfile_ID" => $profile_candidate["CandidateProfile_ID"],
								"PetitionStateID" => $_POST["ElectionStateID"],
								"CPrep_First"	=> trim($_POST["FirstName"]), 
								"CPrep_Last"	=> trim($_POST["LastName"]), 
								"CPrep_Full"	=> trim($_POST["FullName"]), 
								"CPrep_Email"	=> trim($_POST["Email"]),
								"CPrep_Address1" => trim($_POST["Address1"]),
								"CPrep_Address2" => trim($_POST["Address2"]),
								"CPrep_Address3" => trim($_POST["Address3"]),
							)) . "/lgd/team/petitiondetails");
		exit();
	}

	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($UserParty);
	$states = $rmb->ListStates();

	$TopMenus = array ( 
						array("k" => $k, "url" => "team/team", "text" => "Manage Pledges"),
						array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
						array("k" => $k, "url" => "team/teamcandidate", "text" => "Manage Candidates")
					);			
	WriteStderr($TopMenus, "Top Menu");					
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) {	 $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Manual candidate definition</h2>
			  </div>
  
			<?php
			 	PlurialMenu($k, $TopMenus);
			?>


			  <div class="clearfix gutter d-flex flex-shrink-0">
		
					<div class="col-16">
	
						<?= $error_msg ?>
						
						<P>
							<A HREF="/<?= $k ?>/lgd/team/target">Use the automatic petition verificator</A>								
						</P>
	
					  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
							<div>
								<dl class="form-group col-3 d-inline-block"> 
									<dt><label for="user_profile_name">First Name</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="First" name="FirstName"<?php if (!empty ($FirstName)) { echo " VALUE=" . $FirstName; } ?> id="user_profile_name">
									</dd>
								</dl>
			
								<dl class="form-group col-3 d-inline-block"> 
									<dt><label for="user_profile_name">Last Name</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="Last" name="LastName"<?php if (!empty ($LastName)) { echo " VALUE=" . $LastName; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
							
							<div>
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Full Name as shown on petition</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="FullName" name="FullName"<?php if (!empty ($FullName)) { echo " VALUE=" . $FullName; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
							
							<div>
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Petition State</label><DT>
									<dd>
										<SELECT NAME="ElectionStateID">
											<OPTION VALUE="">&nbsp;</OPTION>
										<?php if (! empty ($states)) {
														foreach ($states as $var) {
															if ( ! empty ($var)) { ?>
																<OPTION VALUE="<?= $var["DataState_ID"] ?>"><?= $var["DataState_Abbrev"] . " - " . 
																											$var["DataState_Name"] ?></OPTION>
										<?php     }
														}
													} ?>
										</SELECT>
									</dd>
								</dl>
						</DIV>
							
							
							<div>
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Address on petition</label><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="Address Line 1" name="Address1"<?php if (!empty ($Address1)) { echo " VALUE=" . $Address1; } ?> id="user_profile_name">
									</dd>
									<dd>
										<input class="form-control" type="text" Placeholder="Address Line 2" name="Address2"<?php if (!empty ($Address2)) { echo " VALUE=" . $Address2; } ?> id="user_profile_name">
									</dd>
									<dd>
										<input class="form-control" type="text" Placeholder="Address Line 3" name="Address3"<?php if (!empty ($Address3)) { echo " VALUE=" . $Address3; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
			
							<div>
								<dl class="form-group col-6 d-inline-block"> 
									<dt><label for="user_profile_name">Public Candidate email</label> <I>(that email will be displayed on website)</I><DT>
									<dd>
										<input class="form-control" type="text" Placeholder="Candidate Email" name="Email"<?php if (!empty ($Email)) { echo " VALUE=" . $Email; } ?> id="user_profile_name">
									</dd>
								</dl>
							</DIV>
							
			
								<p><button type="submit" class="btn btn-primary">Setup the candidate petition</button></p>
			
							</form> 
			
							</div>
				  	</div>
			  	</div>
				</div>
			</div>		
		</div>
	</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
