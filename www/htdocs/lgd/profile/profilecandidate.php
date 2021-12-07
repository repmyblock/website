<?php
	$Menu = "profile";  
	$BigMenu = "represent";	

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }

	if ( ! empty ($_POST)) {
		
		$Encrypted_URL = $Decrypted_k;
		foreach ($_POST["PositionRunning"] as $var) {
			$Encrypted_URL .= "&Position[]=" . $var;
		}
		
		WriteStderr($_POST, "Post in ProfileCandidate.php");	
		
		header("Location: /" . rawurlencode(EncryptURL($Encrypted_URL)) . "/lgd/profile/runposition");
		exit();		
	}

	$rmb = new repmyblock();

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = PrintParty($URIEncryptedString["UserParty"]);

	$rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);
	$result = $rmb->ListElectedPositions($rmbperson["DataState_Abbrev"]);
	
	if (! empty($result)) {
		foreach($result as $var) {
			if (! empty ($var)) {	
				$Position[$var["CandidatePositions_Type"]][$var["CandidatePositions_Name"]] = $var["CandidatePositions_Explanation"];
			}
		}
	}
	
	$TopMenus = array ( 
						array("k" => $k, "url" => "profile/profile", "text" => "Public Profile"),
						array("k" => $k, "url" => "profile/profilevoter", "text" => "Voter Profile"),
						array("k" => $k, "url" => "profile/profilecandidate", "text" => "Candidate Profile")
					);			
	WriteStderr($TopMenus, "Top Menu");		

			
			
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

		<P>
			<B><FONT COLOR=BROWN>If you are a candidate for higher office, please send an email to 
			</FONT> <A HREF="mailto:candidate@repmyblock.org">candidate@repmyblock.org</A> <FONT COLOR=BROWN>to access the obnibus petitions.</FONT></B>
		</P>


		<FORM ACTION="" METHOD="POST">
		<div class="Box">
	  	<div class="Box-header pl-0">
	    	<div class="table-list-filters d-flex">
	  			<div class="table-list-header-toggle states flex-justify-start pl-3">Open positions to run for in the <?= $Party ?> Party<BR>
	
	  				
	  				</div>
	  		</div>
	    </div>
    
	    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
	      We don't know your district <a href="/voter">create one</a>?
	    </div>
	    	
<?php 			
			$Counter = 0;
			if ( ! empty ($Position)) {
				foreach ($Position as $PartyPosition => $Positions) {
					//if ( ! empty ($PartyPosition)) {
						if ( $PartyPosition == "party") {
?>
					
						<div class="list-group-item filtered f60">
								
							<span><B><?= ucfirst($PartyPosition) ?></B></span>  
							     			
						</div>					
							
					
<?php				
						foreach ($Positions as $Pos => $Explain) {
					 		// if (! empty ($Pos)) { 
					 		if ($Pos == "County Committee") { ?>
								<div class="list-group-item f60">
										<INPUT TYPE="checkbox" NAME="PositionRunning[]" VALUE="<?= $Pos ?>">&nbsp;&nbsp;<B><?= $Pos ?></B>
									<DIV CLASS="f40"><?= $Explain ?></DIV>
								</div>			
<?php					}	  
}
						} ?>
					
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
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
