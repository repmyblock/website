<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	$State = "NY";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

	if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$rmb = new repmyblock();	
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($URIEncryptedString["UserParty"]);

	$result = $rmb->ListElectionsDates();
	WriteStderr($result, "ListElectedPositions");
	
	$TopMenus = array ( 						
		array("k" => $k, "url" => "../admin/setup_elections", "text" => "Race Type"),
		array("k" => $k, "url" => "../admin/setup_dates", "text" => "Elections Dates"),
		array("k" => $k, "url" => "../admin/setup_candidate", "text" => "Candidate Profile")
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
     
			<?php	PlurialMenu($k, $TopMenus); ?>    

			  <div class="clearfix gutter d-flex flex-shrink-0">

				<div class="row">
				  <div class="main">
						<FORM ACTION="" METHOD="POST">
						<div class="Box">
					  	<div class="Box-header pl-0">
					    	<div class="table-list-filters d-flex">
					  			<div class="table-list-header-toggle states flex-justify-start pl-3">List of positions available to run for</div>
					  		</div>
					    </div>
				    
					    <div class="Box-body text-center py-6 js-collaborated-repos-empty" hidden="">
					      We don't know your district <a href="/voter">create one</a>?
					    </div>
	    
	   			
	    
<?php 			
			$Counter = 0;
			if ( ! empty ($result)) {
				foreach ($result as $var) {
?>		
	<div class="flex-items-left">
	 	<span class="ml-4 flex-items-baseline"><A HREF="/<?= CreateEncoded (
				array("SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],	
								"Raw_Voter_ID" => $URIEncryptedString["SystemUser_Priv"],
								"Election_Date" => $var["Elections_ID"])); ?>/admin/edit_dates">Select</A></span>
	  <span class="ml-4"><?= PrintDate($var["Elections_Date"]) ?></span>
	  <span class="ml-4 ext-gray"><?= $var["Elections_Type"] ?></span>
	 	<span class="ml-4 user-mention"><?= $var["Elections_Text"] ?></span>
	</div>
 
						
<?php
				}
			} 
?>

	


							</div>
							<BR>
							<p><button type="submit" class="submitred">Add a new electiondate</button></p>
					</div>
					</FORM>
			</div>
		</DIV>
	</DIV>
	</DIV>
</DIV>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>