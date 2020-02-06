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


  <div class="main">

		<FORM ACTION="" METHOD="POST">
		<div class="Box">
	  	<div class="Box-header pl-0">
	    	<div class="table-list-filters d-flex">
	  			<div class="table-list-header-toggle states flex-justify-start pl-3">Open positions to run for in the <?= $Party ?> Party</div>
	  		</div>
	    </div>
    
	    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
	      We don't know your district <a href="/voter">create one</a>?
	    </div>
	    	
<?php 			
			$Counter = 0;
			if ( ! empty ($Position)) {
				foreach ($Position as $PartyPosition => $Positions) {
					if ( ! empty ($PartyPosition)) { ?>
						
						<div class="list-group-item filtered f60">
							<span><B>&nbsp;&nbsp;<?= $PartyPosition ?></B></span>  
							<BR>
							<DIV CLASS="f40">
								<FONT COLOR="BROWN">At this time only County Committee works. The other positions are not ready. 
								<I>(The select position button is at the bottom of this page.)</I>
								</FONT>
							</DIV>		          			
						</div>
							
					 <DIV class="panels">
<?php				
						foreach ($Positions as $Pos => $Explain) {
					 		if (! empty ($Pos)) { ?>
								<div class="list-group-item">
									<BR>
									<DIV CLASS="f60">
										<INPUT TYPE="checkbox" NAME="PositionRunning[]" VALUE="<?= $Pos ?>">&nbsp;&nbsp;
										<B><?= $Pos ?></B>
									</DIV><BR>
									<DIV CLASS="f40"><?= $Explain ?></DIV><BR>
								</div>			
<?php					}	  }
						} ?>
						</DIV>
<?php		
				}
			} ?>
	 
		
	 
		</div>
		<BR>
		<p><button type="submit" class="btn btn-primary">Run for the selected positions</button></p>
</div>
</FORM>
</div>
</DIV>
</DIV>
</DIV>

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

<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>