<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	// $BigMenu = "represent";	
	 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  WipeURLEncrypted();
	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($UserParty);

	$TopMenus = array ( 						
		array("k" => $k, "url" => "team/index", "text" => "Manage Pledges"),
		array("k" => $k, "url" => "team/teampetitions", "text" => "Manage Petitions"),
		array("k" => $k, "url" => "team/teamcandidate", "text" => "Manage Candidates")
	);
								
	WriteStderr($TopMenus, "Top Menu");		
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<div class="row">
  <div class="main">



<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>


<div class="col-9 float-left">

	<div class="Subhead">
  	<h2 class="Subhead-heading">Team</h2>
	</div>
	
	<?php	PlurialMenu($k, $TopMenus); ?>          
 
  <dl class="form-group">
  	<dt><label for="user_profile_email">Team building</label></dt>
    <dd class="d-inline-block">       	
    
   		<A HREF="">Send me a petition by email that I can foward</A><BR>
   		<A HREF="/lgd/voters/?k=<?= $k ?> mobilemenu">Send a petition to a verified voter</A><BR>
   	
   	<?php	if ( $SystemAdmin == $FullAdminRights && ! empty ($FullAdminRights)) { ?>
	<BR>
  		<A HREF="/admin/<?= $k ?>/index" class="mobilemenu">Admin Screen</A><BR>	
  		<A HREF="/admin/<?= $k ?>/track">Track Petitions</A><BR>	
  <?php	} ?>
   		


		<B>List of voters in your area.</B>	
		
	
		<P>
			<A HREF="<?= $k ?>/target">Create a petition set with the voters you want to target</A><BR>		
		</P>
		
		<b>This is a list of petition set created</b>
		
		<P>
		
		<?php 
			if ( ! empty ($result) ) {
				foreach ($result as $var) {
					if ( ! empty ($var)) {
						$NewKEncrypt = EncryptURL($NewK . "&CandidatePetitionSet_ID=" . $var["CandidatePetitionSet_ID"] . 
																											   "&Candidate_ID=" . $var["Candidate_ID"] );
		?>				
						<A HREF="<?= $NewKEncrypt ?>/printpetitionset">Petition set created 
							on <?= PrintShortDate($var["CandidatePetitionSet_TimeStamp"]) ?> at 
							<?= PrintShortTime($var["CandidatePetitionSet_TimeStamp"]) ?></A>
						<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/petitions/?k=<?= $NewKEncrypt ?>"><i class="fa fa-download"></i></A> 
						<A HREF="<?= $NewKEncrypt  ?>/emailpetition"><i class="fa fa-share"></i></A>																													
						<BR>
		<?php
					}
				}
			}
		?>

		</P>				
		
		<P>
		<b><A HREF="<?= $k ?>/team/managesignedvoters">Manage your signed voters</A></FONT></B>
		</P>
		

    </dd>
  </dl>
    
			
	

</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
