<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "profile";  
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if ( empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }	
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = PrintParty($URIEncryptedString["UserParty"]);

  if ( empty ($URIEncryptedString["Position"])) { 
		header("Location: /" . $k . "/ldg/profilecandidate");
		exit();
	}
	
	$rmb = new RepMyBlock();
	//$rmbperson = $rmb->ReturnVoterIndex($URIEncryptedString["VotersIndexes_ID"]);
	$rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
	$listpositions = $rmb->ListElectedPositions($rmbperson["DataState_Abbrev"]);

	
	echo "URIEncryptedString:<BR>";
	echo "<PRE>" . print_r($URIEncryptedString, 1) . "</PRE>";
	
	echo "RMBPerson:<BR>";
	echo "<PRE>" . print_r($rmbperson, 1) . "</PRE>";
	
	echo "listpositions:<BR>";
	echo "<PRE>" . print_r($listpositions, 1) . "</PRE>";	
	
	exit();
	

	
	// This the the logic for populating the candidate field
	if ( ! empty ($_POST)) {

		// Rules for different races.		
		$CandidateLogic = $_POST;
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/candidatelogic.php";
		
		$EncryptedURL = "SystemUser_ID=" . $URIEncryptedString["SystemUser_ID"] .
										"&FirstName=" . $URIEncryptedString["FirstName"] . 
										"&LastName=" . $URIEncryptedString["LastName"] .
										"&VotersIndexes_ID=" . $URIEncryptedString["VotersIndexes_ID"] . 
										"&UniqNYSVoterID=" . $URIEncryptedString["UniqNYSVoterID"] . 
										"&MenuDescription=" . urlencode($URIEncryptedString["MenuDescription"]) . 
										"&UserParty=" . $URIEncryptedString["UserParty"];
		
		header("Location: /" . rawurlencode(UrlEncrypt($EncryptedURL)) . "/ldg/verifydone");
		exit();
		
	}
	
		$TopMenus = array ( 
								array("k" => $k, "url" => "profile/profile", "text" => "Public Profile"),
								array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
								array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile")
							);
	
	
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>
<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Candidate Profile</h2>
			  </div>
  		
  		<?php
			 	PlurialMenu($k, $TopMenus);
			?>
					
				<div class="Box">
			  	<div class="Box-header pl-0">
			    	<div class="table-list-filters d-flex">
			  			<div class="table-list-header-toggle states flex-justify-start pl-3">Open positions to run for in the <?= $Party ?> Party</div>
			  		</div>
			    </div>
			    
			    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
			      We don't know your district <a href="/voter">create one</a>?
			    </div>

					<div id="voters">

							
									<div class="list-group-item filtered">
									
										<span><B><?= $PartyPosition ?></B></span>  
										
									
											          			
									</div>
										
								 <DIV class="panels">
								 	
								 	
			<?php
							if ( ! empty ($rmbperson)) {
								foreach ($rmbperson as $index => $var) { 
									
									$PetitionFullName = "";
									if ( ! empty ($var["Raw_Voter_FirstName"])) { $PetitionFullName .= ucwords(strtolower(trim($var["Raw_Voter_FirstName"]))) . " "; }
									if ( ! empty ($var["Raw_Voter_MiddleName"])) { $PetitionFullName .= ucwords(strtolower(trim($var["Raw_Voter_MiddleName"]))) . " "; }
									if ( ! empty ($var["Raw_Voter_LastName"])) { $PetitionFullName .= ucwords(strtolower(trim($var["Raw_Voter_LastName"]))); }
									if ( ! empty ($var["Raw_Voter_Suffix"])) { $PetitionFullName .= " " . ucwords(strtolower(trim($var["Raw_Voter_Suffix"]))); }
					
									$PetitionFullAddress = "";
									if ( ! empty ($var["Raw_Voter_ResHouseNumber"])) { $PetitionFullAddress .= ucwords(strtolower(trim($var["Raw_Voter_ResHouseNumber"]))) . " "; }
									if ( ! empty ($var["Raw_Voter_ResFracAddress"])) { $PetitionFullAddress .= ucwords(strtolower(trim($var["Raw_Voter_ResFracAddress"]))) . " "; }
									if ( ! empty ($var["Raw_Voter_ResPreStreet"])) { $PetitionFullAddress .= ucwords(strtolower(trim($var["Raw_Voter_ResPreStreet"]))) . " "; }
									if ( ! empty ($var["Raw_Voter_ResStreetName"])) { $PetitionFullAddress .= ucwords(strtolower(trim($var["Raw_Voter_ResStreetName"]))) . " "; }
									if ( ! empty ($var["Raw_Voter_ResPostStDir"])) { $PetitionFullAddress .= ucwords(strtolower(trim($var["Raw_Voter_ResPostStDir"]))) . " "; }
									if ( ! empty ($var["Raw_Voter_ResApartment"])) { $PetitionFullAddress .= "- Apt. " . strtoupper(trim($var["Raw_Voter_ResApartment"])) . ", "; }
									if ( ! empty ($var["Raw_Voter_ResCity"])) { $PetitionFullAddress .= ucwords(strtolower(trim($var["Raw_Voter_ResCity"]))) . ", NY "; }
									if ( ! empty ($var["Raw_Voter_ResZip"])) { $PetitionFullAddress .= ucwords(strtolower(trim($var["Raw_Voter_ResZip"]))); }
			    						
									?>
									<div class="list-group-item">
									<INPUT TYPE="radio" NAME="Voter_ID" VALUE="<?= $result[$index]["Raw_Voter_ID"] ?>">&nbsp;&nbsp;					
									<INPUT TYPE="hidden" NAME="Gender" VALUE="<?= $result[$index]["Raw_Voter_Gender"] ?>">
									<INPUT TYPE="hidden" NAME="EnrollPolParty" VALUE="<?= $result[$index]["Raw_Voter_EnrollPolParty"] ?>">
									<INPUT TYPE="hidden" NAME="CountyCode" VALUE="<?= $result[$index]["Raw_Voter_CountyCode"] ?>">
									<INPUT TYPE="hidden" NAME="ElectDistr" VALUE="<?= $result[$index]["Raw_Voter_ElectDistr"] ?>">
									<INPUT TYPE="hidden" NAME="TownCity" VALUE="<?= $result[$index]["Raw_Voter_TownCity"] ?>">
									<INPUT TYPE="hidden" NAME="CongressDistr" VALUE="<?= $result[$index]["Raw_Voter_CongressDistr"] ?>">
									<INPUT TYPE="hidden" NAME="SenateDistr" VALUE="<?= $result[$index]["Raw_Voter_SenateDistr"] ?>">
									<INPUT TYPE="hidden" NAME="AssemblyDistr" VALUE="<?= $result[$index]["Raw_Voter_AssemblyDistr"] ?>">
									<INPUT TYPE="hidden" NAME="DOB" VALUE="<?= $result[$index]["Raw_Voter_DOB"] ?>">

									<INPUT TYPE="hidden" NAME="PetitionName" VALUE="<?= $PetitionFullName ?>">
									<INPUT TYPE="hidden" NAME="PetitionAddress" VALUE="<?= $PetitionFullAddress ?>">

	

			<?php				print " INDEX: $index<BR>";
									echo "</div>";
								}
							}
			?>
								
			</div>
						
						<?php /* 	<A HREF="input/?k=<?= $k ?>">
						<p><button type="submit" class="btn btn-primary">Select another Voter Card.</button></p>
						</A> */ ?>

					
					</div>

				</div>
			</div>		
		</div>
	</div>
</DIV>
				

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
