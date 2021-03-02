<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "team";
	$BigMenu = "represent";	
	 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php"; 

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	$Party = NewYork_PrintParty($UserParty);

	//$TopMenus = array ( 
	//					array("k" => $k, "url" => "team", "text" => "Pledges"),
	//					array("k" => $k, "url" => "teampetitions", "text" => "Manage Petitions"),
	//					array("k" => $k, "url" => "teamcandidate", "text" => "Other Candidates")
	//				);			
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
	
	<?php
		PrintVerifMenu($VerifEmail, $VerifVoter);		
		PlurialMenu($k, $TopMenus);
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
  		<A HREF="/admin/<?= $k ?>/index" class="mobilemenu">Admin Screen</A><BR>	
  		<A HREF="/admin/<?= $k ?>/track">Track Petitions</A><BR>	
  <?php	} ?>
   		
   		
		
<div class="Box">
					<div class="Box-header pl-0">
						<div class="table-list-filters d-flex">
							<div class="table-list-header-toggle states flex-justify-start pl-3">Organize your teams</div>
						</div>
			    </div>
			    
			    
			<?php if ( $VerifVoter == false) { 
				if ( empty ($Petitions)) { ?>    
			    <div class="Box-body text-center py-6 js-collaborated-repos-empty">
			      The petition link to your campaign will be available on this page on 
			    		<BR><FONT COLOR=BROWN><B>March 3rd, 2021</B></FONT>
			    </div>
			<?php } 
				} else { ?>
			    <div class="Box-body text-center py-6 js-collaborated-repos-empty">
			      Before you can setup your petitions 
			    	<a href=/lgd/<?= $k ?>/profilevoter">you need to verify your voter information.</a>
			    </div>
			<?php } ?>
			
				<div class="js-collaborated-repos">
			        
			<?php if ( ! empty ($Petitions)) {
				 	foreach ($Petitions as $Pet) {
				 		if (! empty ($Pet)) { ?>
							<div class="Box-row simple public js-collab-repo" data-repo-id="43183710" data-owner-id="5959961">
								<svg class="octicon octicon-repo mr-1" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
								<a class="mr-1" href="/lgd/petitions/organize/">Petition #<?= $Pet["Petition_ID"] ?></a>
								<span class="text-small">
								<span class="ml-2">
									<svg class="octicon octicon-organization" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M16 12.999c0 .439-.45 1-1 1H7.995c-.539 0-.994-.447-.995-.999H1c-.54 0-1-.561-1-1 0-2.634 3-4 3-4s.229-.409 0-1c-.841-.621-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.442.58 2.5 3c.058 2.41-.159 2.379-1 3-.229.59 0 1 0 1s1.549.711 2.42 2.088C9.196 9.369 10 8.999 10 8.999s.229-.409 0-1c-.841-.62-1.058-.59-1-3 .058-2.419 1.367-3 2.5-3s2.437.581 2.495 3c.059 2.41-.158 2.38-1 3-.229.59 0 1 0 1s3.005 1.366 3.005 4z"></path></svg>
									<a href="/lgd/petitions/organize/"><?= $Pet["Signed"] ?> out of <?= $Pet["Total"] ?> signed</a>
								</span>
								</span>
							</div>
			<?php 	}
						}
					}
			?>
			
				</div>
			</div>

<?php /*			
		
		

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
		<b><A HREF="<?= $k ?>/managesignedvoters">Manage your signed voters</A></FONT></B>
		</P>
		
		
		<P>
		<b><A HREF="">Candidates running in your district.</A></FONT></B>
		</P>
		
		<UL>
			* None.
		</UL>
		
		*/ ?>

    </dd>
  </dl>
    
			
	

</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>