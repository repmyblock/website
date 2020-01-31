<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "profile";  
	$BigMenu = "represent";	

  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($SystemUser_ID)) { goto_signoff(); }
  if (empty ($UniqNYSVoterID)) { header("Location: input/?k=" . $k); exit(); }
	$rmb = new repmyblock();

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	$rmbvoters = $rmb->SearchVotersBySingleIndex($VotersIndexes_ID, $DatedFiles);	
		
	if ( empty ($VotersIndexes_ID )) {
		header("Location: input/?k=" . $k);
		exit();
	} 
	
	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);

	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>
  		<div class="col-9 float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Voter Profile</h2>
			  </div>
			     
				<nav class="UnderlineNav pt-1 mb-4" aria-label="Billing navigation">
					<div class="UnderlineNav-body">
						<a href="/lgd/profile/?k=<?= $k ?>" class="UnderlineNav-item">Public Profile</a>
						<a href="/lgd/profile/voter/?k=<?= $k ?>" class="UnderlineNav-item selected">Voter Profile</a>
						<a href="/lgd/profile/candidate/?k=<?= $k ?>" class="UnderlineNav-item">Candidate Profile</a>
					</div>
				</nav>

				<div class="Box">
					<div class="Box-header pl-0">
						<div class="table-list-filters d-flex">
							<div class="table-list-header-toggle states flex-justify-start pl-3">Voter Card</div>
						</div>
					</div>
				
					<div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
						We don't know your district <a href="/voter">create one</a>?
					</div>
					
					<div id="voters">
						
						
						<A HREF="input/?k=<?= $k ?>">
						<p><button type="submit" class="btn btn-primary">Select another Voter Card.</button></p>
						</A>
							
						
						<div class="list-group-item filtered">
							
						
							
							VotersIndexes_ID: <?= $rmbvoters["VotersIndexes_ID"] ?><BR>
						 	Raw_Voter_ID: <?= $rmbvoters["Raw_Voter_ID"] ?><BR>
						 	RawVoterID: <?= $RawVoterID ?><BR>
						 	UNIQ_VOTER_ID: <?= $rmbvoters["Raw_Voter_UniqNYSVoterID"] ?><BR>
						  <BR>
						  
						  Voter Status: <?= $rmbvoters["Raw_Voter_Status"] ?><BR>
							Reason Code: <?= $rmbvoters["Raw_Voter_ReasonCode"] ?><BR>
							Voter Date Inactive: <?= $rmbvoters["Raw_Voter_VoterMadeInactive"] ?><BR>
							Voter Date Purged: <?= $rmbvoters["Raw_Voter_VoterPurged"] ?><BR>
							
							<BR>   
							     
							First Name: <?= $rmbvoters["Raw_Voter_FirstName"] ?><BR>
							Middle Name: <?= $rmbvoters["Raw_Voter_MiddleName"] ?><BR>
							Last Name: <?= $rmbvoters["Raw_Voter_LastName"] ?>			<BR>	    
							Suffix: <?= $rmbvoters["Raw_Voter_Suffix"] ?><BR>
							<BR>

							Address:<BR> 
								<?= $rmbvoters["Raw_Voter_ResHouseNumber"] ?>
							  <?= $rmbvoters["Raw_Voter_ResFracAddress"] ?>
							  <?= $rmbvoters["Raw_Voter_ResPreStreet"] ?>
							  <?= $rmbvoters["Raw_Voter_ResStreetName"] ?>
							  <?= $rmbvoters["Raw_Voter_ResPostStDir"] ?>
							  Apt #<?= $rmbvoters["Raw_Voter_ResApartment"] ?><BR>
							  <?= $rmbvoters["Raw_Voter_ResCity"] ?>, NY
							  <?= $rmbvoters["Raw_Voter_ResZip"] ?>
							  <?= $rmbvoters["Raw_Voter_ResZip4"] ?>
							<BR>

							Date of Birth: <?= $rmbvoters["Raw_Voter_DOB"] ?><BR>
							Gender: <?= $rmbvoters["Raw_Voter_Gender"] ?><BR>
							    
							Enrolled Party: <?= $rmbvoters["Raw_Voter_EnrollPolParty"] ?><BR>
							   <?= $rmbvoters["Raw_Voter_OtherParty"] ?><BR>

					 		Town City: <?= $rmbvoters["Raw_Voter_TownCity"] ?><BR>
							County: <?= $rmbvoters["DataCounty_Name"] ?><BR>
							
							Election District: <?= $rmbvoters["Raw_Voter_ElectDistr"] ?><BR>
							Assembly District:<?= $rmbvoters["Raw_Voter_AssemblyDistr"] ?><BR>
							SenateDistrict: <?= $rmbvoters["Raw_Voter_SenateDistr"] ?><BR>
							Congressional District: <?= $rmbvoters["Raw_Voter_CongressDistr"] ?><BR>
							Legislative District: <?= $rmbvoters["Raw_Voter_LegisDistr"] ?><BR>								  
							Ward: <?= $rmbvoters["Raw_Voter_Ward"] ?><BR>

							Last Time Voted: <?= $rmbvoters["Raw_Voter_LastDateVoted"] ?><BR>
							<BR>
						</div>

					 	<DIV class="panels">
							<div class="list-group-item">	
								<?php  
								
											echo "<BR>";
									echo "<B>RMBVOTERS</B><BR>";
									if ( ! empty ($rmbvoters )) {
										foreach ($rmbvoters as $index => $var) {
										
											print "INDEX: $index<BR>";
											
											if ( ! empty ($var)) {
												foreach ($var as $index2 => $vor) {
													if ( ! empty ($vor)) {
														
														print "VAR: $var : $vor : $index2<BR>";
													}
												}
											}
										}
									}
									
									echo "<BR>";
									echo "<B>RMBVOTERIDX</B><BR>";
									if ( ! empty ($rmbvoters )) {
										foreach ($rmbvoteridx as $index => $var) {
										
											print "INDEX: $index<BR>";
											
											if ( ! empty ($var)) {
												foreach ($var as $index2 => $vor) {
													if ( ! empty ($vor)) {
														
														print "VAR: $index2 : $vor<BR>";
													}
												}
											}
										}
									}
									
										
								?>
				
							
							</div>
						</div>
					</div>

				</div>
			</div>		
		</div>
	</div>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>