<?php 
	$BigMenu = "home";
	$Menu = "district";
	$MapShow = true;
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_district.php";  

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$rmb = new RMBdistrict();
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
					<h2 class="Subhead-heading">District</h2>
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
				        		
				        		<DIV>
											<A HREF="/<?=  CreateEncoded ( array( 
													"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
													"Raw_Voter_ID" => $URIEncryptedString["Raw_Voter_ID"],
													"FirstName" => $URIEncryptedString["SystemUser_FirstName"],
													"LastName" => $URIEncryptedString["SystemUser_LastName"],
													"VotersIndexes_ID" => $URIEncryptedString["VotersIndexes_ID"],
													"UniqNYSVoterID" => $URIEncryptedString["Raw_Voter_UniqNYSVoterID"],
													"UserParty" => $URIEncryptedString["Raw_Voter_RegParty"],
													"SystemAdmin" => $URIEncryptedString["SystemUser_Priv"]
													)) ?>/lgd/district/results">Results per districts</A>
									  </DIV>
				
				          </dl>
				          
				         
							</DIV>
					</DIV>
				</DIV>
				<?php } ?>


				
	<div id="map" class="map"></div>
    <script type="text/javascript">
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat(<?= $LongLat ?>),
          zoom: <?= $Zoom ?>
        })
      });
    </script>
				   
				    
				   
				</DIV>
			</DIV>
				
		</DIV>
	
		
	</DIV>
</DIV>







<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>