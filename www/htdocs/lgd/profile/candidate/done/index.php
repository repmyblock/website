<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "profile";  
	$BigMenu = "represent";	

  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($SystemUser_ID)) { goto_signoff(); }

	if ( ! empty ($_POST)) {
		
		$Encrypted_URL = $Decrypted_k;
		foreach ($_POST["PositionRunning"] as $var) {
			$Encrypted_URL .= "&Position[]=" . $var;
		}
		
		header("Location: verify/?k=" . EncryptURL($Encrypted_URL));
		exit();		
	}

	$rmb = new repmyblock();

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);

	$result = $rmb->ListElectedPositions('NY');
	
	if (! empty($result)) {
		foreach($result as $var) {
			if (! empty ($var)) {	
				$Position[$var["CandidatePositions_Type"]][$var["CandidatePositions_Name"]] = $var["CandidatePositions_Explanation"];
			}
		}
	}
				
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>


<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Candidate Profile</h2>
			  </div>
     
<?php 
				if ($VerifEmail == true) { 
					include $_SERVER["DOCUMENT_ROOT"] . "/warnings/emailverif.php";
				} else if ($VerifVoter == true) {
					include $_SERVER["DOCUMENT_ROOT"] . "/warnings/voterinfo.php";
				} 
?>		
  
				<nav class="UnderlineNav pt-1 mb-4" aria-label="Billing navigation">
					<div class="UnderlineNav-body">
						<a href="/lgd/profile/?k=<?= $k ?>" class="mobilemenu UnderlineNav-item">Public Profile</a>
						<a href="/lgd/profile/voter/?k=<?= $k ?>" class="mobilemenu UnderlineNav-item">Voter Profile</a>
						<a href="/lgd/profile/candidate/?k=<?= $k ?>" class="mobilemenu UnderlineNav-item selected">Candidate Profile</a>
					</div>
				</nav>

			  <div class="clearfix gutter d-flex flex-shrink-0">
	
	




  

	<div class="Box">
  	<div class="Box-header pl-0">
    	<div class="table-list-filters d-flex">
  			<div class="table-list-header-toggle states flex-justify-start pl-3">Open positions to run for in the <?= $Party ?> Party</div>
  		</div>
    </div>
    
    <div class="Box-body text-center py-6 js-collaborated-repos-empty" >
      We are done with the petition. Go to the dowload screen to download 
      your petition.
    </div>

	</DIV>
</DIV>
				</DIV>

		
			</div>		
		</div>
	</div>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>