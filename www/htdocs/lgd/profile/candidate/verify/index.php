<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "profile";  
	$BigMenu = "represent";	

  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_rmb_newyork.php";  

  if ( empty ($SystemUser_ID)) { goto_signoff(); }	
	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);

  if ( empty ($Position)) { 
		header("Location: /ldg/profile/candidate/?k=" . $k);
		exit();
	}
	
	$rmb = new RMB_newyork();
	$result = $rmb->SearchVoterDBbyNYSID($UniqNYSVoterID, $DatedFiles);
	
	
	// This the the logic for populating the candidate field
	if ( ! empty ($_POST)) {

		// Rules for different races.		
		$CandidateLogic = $_POST;
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/candidatelogic.php";
		
		$EncryptedURL = "SystemUser_ID=" . $SystemUser_ID .
										"&FirstName=" . $FirstName . 
										"&LastName=" . $LastName .
										"&VotersIndexes_ID=" . $VotersIndexes_ID . 
										"&UniqNYSVoterID=" . $UniqNYSVoterID . 
										"&MenuDescription=" . urlencode($MenuDescription) . 
										"&UserParty=" . $UserParty;
		
		header("Location: /lgd/profile/candidate/done/?k=<?= $k ?>");
		exit();
		
	}
	
  include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
	if ( $MobileDisplay == true) { $Cols = "col-12"; } else { $Cols = "col-9"; }
?>

  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>
  		<div class="<?= $Cols ?> float-left">
    
			  <!-- Public Profile -->
			  <div class="Subhead mt-0 mb-0">
			    <h2 id="public-profile-heading" class="Subhead-heading">Candidate Profile</h2>
			    <h2 id="public-profile-heading" class="Subhead-heading">This screen will need to be redone.</h2>
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
	
	

<style>
 /* Style the buttons that are used to open and close the accordion panel */
.accordeonbutton {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 3px;
  /* width: 100%; */
  text-align: left;
  border: none;
  outline: none;
  transition: 0.4s;
}

/* Add a background color to the button if it is clicked on 
(add the .active class with JS), and when you move the mouse over it (hover) */
.accordeonbutton:hover {
  background-color: #ccc;
}

/* Style the accordion panel. Note: hidden by default */
.panels {
  /* padding: 0 18px; */
  /* background-color: white; */
 	/* display: none; */
 	overflow: hidden;
} 
</style>

<div class="row">
  <div class="main">

	<FORM ACTION="" METHOD="POST">
		
<?php
	foreach ($Position as $var) {
		if ( ! empty ($var)) { 
?>
			<INPUT TYPE="hidden" NAME="Position[]" VALUE="<?= $var ?>">
<?php		}
	}
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

		</DiV>
								
		<DIV class="list-group-item ">
<?php
				if ( ! empty ($result)) {
					foreach ($result as $index => $var) { 
						
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


		
						<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
						<?= $result[$index]["Raw_Voter_ID"] ?> - <?= $result[$index]["Raw_Voter_UniqNYSVoterID"] ?><BR>
						<B>Last Name:</B> <?= $result[$index]["Raw_Voter_LastName"] ?> <B>First Name:</B> <?= $result[$index]["Raw_Voter_FirstName"] ?>	<B>Middle Name:</B> <?= $result[$index]["Raw_Voter_MiddleName"] ?> 
						<?php if ( !empty ($result[$index]["Raw_Voter_Suffix"])) { echo "<B>Suffix:</B>" . $result[$index]["Raw_Voter_Suffix"]; } ?><BR>
						<?= $result[$index]["Raw_Voter_ResHouseNumber"] ?>
						<?= $result[$index]["Raw_Voter_ResFracAddress"] ?>
						<?= $result[$index]["Raw_Voter_ResPreStreet"] ?>
						<?= $result[$index]["Raw_Voter_ResStreetName"] ?>
						<?= $result[$index]["Raw_Voter_ResPostStDir"] ?><BR>
						<?= $result[$index]["Raw_Voter_ResApartment"] ?><BR>
						<?= $result[$index]["Raw_Voter_ResCity"] ?>,
						<?= $result[$index]["Raw_Voter_ResZip"] ?> - <?= $result[$index]["Raw_Voter_ResZip4"] ?><BR>
						<?= $result[$index]["Raw_Voter_DOB"] ?> - <?= $result[$index]["Raw_Voter_Gender"] ?> - <?= $result[$index]["Raw_Voter_EnrollPolParty"] ?><BR>
						<B>County:</B> <?= $result[$index]["Raw_Voter_CountyCode"] ?> 
						<B>AD:</B> <?= $result[$index]["Raw_Voter_AssemblyDistr"] ?>
						<B>ED:</B> <?= $result[$index]["Raw_Voter_ElectDistr"] ?>
						<B>Legist:</B> <?= $result[$index]["Raw_Voter_LegisDistr"] ?>
						<B>Town:</B> <?= $result[$index]["Raw_Voter_TownCity"] ?>
						<B>Ward:</B> <?= $result[$index]["Raw_Voter_Ward"] ?>
						<B>Congress:</B> <?= $result[$index]["Raw_Voter_CongressDistr"] ?>
						<B>Senate:</B> <?= $result[$index]["Raw_Voter_SenateDistr"] ?><BR>
						<B>Status:</B> <?= $result[$index]["Raw_Voter_Status"] ?> - <B>Last Time Voted:</B> <?= $result[$index]["Raw_Voter_LastDateVoted"] ?>
						
					<?php } } ?>
													
		<DIV>
			<p><button type="submit" class="btn btn-primary">Run for the selected positions</button></p>
		</div>
										
							
		 
			</div>
		</div>
		 
</FORM>

	</DIV>
</DIV>	



<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>