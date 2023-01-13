<?php
	$Menu = "profile";  
	$BigMenu = "profile";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";
	include_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/DeadlineDates.php"; 
	
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if (empty ($URIEncryptedString["VotersIndexes_ID"])) { header("Location: /" . $k . "/lgd/profile/input"); exit(); }
	
	$rmb = new repmyblock();
	$Party = PrintParty($URIEncryptedString["UserParty"]);
	//	$rmbperson = $rmb->SearchVotersBySingleIndex($URIEncryptedString["VotersIndexes_ID"], $DatedFiles);
	//$rmbperson = $rmb->SearchVoterDBbyNYSID($URIEncryptedString["UniqNYSVoterID"], $DatedFiles);

	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	WriteStderr($rmbperson, "SearchUserVoterCard");

	if ( ! empty ($_POST) ) {
	
		WriteStderr($_POST, "Post Saving Information");
		
		if ( empty ($rmbperson["SystemUserSelfDistrict_ID"]) && empty ($rmbperson["SystemUserSelfDistrict_ID"]) ||
					empty ($rmbperson["SystemUserSelfDistrict_ID"]) && empty ($rmbperson["SystemUserSelfDistrict_ID"])) {
				$rmb->UpdateTempDistrict("insert", $URIEncryptedString["SystemUser_ID"], $_POST["AD"], 
																	$_POST["ED"], $_POST["CG"], $_POST["SN"]);
		} else {
			$rmb->UpdateTempDistrict("update", $URIEncryptedString["SystemUser_ID"], $_POST["AD"], 
																	$_POST["ED"], $_POST["CG"], $_POST["SN"], $rmbperson["SystemUserSelfDistrict_ID"]);
		}
						
		header("Location: /" .  CreateEncoded ( array( 
					"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
					"VotersIndexes_ID" => $URIEncryptedString["Voters_ID"],
					"UniqNYSVoterID" => $URIEncryptedString["VotersIndexes_UniqStateVoterID"],
					"UserParty" => $URIEncryptedString["UserParty"]
		)) . "/lgd/profile/profilevoter");
		exit();
	}
	
	
	
	
	// Check the other database
	// To be removed later on when I finihs fixing the table.
	// $RawVoterNY = $rmb->SearchRawVoterInfo($rmbperson["Voters_UniqStateVoterID"]);
	// $RawVoterNY = $RawVoterNY[0];
	// WriteStderr($RawVoterNY, "RawVoterNY");
	
	// Need to go find the right data.

	$TopMenus = array (
						array("k" => $k, "url" => "profile/user", "text" => "Public Profile"),
						array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
						array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile"),
						array("k" => $k, "url" => "profile/profileteam", "text" => "Team Profile")
					);
					
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; $Width="64";} else { $Cols = "col-9"; $Width="16"; }
?>
<div class="row">
  <div class="main">
  	
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Voter Profile</h2>
			  </div>
			     
			<?php	PlurialMenu($k, $TopMenus); ?>
			
			<div class="col-12">

			<?php if (! empty ($ErrorMsg)) { ?>
				
				<div class="mt-0 mb-0">
			    <h3 id="" class="Subhead-heading"><?= $ErrorMsg ?></h3>
			  </div>
				
			<?php } ?>

				<FORM ACTION="" METHOD="POST">
				<div class="Box">
					<div class="Box-header pl-0">
						<div class="table-list-filters d-flex">
							<div class="table-list-header-toggle states flex-justify-start pl-3 f60">Voter Card</div>
						</div>
					</div>
				
					<div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
						We don't know your district <a href="/voter">create one</a>?
					</div>
					
					<div id="voters">
						<div class="list-group-item filtered f60">
							
							<?php 
								// This need to be updated for the right state						
								preg_match('/^NY0+(.*)/', $rmbperson["VotersIndexes_UniqStateVoterID"], $UniqMatches, PREG_OFFSET_CAPTURE);
								$UniqVoterID = $rmbperson["DataState_Abbrev"] . $UniqMatches[1][0]; 
						?>
						
								<P class="f60">
									We noted that you don't have registration information. Without that information we can't create the petitions 
									required to run for office. 
								</P>
								
								<P class="f60">									
										To enable the petition menu, you can look up your voter registration on the Board of Elections 
										website. We'll reach out to you the next time we upload a new voter file.
								</P>
								
								<P>
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">AD<SUP>*</SUP></div>
											<div class="table-header-cell">ED<SUP>*</SUP></div>
											<div class="table-header-cell">Congress</div>
											<div class="table-header-cell">Senate</div>
										</div>

										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><INPUT TYPE="TEXT" NAME="AD" VALUE="<?= $rmbperson["SystemUserSelfDistrict_AD"] ?>" SIZE=2></div>
												<div class="table-body-cell"><INPUT TYPE="TEXT" NAME="ED" VALUE="<?= $rmbperson["SystemUserSelfDistrict_ED"] ?>" SIZE=2></div>
												<div class="table-body-cell"><INPUT TYPE="TEXT" NAME="CG" VALUE="<?= $rmbperson["SystemUserSelfDistrict_CG"] ?>" SIZE=2></div>
												<div class="table-body-cell"><INPUT TYPE="TEXT" NAME="SN" VALUE="<?= $rmbperson["SystemUserSelfDistrict_SN"] ?>" SIZE=2></div>
											</div>													
										</div>
									</div>
								</P>	
								
								<P>
									<I>
									  <B>AD:</B> Assembly District - <B>ED:</B> Electoral District
									</I>
								</P>
								
								<p><button type="submit" class="submitred">Save the information</button></p>
							
						</div>
						
						 
						
						
					</FORM>
					
					</div>

				</div>
			</div>		
		</div>
	</div>
</DIV>





<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
