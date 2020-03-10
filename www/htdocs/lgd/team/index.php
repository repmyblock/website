<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	$BigMenu = "represent";	
	 
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);

				
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">



<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>


<div class="col-9 float-left">

	<div class="Subhead">
  	<h2 class="Subhead-heading">Team</h2>
	</div>
	
	<?php 
		if ($VerifEmail == true) { 
			include $_SERVER["DOCUMENT_ROOT"] . "/warnings/emailverif.php";
		} else if ($VerifVoter == true) {
			include $_SERVER["DOCUMENT_ROOT"] . "/warnings/voterinfo.php";
		} 
	?>          
 
  <dl class="form-group">
  	<dt><label for="user_profile_email">Team building</label></dt>
    <dd class="d-inline-block">       	
    	<?php /*
   		<A HREF="">Send me a petition by email that I can foward</A><BR>
   		<A HREF="/lgd/voters/?k=<?= $k ?> mobilemenu">Send a petition to a verified voter</A><BR>
   	  */ ?>
	<?php	if ( $SystemAdmin == $FullAdminRights && ! empty ($FullAdminRights)) { ?>
	<BR>
  		<A HREF="/lgd/team/admin/?k=<?= $k ?>" class="mobilemenu">Admin Screen</A><BR>	
  		<?php /* <A HREF="/lgd/team/admin/track/?k=<?= $k ?>">Track Petitions</A><BR>	 */ ?>
  <?php	} ?>
   		
   		
    </dd>
  </dl>
    
			
		

     
  
		

			
		
		
<?php /*
		<h2>List of voters in your area.</H2>	
		
	
		<P>
			<FONT SIZE=+2><A HREF="/get-involved/target/?k=<?= $k ?>">Create a petition set with the voters you want to target</A></FONT><BR>		
		</P>
		
		<h2>This is a list of petition set created</h2>
		
		<P>
		
		<?php 
			if ( ! empty ($result) ) {
				foreach ($result as $var) {
					if ( ! empty ($var)) {
						$NewKEncrypt = EncryptURL($NewK . "&CandidatePetitionSet_ID=" . $var["CandidatePetitionSet_ID"] . 
																											   "&Candidate_ID=" . $var["Candidate_ID"] );
		?>				
						<A HREF="/get-involved/list/printpetitionset/?k=<?= $NewKEncrypt ?>">Petition set created 
							on <?= PrintShortDate($var["CandidatePetitionSet_TimeStamp"]) ?> at 
							<?= PrintShortTime($var["CandidatePetitionSet_TimeStamp"]) ?></A>
						<A TARGET="PETITIONSET<?= $PetitionSetID ?>" HREF="<?= $FrontEndPDF ?>/petitions/?k=<?= $NewKEncrypt ?>"><i class="fa fa-download"></i></A> 
						<A HREF="/get-involved/list/emailpetition/?k=<?= $NewKEncrypt  ?>"><i class="fa fa-share"></i></A>																													
						<BR>
		<?php
					}
				}
			}
		?>

		</P>				
		
		<P>
			<FONT SIZE=+2><A HREF="managesignedvoters.php?k=<?= $k ?>">Manage your signed voters</A></FONT>
		</P>
		
		
		<P>
			<FONT SIZE=+2><A HREF="">Candidates running in your district.</A></FONT>
		</P>
		
		<UL>
			* None.
		</UL>

		*/ ?>


</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>