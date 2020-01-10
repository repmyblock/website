<?php
	if ( ! empty ($k)) { $MenuLogin = "logged"; }  
	$Menu = "profile";  
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";  
  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	$r = new login();
	$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . "&RawVoterID=" . $RawVoterID . 
										"&DatedFiles=" . $DatedFiles . 
										"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
										"&FirstName=" . $FirstName . "&LastName=" . $LastName;
	/*
	if ( ! empty ($_POST["SaveInfo"])) {
		// First thing we need to check is the vadility of the email address.	
		// Then we need to check the database for the existance of that email.	
		$result = $r->CheckEmail($_POST["emailaddress"]);
		
		if ( empty ($result)) {
			// We did not find anything so we are creating it.
			$result = $r->AddEmail($_POST["emailaddress"], $_POST["login"], $FirstName, $LastName);
		} else if (! empty ($result["SystemUser_password"])) {			
				// That mean we did the stuff before so we need to jump to another screen
			
		}
		
		$URLToEncrypt = "SystemUser_ID=" . $result["SystemUser_ID"] . "&RawVoterID=" . $RawVoterID . 
										"&DatedFiles=" . $DatedFiles . 
										"&ElectionDistrict=" . $ElectionDistrict . "&AssemblyDistrict=" . $AssemblyDistrict . 
										"&FirstName=" . $FirstName . "&LastName=" . $LastName;

		// The reason for no else is that the code supposed to go away.
		
		if ( $_POST["login"] == "password") {
			header("Location: requestpassword.php?k=" . EncryptURL($URLToEncrypt));
			exit();
		}
		
		if ( $_POST["login"] == "email") {
			header("Location: requestemaillink.php?k=" . EncryptURL($URLToEncrypt));
			exit();
		}
	
		// If we are here which we should never be we need to send user to problem loop
		exit();
	}

	$result = $r->FindSystemUser_ID($SystemUser_ID);		
	//echo "<PRE>" .print_r($result, 1) . "</PRE>";
	
	if ( empty ( $result[0]["Candidate_ID"])) {
		header("Location: /get-involved/list/explain/?k=" . EncryptURL("SystemUser_ID=" . $SystemUser_ID . 
																																		"&ElectionDistrict=" . $ElectionDistrict . 
																																		"&AssemblyDistrict=" . $AssemblyDistrict .
																																		"&FirstName=" . $FirstName . "&LastName=" . $LastName));
		exit();
	}
	
	if ( ! empty ($Candidate_ID)) {
		$result = $r->ReturnPetitionSet($Candidate_ID);
	}

	
	$NewK = "SystemUser_ID=" . $SystemUser_ID;
	
	// . "&RawVoterID=" . $RawVoterID . 
//					"&DatedFiles=" . $DatedFiles . "&ElectionDistrict=" . $ElectionDistrict . 
//					"&AssemblyDistrict=" . $AssemblyDistrict . "&FirstName=" . $FirstName . 
//					"&LastName=" . $LastName;	
		
				
	//echo "<PRE>" . print_r($result, 1) . "</PRE>";
	require $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_maps.php";
	$UniqNYSID = $result[0]["Raw_Voter_UniqNYSVoterID"];
	if (! empty ($UniqNYSID)) {
		require $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_outrageddems.php";  
		$q = new OutragedDems();
		$ResultVoter = $q->SearchVoterDBbyNYSID($UniqNYSID, $DatedFiles);
		$ResultVoter = $ResultVoter[0];
		
		// I also need to find the Regular Raw Voter 
		$ResultVoterMyTable = $q->SearchLocalRawDBbyNYSID($UniqNYSID, $DatedFilesID);
		$ResultVoterMyTable = $ResultVoterMyTable[0];
	}
	
	$ElectionDistrict = $ResultVoter["Raw_Voter_ElectDistr"];
	$AssemblyDistrict = $ResultVoter["Raw_Voter_AssemblyDistr"];
				
	$r = new maps();
	$result = $r->CountRawVoterbyADED($DatedFiles, $AssemblyDistrict, $ElectionDistrict);
	$RawVoterID = $ResultVoter["Raw_Voter_ID"];
	
	$GeoDescAbbrev = sprintf("%'.02d%'.03d", $AssemblyDistrict, $ElectionDistrict);
	$PicID = $r->FindGeoDiscID($GeoDescAbbrev);

	$NumberOfElectors = $result["TotalVoters"];
	$NumberOfSignatures = intval($NumberOfElectors * $SignaturesRequired) + 1;
	$NumberOfAddressesOnDistrict = 0;
	$PictureID = $PicID["GeoDesc_ID"];
	$PictureDir = intval( $PictureID /100);
	$PicURL = $FrontEndStatic . "/maps/" . $PictureDir . "/Img-" . $PictureID . ".jpg";	
	*/
				
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

	  <link crossorigin="anonymous" media="all" integrity="sha512-hddDYPWR0gBbqLRmIZP242WMEiYsVkYI2UCYCVUHB4h5DhD2cbtFJYG+HPh21dZGb+sbgDHxQBNJCBq7YbmlBQ==" rel="stylesheet" href="https://github.githubassets.com/assets/frameworks-02a3eaa24db2bd1ed9b64450595fc2cf.css" />
	  <link crossorigin="anonymous" media="all" integrity="sha512-YdIM/FwAk7kxvPGCpeT2JXxPrThv4m9rH7fLzjn+dg3zKb+PWOaxX1ioiOcmOb64+LeDKgBXsGL4b/BJQY/cdA==" rel="stylesheet" href="https://github.githubassets.com/assets/github-102d2679bcc893600ce928d5c6d34297.css" />
	  <meta name="viewport" content="width=device-width">
	  <link rel="assets" href="https://github.githubassets.com/">
	  <link rel="web-socket" href="wss://live.github.com/_sockets/VjI6NDc5NjU4Mzg1OjU0MDc5ODkyMGU3NzVlMWI5OWNjNWY0NjI3ZTNhM2Y1YzAzNGVjYTg0NGVhOTM5YzQxYWE4NjM2NWZjYWI4MDU=--9542ad17f8ded8008dcbf8c4a9ad7fc406528b9d">
	  <link rel="sudo-modal" href="/sessions/sudo_modal">
	  <meta name="request-id" content="DF8C:322F:68FF04:C5274B:5E061439" data-pjax-transient>
	  <meta name="selected-link" value="/settings/profile" data-pjax-transient>
		<meta name="google-site-verification" content="KT5gs8h0wvaagLKAVWq8bbeNwnZZK1r1XQysX3xurLU">
	  <meta name="google-site-verification" content="ZzhVyEFwb7w3e0-uOTltm8Jsck2F5StVihD0exw2fsA">
	  <meta name="google-site-verification" content="GXs5KoUUkNCoaAZn7wPN-t01Pywp9M3sEjnt_3_ZWPc">
		<meta name="octolytics-host" content="collector.githubapp.com" /><meta name="octolytics-app-id" content="github" /><meta name="octolytics-event-url" content="https://collector.githubapp.com/github-external/browser_event" /><meta name="octolytics-dimension-request_id" content="DF8C:322F:68FF04:C5274B:5E061439" /><meta name="octolytics-dimension-region_edge" content="iad" /><meta name="octolytics-dimension-region_render" content="iad" /><meta name="octolytics-dimension-ga_id" content="" class="js-octo-ga-id" /><meta name="octolytics-dimension-visitor_id" content="4235650736889529226" /><meta name="octolytics-actor-id" content="5959961" /><meta name="octolytics-actor-login" content="theochino" /><meta name="octolytics-actor-hash" content="06efaedfc34dd99321cd1c2dee6165400019dd420586789ed3c188c18d50c812" />
		<meta name="analytics-location-query-strip" content="true" data-pjax-transient="true" />
		<meta name="google-analytics" content="UA-3769691-2">
	  <meta class="js-ga-set" name="userId" content="187ac54403dcbfacd6f081af6d871f6a">
		<meta class="js-ga-set" name="dimension1" content="Logged In">
		<meta name="hostname" content="github.com">
	  <meta name="user-login" content="theochino">
		<meta name="expected-hostname" content="github.com">
		<meta name="js-proxy-site-detection-payload" content="NmZkZmY1NTE2OTI2ZGZhMjdkN2FmYmVjYTMzMTRmMjZkNjNjMzdmMjU4ZmUyYTM2M2Q3OWViZGVmNDgyZjM4MXx7InJlbW90ZV9hZGRyZXNzIjoiMTkwLjIzMi4xMTAuMjQxIiwicmVxdWVzdF9pZCI6IkRGOEM6MzIyRjo2OEZGMDQ6QzUyNzRCOjVFMDYxNDM5IiwidGltZXN0YW1wIjoxNTc3NDU2Njk3LCJob3N0IjoiZ2l0aHViLmNvbSJ9">
		<meta name="enabled-features" content="MARKETPLACE_FEATURED_BLOG_POSTS,MARKETPLACE_INVOICED_BILLING,MARKETPLACE_SOCIAL_PROOF_CUSTOMERS,MARKETPLACE_TRENDING_SOCIAL_PROOF,MARKETPLACE_RECOMMENDATIONS,MARKETPLACE_PENDING_INSTALLATIONS,NOTIFY_ON_BLOCK,RELATED_ISSUES,GHE_CLOUD_TRIAL">
		<meta name="html-safe-nonce" content="78dcccd21595aa46301a62263484803643271f38">
	  <meta http-equiv="x-pjax-version" content="61f8c219e8739359a3bf9c46bc342ad6">
	  <meta name="browser-stats-url" content="https://api.github.com/_private/browser/stats">
	  <meta name="browser-errors-url" content="https://api.github.com/_private/browser/errors">
	  <link rel="mask-icon" href="https://github.githubassets.com/pinned-octocat.svg" color="#000000">
	  <link rel="icon" type="image/x-icon" class="js-site-favicon" href="https://github.githubassets.com/favicon.ico">
	  <meta name="theme-color" content="#1e2327">	
	  <meta name="webauthn-auth-enabled" content="true">
	  <meta name="webauthn-registration-enabled" content="true">
	  <link rel="manifest" href="/manifest.json" crossOrigin="use-credentials">
  </head>

  <body class="logged-in env-production emoji-size-boost min-width-lg page-account">
  
  <div class="position-relative js-header-wrapper ">
    <a href="#start-of-content" tabindex="1" class="p-3 bg-blue text-white show-on-focus js-skip-to-content">Skip to content</a>
    <span class="Progress progress-pjax-loader position-fixed width-full js-pjax-loader-bar">
      <span class="progress-pjax-loader-bar top-0 left-0" style="width: 0%;"></span>
    </span>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/menu.php"; ?>



   <div class="col-9 float-left">
    
  <!-- Public Profile -->
  <div class="Subhead mt-0 mb-0">
    <h2 id="public-profile-heading" class="Subhead-heading">Personal Profile</h2>
  </div>
     
  <div class="flash flash-warn mb-4">
    <svg class="octicon octicon-alert" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true">
    	<path fill-rule="evenodd" d="M8.893 1.5c-.183-.31-.52-.5-.887-.5s-.703.19-.886.5L.138 13.499a.98.98 0 000 1.001c.193.31.53.501.886.501h13.964c.367 0 .704-.19.877-.5a1.03 1.03 0 00.01-1.002L8.893 1.5zm.133 11.497H6.987v-2.003h2.039v2.003zm0-3.004H6.987V5.987h2.039v4.006z"></path>
    </svg>
    <strong class="ml-1">Voter information not verified</strong>
    <p class="text-small pt-1">
      Please verify your voter information below.
    </p>
  </div>
  
  
<nav class="UnderlineNav pt-1 mb-4" aria-label="Billing navigation">
  <div class="UnderlineNav-body">
      <a href="/lgd/profile" class="UnderlineNav-item selected">Public Profile</a>
      <a href="/lgd/profile/voter" class="UnderlineNav-item">Voter Profile</a>
  </div>
</nav>


  


  

  <div class="clearfix gutter d-flex flex-shrink-0">

    <div class="col-8">
      <form class="edit_user" id="edit_user_5959961" aria-labelledby="public-profile-heading" action="/users/theochino" accept-charset="UTF-8" method="post">
      	<input name="utf8" type="hidden" value="">
      	<input type="hidden" name="_method" value="put">
      	<input type="hidden" name="authenticity_token" value="4k+6+d4X0PQVH2fLO2l08ydEGxZbKO956HTPNLXBRgHz0ri7V+/g0GkfdflYGR8l+aYcp4loYW46fz1Gr2X/WA==">

        <div>
            <dl class="form-group col-4 d-inline-block"> 

              <dt><label for="user_profile_name">First Name</label><DT>
              <dd>
                <input class="form-control" type="text" Placeholder="First" name="user[profile_name]" id="user_profile_name">
              </dd>
            </dl>

            <dl class="form-group col-4 d-inline-block"> 

              <dt><label for="user_profile_name">Last Name</label><DT>
              <dd>
                <input class="form-control" type="text" Placeholder="Last" name="user[profile_name]" id="user_profile_name">
              </dd>
            </dl>
 
          
          
          <dl class="form-group">
            <dt><label for="user_profile_bio">Bio</label></dt>
            <dd class="user-profile-bio-field-container js-length-limited-input-container">
              <text-expander keys=": @" data-emoji-url="/autocomplete/emoji" data-mention-url="/autocomplete/user-suggestions">
                <textarea class="form-control user-profile-bio-field js-length-limited-input" placeholder="Tell us a little bit about yourself" data-input-max-length="160" data-warning-text="{{remaining}} remaining" name="user[profile_bio]" id="user_profile_bio">See my twitter account profile.</textarea>
              </text-expander>
              <p class="note">
                You can <strong>@mention</strong> other users and
                organizations to link to them.
              </p>
              <p class="js-length-limited-input-warning user-profile-bio-message d-none"></p>
            </dd>
          </dl>

          <dl class="form-group">
            <dt><label for="user_profile_blog">URL</label></dt>
            <dd><input class="form-control" type="text" value="https://twitter.com/theochino" name="user[profile_blog]" id="user_profile_blog"></dd>
          </dl>

     
          <hr>
          <dl class="form-group">
            <dt><label for="user_profile_location">Location</label></dt>
            <dd><input class="form-control" type="text" value="New York" name="user[profile_location]" id="user_profile_location"></dd>
          </dl>

          <input type="text" name="required_field_92ef" class="form-control" hidden="hidden">
					<input type="hidden" name="timestamp" value="1577468816960" class="form-control">
					<input type="hidden" name="timestamp_secret" value="14ffe70cbb5bd6d0cd0172a5511420ab7eba0428f91278d25cbc06a7e03323c4" class="form-control">


            <p class="note mb-2">
              All of the fields on this page are optional and can be deleted at any
              time, and by filling them out, you're giving us consent to share this
              data wherever your user profile appears. Please see our
              <a href="https://github.com/site/privacy">privacy statement</a>
              to learn more about how we use this information.
            </p>

          <p><button type="submit" class="btn btn-primary">Update profile</button></p>
        </div>
</form>    

</div>

    <div class="col-4 d-inline-block">
      <dl>
			  <dt><label class="d-block mb-2">Profile picture</label></dt>
				<dd class="avatar-upload-container clearfix position-relative">

     			<form class="edit_user" id="" novalidate="novalidate" aria-label="Profile picture" action="/users/theochino" accept-charset="UTF-8" method="post">
     				<input name="utf8" type="hidden" value="">
     				<input type="hidden" name="_method" value="put">
     				<input type="hidden" name="authenticity_token" value="2yfFVDUHziH+foV7pu8fJ6DsjbYyA9sjvX7ntAtoDwPKuscWvP/+BYJ+l0nFn3Txfg6KB+BDVTRvdRXGEcy2Wg==">
        		<file-attachment class="js-upload-avatar-image is-default" data-alambic-owner-id="5959961" data-alambic-owner-type="User" data-upload-policy-url="/upload/policies/avatars" data-upload-policy-authenticity-token="HyAjReJFTnDfyCwHGseeM446P0yzAzpOlvQXaOvae0TlWXppk4S9Q4oYrIOxKvmI7GvH613c8tg09ATjqFMLQg==">
	         		<input type="file" id="avatar_upload" class="manual-file-chooser width-full ml-0 js-manual-file-chooser" hidden="">
	        		<div class="avatar-upload">
							  <div class="upload-state text-red file-empty">This file is empty.</div>
							  <div class="upload-state text-red too-big">Please upload a picture smaller than 1 MB.</div>
							  <div class="upload-state text-red bad-dimensions">Please upload a picture smaller than 10,000x10,000.</div>
							  <div class="upload-state text-red bad-file">We only support PNG, GIF, or JPG pictures.</div>
							  <div class="upload-state text-red failed-request">Something went really wrong and we cant process that picture.</div>
							  <div class="upload-state text-red bad-format">File contents dont match the file extension.</div>
							</div>
						</file-attachment>
					</form>      

					<div class="avatar-upload">
						<details class="dropdown details-reset details-overlay">
							<summary aria-haspopup="menu" role="button">
								<img class="avatar rounded-2" src="https://avatars1.githubusercontent.com/u/5959961?s=400&amp;u=93c09a9b257d123fb29cfcad94e17e39d22ee4d6&amp;v=4" alt="@theochino" width="200" height="200">
								<div class="position-absolute bg-gray-dark rounded-2 text-white px-2 py-1 left-0 bottom-0 ml-2 mb-2">
								<svg height="16" width="16" class="octicon octicon-pencil" viewBox="0 0 14 16" version="1.1" aria-hidden="true"><path fill-rule="evenodd" d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 011.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
									Edit
								</div>
							</summary>
					<details-menu class="dropdown-menu dropdown-menu-se" style="z-index: 99" role="menu">
					<label for="avatar_upload" class="dropdown-item text-normal" style="cursor: pointer;" role="menuitem" tabindex="0">Upload a photo</label>
					<form action="/settings/reset_avatar" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value=""><input type="hidden" name="_method" value="put"><input type="hidden" name="authenticity_token" value="ybw4BHhwEctWBy24rxeR3RWSXmfIs86mDiE4xE4bYYhGV9ixI3ijmlYbroCRwxiKS3VotC/RSx7PUEL4/fLKEQ==">                <button class="btn-link dropdown-item js-detect-gravatar" type="submit" name="op" value="reset" role="menuitem" data-disable-with="" data-confirm="Are you sure you want to reset your current avatar?" data-gravatar-text="Revert to Gravatar" data-url="/settings/user_has_gravatar">
					Remove photo
					</button>
					</form>          </details-menu>
					</details>
					
					<div class="upload-state loading position-absolute bg-gray-light rounded-2" style="top: 0; right: 0; opacity: 0.25; width: 200px; height: 200px;">
					<img class="position-absolute" style="top: 40px; left: 35px;" alt="Loading" src="https://github.githubassets.com/images/spinners/octocat-spinner-128.gif">
					</div>
					</div>
					</dd>
					</dl>

    </div>
  </div>


 

  </div>

		
</div>
			
		
	</div>
</DIV>






<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>