<?php
	$Menu = "profile";  
	$BigMenu = "represent";	

  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();
	
	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	if ( ! empty($_POST)) {
		
		$EncryptUrl = "&SystemUser_ID=". $SystemUser_ID;
		if ( $VerifVoter == 1) { $EncryptUrl .= "&VerifVoter=1"; }
		if ( $VerifEmail == 1) { $EncryptUrl .= "&VerifEmail=1"; }
		if ( ! empty($PersonFirstName)) { $EncryptUrl .= "&FirstName=" . $PersonFirstName; }
		if ( ! empty($PersonLastName)) { $EncryptUrl .= "&LastName=" . $PersonLastName; }
		if ( ! empty($UniqNYSVoterID)) { $EncryptUrl .= "&UniqNYSVoterID=" . $UniqNYSVoterID; }
		if ( ! empty($_POST["SelectCandidate"])) { $EncryptUrl .= "&VotersIndexes_ID=" . $_POST["SelectCandidate"]; }
		if ( ! empty($UserParty)) { $EncryptUrl .= "&UserParty=" . $UserParty; }
		if ( ! empty($MenuDescription)) { $EncryptUrl .= "&MenuDescription=" . $MenuDescription; }
	
		header("Location: ../result/?k=" . EncryptURL($EncryptUrl));
		exit();
	}
		
	if ( ! empty($vi)) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
		$rmb = new RepMyBlock();
		$result = $rmb->SearchVotersIndexesDB($vi, $DatedFiles);
	}
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <form class="edit_user" id="" action="" accept-charset="UTF-8" method="post">
			
			    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Voter Profile</h2>
			  </div>
  
<?php 
				if ($verif_email == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
				} else if ($verif_voter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
				} 
?>
     
				<nav class="UnderlineNav pt-1 mb-4" aria-label="Billing navigation">
					<div class="UnderlineNav-body">
						<a href="/lgd/profile/?k=<?= $k ?>" class="mobilemenu UnderlineNav-item selected">Public Profile</a>
						<a href="/lgd/profile/voter/?k=<?= $k ?>" class="mobilemenu UnderlineNav-item">Voter Profile</a>
						<a href="/lgd/profile/candidate/?k=<?= $k ?>" class="mobilemenu UnderlineNav-item">Candidate Profile</a>
					</div>
				</nav>

			 <div class="Box">
			  	<div class="Box-header pl-0">
			    	<div class="table-list-filters d-flex">
			  			<div class="table-list-header-toggle states flex-justify-start pl-3">Select your voter registration</div>
			  		</div>
			    </div>
			    
			    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
			      We don't know your district <a href="/voter">create one</a>?
			    </div>

					<div id="voters" >
<?php

						$Counter = 0;
						if ( ! empty ($result)) {
							foreach ($result as $var) {
								if ( ! empty ($var)) { 
									
									$FullName = $var["Raw_Voter_FirstName"] . " " . 
															$var["Raw_Voter_MiddleName"]  . " " . 
															$var["Raw_Voter_LastName"] . " " . 
															$var["Raw_Voter_Suffix"];
								 	
									$Age = date_diff(date_create($var["Raw_Voter_DOB"]), date_create('today'))->y;
									$Party = $var["Raw_Voter_EnrollPolParty"];
									$Address = $var["Raw_Voter_ResHouseNumber"] . " " .
								            	$var["Raw_Voter_ResFracAddress"] . " " .  
									            $var["Raw_Voter_ResPreStreet"] . " " .
									            $var["Raw_Voter_ResStreetName"] . " " .
									            $var["Raw_Voter_ResPostStDir"] . " " .
															$var["Raw_Voter_ResApartment"] .  " " .
															$var["Raw_Voter_ResCity"] .  " " .
															$var["Raw_Voter_ResZip"];												
															
									$Gender = $var["Raw_Voter_Gender"];
			            
			            $District = "AD" . $var["Raw_Voter_AssemblyDistr"] . " " . 
			            						"ED" . $var["Raw_Voter_ElectDistr"] . " " .
			            						"Town: " . $var["Raw_Voter_TownCity"] . " " .
			            						"BOD Status: " . $var["Raw_Voter_Status"];
										?>
								<div class="list-group-item">
									<INPUT TYPE="radio" NAME="SelectCandidate" VALUE="<?= $var["VotersIndexes_ID"] ?>">&nbsp;&nbsp;
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									&nbsp;<?= $FullName ?>&nbsp;
									Age: <?= $Age ?> - <?= $Gender ?>
									Party: <?= $Party  ?><BR>
									<span class="ml-1">&nbsp;&nbsp;&nbsp;&nbsp;<?= $Address ?></span> 
									<BR><svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
									District Info: <?= $District ?>
								</div>			
<?php			}
				}
			} ?>
								</div>
							</div>
	
						<BR>		
						<p><button type="submit" class="btn btn-primary">Select your registration</button></p>
					</div>
				</FORM>

				</div>
			</div>		
		</div>
	</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>