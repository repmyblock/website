<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "summary";
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

	<div class="Subhead">
  	<h2 class="Subhead-heading">Summary</h2>
	</div>
	
	<div class="flash flash-warn mb-4">
    <a class="btn btn-sm flash-action" href="/lgd/profile">Verify your voter information</a>
    <svg class="octicon octicon-alert" viewBox="0 0 16 16" version="1.1" width="16" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M8.893 1.5c-.183-.31-.52-.5-.887-.5s-.703.19-.886.5L.138 13.499a.98.98 0 000 1.001c.193.31.53.501.886.501h13.964c.367 0 .704-.19.877-.5a1.03 1.03 0 00.01-1.002L8.893 1.5zm.133 11.497H6.987v-2.003h2.039v2.003zm0-3.004H6.987V5.987h2.039v4.006z"></path></svg>
    <strong class="ml-1">Voter information not verified</strong>
    <p class="text-small pt-1">
      You can't set your candidate profile until the voter information is verified.
    </p>
  </div>
          
          
    <div class="d-flex flex-column flex-md-row mb-3">
    	<div class="col-12 py-3 px-4 col-md-4 mb-md-0 mb-3 mr-md-3 bg-gray rounded-1">
        <h4 class="f5 text-normal text-gray">Democrats in the district</h4>
        <span class="f2 text-bold d-block mt-1 mb-2 pb-1">N/A</span>
    	</div>

    	<div class="col-md-4 mr-md-3 col-12 py-3 px-4 mb-md-0 mb-3 bg-gray rounded-1">
      	<h4 class="f5 text-normal text-gray">Required Signatures</h4>
  			<span class="f2 text-bold d-block mt-1 mb-2 pb-1">3%</span>
				<a class="f6" href="/account/billing/history">Payment history</a>
    </div>

    <div class="col-md-4 col-12 py-3 px-4 mb-md-0 mb-3 bg-gray rounded-1">
      <h4 class="f5 text-normal text-gray">Frequent actions</h4>
<ul class="billing-frequentActions-list list-style-none">
    <li>
      <a href="/settings/billing/payment" class="f6 ">Update payment method</a>
    </li>

  <li><a class="f6" href="/account/billing/history">View payment history</a></li>
  <li><a class="f6" href="/pricing">Explore subscription options</a></li>
</ul>

    </div>
  </div>
  
   <dl class="form-group">
            <dt><label for="user_profile_email">Public email</label></dt>
            <dd class="d-inline-block">
              <div>
                  <select class="form-select form-select" name="user[profile_email]" id="user_profile_email"><option value="">Select a verified email to display</option>
										<option value="github@theochino.com">github@theochino.com</option></select>
                  <p class="note">You can manage verified 
                    email addresses in your <a href="/settings/emails">email settings</a>.
                  </p>
              </div>
            </dd>
          </dl>
       
			
			<P>
				Once you collect the  <?= $NumberOfSignatures ?> plus a few more, you need to wait until April 1<sup>st</sup> to take them
				to the board of elections. <B>Just follow the 
			<A HREF="<?= $FrontEndWeb ?>/where-to-file/prepare-to-file-your-petition-to-the-board-of-elections.html">instruction posted on the FAQ</A>.</B>
			</P>


     
  
		

			
		
		
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






<?php include $_SERVER["DOCUMENT_ROOT"] . "/get-involved/headers/footer.php";	?>