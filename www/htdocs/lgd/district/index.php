<?php 
	$BigMenu = "home";
	$Menu = "district";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

<div class="row">
  <div class="main">



<?php /*
	  <link rel="dns-prefetch" href="https://github.githubassets.com">
	  <link rel="dns-prefetch" href="https://avatars0.githubusercontent.com">
	  <link rel="dns-prefetch" href="https://avatars1.githubusercontent.com">
	  <link rel="dns-prefetch" href="https://avatars2.githubusercontent.com">
	  <link rel="dns-prefetch" href="https://avatars3.githubusercontent.com">
	  <link rel="dns-prefetch" href="https://github-cloud.s3.amazonaws.com">
	  <link rel="dns-prefetch" href="https://user-images.githubusercontent.com/">
*/ ?>

	  <link rel="stylesheet" href="/css/frameworks.css" />
	  <meta name="viewport" content="width=device-width">
  
  <div class="position-relative js-header-wrapper ">
    <a href="#start-of-content" tabindex="1" class="p-3 bg-blue text-white show-on-focus js-skip-to-content">Skip to content</a>
    <span class="Progress progress-pjax-loader position-fixed width-full js-pjax-loader-bar">
      <span class="progress-pjax-loader-bar top-0 left-0" style="width: 0%;"></span>
    </span>
    


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>


<div class="col-9 float-left">

	<div class="Subhead">
  	<h2 class="Subhead-heading">District</h2>
	</div>
	
	
	<?php 
	// include $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Data/CityADEDPoly.txt"; 
	?>     	       

	
  <div class="clearfix gutter d-flex flex-shrink-0">

    <div class="col-16">
      <form class="edit_user" id="edit_user_5959961" aria-labelledby="public-profile-heading" action="/users/theochino" accept-charset="UTF-8" method="post">
      	<input name="utf8" type="hidden" value="">
      	<input type="hidden" name="_method" value="put">
      	<input type="hidden" name="authenticity_token" value="4k+6+d4X0PQVH2fLO2l08ydEGxZbKO956HTPNLXBRgHz0ri7V+/g0GkfdflYGR8l+aYcp4loYW46fz1Gr2X/WA==">

        <div>
            <dl class="form-group col-12 d-inline-block"> 

              <dt><label for="user_profile_name">Current County Committee Members:</label><DT>
          		<DD>
          			County Committee Member 1, Member 2, Member 3, and Member 4<BR>
          			Assembly District Part B: Theo Chino (M) Maria Something (F)
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
          center: ol.proj.fromLonLat([-74.0060, 40.7128]),
          zoom: 10
        })
      });
    </script>

    <button id="zoom-out">Zoom out</button>
    <button id="zoom-in">Zoom in</button>
    
 
</DIV>
</DIV>
</DIV>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>