<?php
	$HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://www.repmyblock.org/images/status/RepMyBlockLiveStatus.jpg";
	$HeaderTwitterDesc = "Political Clubs, these are the current NYC District being represented by a local in district. Please refrain to presenting carpetbaggers.";   
	$HeaderTwitterTitle = "2023 Live Petitioning Status.";   
	
	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGImageWidth = "712";
	$HeaderOGImageHeight = "460";

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";		
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_nolog.php";	

	$rmb = new NoLog();
	$StatusList = $rmb->AreaPetition("1374", "ADED");
	
	
	if ( ! empty ($StatusList) ) {
		foreach ($StatusList as $var) {
			if ( ! empty ($var) ) {
					$TotalCandidate += $var["TOTAL"];
			}
		}
	}

#        require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
#        require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

       
        include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>
<DIV class="main">

        <DIV class="right f80">2023 NYC Petition Status</DIV>


		  <P class="f60 p20">
		          To prepare the petition, we need to verify your Voter Registration.
		          Please enter the first and last name of the person you want to verify.
		  </P>
									
						<P CLASS="f60">
									<DIV class="f40">
									<div id="resp-table">
										<div id="resp-table-header">
											<div class="table-header-cell">Party</div>
											<div class="table-header-cell">District</div>
											<div class="table-header-cell">Candidates Running</div>
										</div>

									<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"></div>
												<div class="table-body-cell"></div>
												<div class="table-body-cell"><?= $TotalCandidate ?></div>
										
											</div>													
										</div>						
							
									
									<?php 
			if ( ! empty ($StatusList) ) {
				foreach ($StatusList as $var) {
					if ( ! empty ($var) ) {
			
										
		?>
	
										<div id="resp-table-body">
											<div class="resp-table-row">
												<div class="table-body-cell"><?= $var["CandidateElection_Party"] ?></div>
												<div class="table-body-cell"><?= $var["CandidateElection_DBTableValue"] ?></div>
												<div class="table-body-cell"><?= $var["TOTAL"] ?></div>
								
											</div>													
										</div>									
								<?php }
							}   
										
										} 
							?>

			</DIV>

	</P>			
	
</DIV>
</DIV>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
