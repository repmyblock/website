<?php 
	$BigMenu = "home";
	$Menu = "district";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  

  if (empty ($SystemUser_ID)) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($MenuDescription)) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);

	$LongLat = "[-74.0060, 40.7128]";
	$Zoom = 15;
	
	$CommitteeMembers = "Vacant";
	$DistrictLeaders = "Theo Chino (M) Maria Something (F)";
	$AssemblyPart = "B";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>


<div class="col-9 float-left">

	<div class="Subhead">
  	<h2 class="Subhead-heading">District</h2>
	</div>
	
	<?php 
		if ($VerifEmail == true) { 
			include $_SERVER["DOCUMENT_ROOT"] . "/warnings/emailverif.php";
		} else if ($VerifVoter == true) {
			include $_SERVER["DOCUMENT_ROOT"] . "/warnings/voterinfo.php";
		} 
	?>	       	
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

	    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.1.1/css/ol.css" type="text/css">
    <style>
      .map {
        height: 400px;
        width: 100%;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.1.1/build/ol.js"></script>
  
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






<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php";	?>