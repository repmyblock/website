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
		header("Location: " . $k . "/profilecandidate");
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
		
		header("Location: " . rawurlencode(UrlEncrypt($EncryptedURL)) . "/verifydone");
		exit();
		
	}
	
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
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
						<a href="/lgd/<?= $k ?>/profile" class="mobilemenu UnderlineNav-item">Public Profile</a>
						<a href="/lgd/<?= $k ?>/profilevoter" class="mobilemenu UnderlineNav-item">Voter Profile</a>
						<a href="/lgd/<?= $k ?>/profilecandidate" class="mobilemenu UnderlineNav-item selected">Candidate Profile</a>
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

		<div id="voters" >

				
						<div class="list-group-item filtered">
							<button class="accordeonbutton" id="<?= $Counter++ ?>">Open</button>	
							<span><B><?= $PartyPosition ?></B></span>  
							
						
								          			
						</div>
							
					 <DIV class="panels">
					 	
					 	
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



<?php				print " INDEX: $index<BR>";
						if ( ! empty ($var)) {
							foreach ($var as $index2 => $vor) {
								if ( ! empty ($vor)) {
									print "Result: $index2 $vor<BR>";
								}
							}
						}
					}
				}
?>
						
													
								</div>			
						</DIV>
	 
		
	 
		</div>
		
	
		
	</div>
		<BR>
		<p><button type="submit" class="btn btn-primary">Run for the selected positions</button></p>
</div>
</FORM>

</DIV>

		
			</div>		
		</div>
	</div>


<script>
	// Default SortableJS
	//import Sortable from 'sortablejs';

	// Core SortableJS (without default plugins)
	// import Sortable from 'sortablejs/modular/sortable.core.esm.js';

	// Complete SortableJS (with all plugins)
	// import Sortable from 'sortablejs/modular/sortable.complete.esm.js';
	
	var acc = document.getElementsByClassName("accordeonbutton");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
		  /* Toggle between adding and removing the "active" class,
		  to highlight the button that controls the panel */
		  // this.classList.toggle("active");
		
		  /* Toggle between hiding and showing the active panel */
		  var panel = document.getElementsByClassName("panels");
		  if (panel[this.id].style.display === "block") {
		    panel[this.id].style.display = "none";
		  } else {
		    panel[this.id].style.display = "block";
		  }
		});
	}
</SCRIPT>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
