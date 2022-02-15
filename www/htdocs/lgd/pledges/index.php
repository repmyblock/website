<?php 
	$BigMenu = "home";
	$Menu = "pledge";
	// $MapShow = true;
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	$Party = PrintParty($UserParty);
	
	$LongLat = "[-73.8710, 40.6928]"; $Zoom = 11;

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>




<div class="row">
	<div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">

				<div class="Subhead">
					<h2 class="Subhead-heading">Signatures Pledges</h2>
				</div>
			
				<?php 
					if ($VerifEmail == true) { 
						include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_emailverif.php";
					} else if ($VerifVoter == true) {
						include $_SERVER["DOCUMENT_ROOT"] . "/common/warning_voterinfo.php";
						$LongLat = "[-73.8710, 40.6928]"; $Zoom = 11;
					} 
				?>	 

				<?php if ($VerifVoter == false) { ?>
				<div class="clearfix gutter d-flex flex-shrink-0">
				  <div class="col-16">
				      <div>
				          <dl class="form-group col-12 d-inline-block"> 
				            <dt><label for="user_profile_name">Current County Committee Members:</label><DT>
				        		<DD>
				        			County Committee Members: <?= $CommitteeMembers ?><BR>
				        			Assembly District Part <?= $AssemblyPart ?>: <?= $DistrictLeaders ?>
				        		</DD>
				          </dl>
							</DIV>
					</DIV>
				</DIV>
				<?php } ?>


				
	<div id="map" class="map"></div>
    
				   
				    
				   
				</DIV>
			</DIV>
				
		</DIV>
	
		
	</DIV>
</DIV>







<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>