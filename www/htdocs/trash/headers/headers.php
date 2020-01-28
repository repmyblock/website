<?php
	// echo "<B>Decrypted Line:</B> " .  $_SERVER['DOCUMENT_URI'] .  "<UL>$Decrypted_k</UL>";
	if ( ! empty ($k) && $SystemUser_ID > 0 ) { $MenuLogin = "logged"; }
	$imgtoshow = "RepMyBlock.png";
	
	/* 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    */
	
	
?><!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#" class="no-js">
	<HEAD>
		<META charset="UTF-8">
		<TITLE>Rep My Block - Represent My Block - Nominate A Candidate</TITLE>

		<meta name="twitter:card" content="summary_large_image" />
		<meta name="twitter:description" content="Registrations for the 2020 county committee cycle in the Bronx, Queens and Brooklyn have started. Registration for the 2021 county committee cycle in Manhattan and Staten Island have started. Get your nominating petition kit here! HOW DOES IT WORKS The County Committee is the most basic committee of the Democratic Party; its its backbone. The &hellip; Continue reading Rep My Block &rarr;" />
		<meta name="twitter:title" content="Rep My Block - Rep My Block" />
		<meta name="twitter:site" content="@RepMyBlock" />
		<meta name="twitter:image" content="https://static.repmyblock.nyc/pics/paste/PoliticalMachineKeepEngagementLow.jpg" />
		<meta name="twitter:creator" content="@RepMyBlock" />

		<link rel="icon" href="/pics/favicon/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/pics/favicon/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="/pics/icons/css/all.min.css" >		
		<link rel="stylesheet" type="text/css" href="/font/montserrat.css">
		<link rel="stylesheet" type="text/css" href="/css/RepMyBlock.css">		
	</HEAD>
	
	<BODY>
		<DIV class="header">
		 <div class="header-left">
			  <a href="/" class="logo"><IMG SRC="/pics/RepMyBlock.png" height=70 class="header-logo"></a>
		</DIV>
		  <div class="header-right">
  	  	<a href="/contact">CONTACT</a>
		  	<?php if ( $MenuLogin == "logged") { ?>
					 <a href="/get-involved/?k=<?= $NewKToEncrypt ?>" class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>">LOGOUT</a>
				<?php } else { ?>
		    	<a href="/get-involved/login">LOGIN</a>
		    <?php } ?>
		  </DIV>
		</DIV> 
		
<div class="Header-item position-relative">
	<details class="details-overlay details-reset">
		
		<?php /*
  	<summary class="Header-link" aria-label="Create new" data-ga-click="Header, create new, icon:add">
    	<svg class="octicon octicon-plus" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M12 9H7v5H5V9H0V7h5V2h2v5h5v2z"/></svg> 
    	<span class="dropdown-caret"></span>
  	</summary>
  	*/ ?>
  	
	  <details-menu class="dropdown-menu dropdown-menu-sw">   
			<a role="menuitem" class="dropdown-item" href="/new" data-ga-click="Header, create new repository">New repository</a>
			<a role="menuitem" class="dropdown-item" href="/new/import" data-ga-click="Header, import a repository">Import repository</a>
			<a role="menuitem" class="dropdown-item" href="https://gist.github.com/" data-ga-click="Header, create new gist">New gist</a>
			<a role="menuitem" class="dropdown-item" href="/organizations/new" data-ga-click="Header, create new organization">New organization</a>
			<a role="menuitem" class="dropdown-item" href="/new/project" data-ga-click="Header, create new project">New project</a>
	  </details-menu>
	</details>
</div>

<div class="Header-item position-relative mr-0">      
  <details class="details-overlay details-reset js-feature-preview-indicator-container" data-feature-preview-indicator-src="/users/theochino/feature_preview/indicator_check.json">
  <summary class="Header-link"
    aria-label="View profile and more"
    data-ga-click="Header, show menu, icon:avatar">
    <img alt="@theochino" class="avatar" src="https://avatars0.githubusercontent.com/u/5959961?s=40&amp;u=93c09a9b257d123fb29cfcad94e17e39d22ee4d6&amp;v=4" height="20" width="20">
      <span class="feature-preview-indicator js-feature-preview-indicator" hidden></span>
    <span class="dropdown-caret"></span>
  </summary>

  <details-menu class="dropdown-menu dropdown-menu-sw mt-2" style="width: 180px">
    <div class="header-nav-current-user css-truncate"><a role="menuitem" class="no-underline user-profile-link px-3 pt-2 pb-2 mb-n2 mt-n1 d-block" href="/theochino" data-ga-click="Header, go to profile, text:Signed in as">Signed in as <strong class="css-truncate-target">theochino</strong></a></div>
    <div role="none" class="dropdown-divider"></div>
    <div class="pl-3 pr-3 f6 user-status-container js-user-status-context pb-1" data-url="/users/status?compact=1&amp;link_mentions=0&amp;truncate=1">
    <div class="js-user-status-container user-status-compact rounded-1 px-2 py-1 mt-2 border" data-team-hovercards-enabled>
  	
  	<details class="js-user-status-details details-reset details-overlay details-overlay-dark">
    <summary class="btn-link btn-block link-gray no-underline js-toggle-user-status-edit toggle-user-status-edit " role="menuitem" >
   

    </div>
    <div role="none" class="dropdown-divider"></div>
    <a role="menuitem" class="dropdown-item" href="/theochino" data-ga-click="Header, go to profile, text:your profile">Your profile</a>
    <a role="menuitem" class="dropdown-item" href="/theochino?tab=repositories" data-ga-click="Header, go to repositories, text:your repositories">Your repositories</a>
    <a role="menuitem" class="dropdown-item" href="/theochino?tab=projects" data-ga-click="Header, go to projects, text:your projects">Your projects</a>
    <a role="menuitem" class="dropdown-item" href="/theochino?tab=stars" data-ga-click="Header, go to starred repos, text:your stars">Your stars</a>
    <a role="menuitem" class="dropdown-item" href="https://gist.github.com/mine" data-ga-click="Header, your gists, text:your gists">Your gists</a>
    <div role="none" class="dropdown-divider"></div>
      
<div id="feature-enrollment-toggle" class="hide-sm hide-md feature-preview-details position-relative">
  <button
    type="button"
    class="dropdown-item btn-link"
    role="menuitem"
    data-feature-preview-trigger-url="/users/theochino/feature_previews"
    data-feature-preview-close-details="{&quot;event_type&quot;:&quot;feature_preview.clicks.close_modal&quot;,&quot;payload&quot;:{&quot;client_id&quot;:&quot;986189287.1558971274&quot;,&quot;originating_request_id&quot;:&quot;DF8C:322F:68FF04:C5274B:5E061439&quot;,&quot;originating_url&quot;:&quot;https://github.com/settings/profile&quot;,&quot;referrer&quot;:&quot;https://github.com/settings/applications/1194465&quot;,&quot;user_id&quot;:5959961}}"
    data-feature-preview-close-hmac="9f3539022b5fc74ff41696b67ba626a6a0cf3767bc2eff3053b06321ffdcec7a"
    data-hydro-click="{&quot;event_type&quot;:&quot;feature_preview.clicks.open_modal&quot;,&quot;payload&quot;:{&quot;link_location&quot;:&quot;user_dropdown&quot;,&quot;client_id&quot;:&quot;986189287.1558971274&quot;,&quot;originating_request_id&quot;:&quot;DF8C:322F:68FF04:C5274B:5E061439&quot;,&quot;originating_url&quot;:&quot;https://github.com/settings/profile&quot;,&quot;referrer&quot;:&quot;https://github.com/settings/applications/1194465&quot;,&quot;user_id&quot;:5959961}}"
    data-hydro-click-hmac="3ad7a7d460bb4f74bc667686bf19371218e33380dab782bedb6fb2454f69bc60">
    Feature preview
  </button>
    <span class="feature-preview-indicator js-feature-preview-indicator" hidden></span>
</div>

    <a role="menuitem" class="dropdown-item" href="https://help.github.com" data-ga-click="Header, go to help, text:help">Help</a>
    <a role="menuitem" class="dropdown-item" href="/settings/profile" data-ga-click="Header, go to settings, icon:settings">Settings</a>
    <!-- '"` --><!-- </textarea></xmp> --></option></form>
    <form class="logout-form" action="/logout" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="5f9Ttk4HQeFbwEVMRdwRMjre+f99aZqIv5fMgMSQr0T3mR9WJaOWpnTPEUJ/U6jxrMXkijQ91KgRNBBUxiJxfA==" />
      
      <button type="submit" class="dropdown-item dropdown-signout" data-ga-click="Header, sign out, icon:logout" role="menuitem">
        Sign out
      </button>
      <input type="text" name="required_field_d107" hidden="hidden" class="form-control" />
<input type="hidden" name="timestamp" value="1577456697415" class="form-control" />
<input type="hidden" name="timestamp_secret" value="10c29fa4c05aef92e1eda9fe250e8d42710bf2532d384b7eefd8f9f606c02ef5" class="form-control" />
</form> >
</details-menu>
</details>

    </div>

<?php $NewKToEncrypt = EncryptURL("SystemUser_ID=" . $SystemUser_ID); ?>

<?php /*
<nav class="d-flex" aria-label="Global">
  <a class="js-selected-navigation-item Header-link  mr-3" data-hotkey="g p" data-ga-click="Header, click, Nav menu - item:pulls context:user" aria-label="Pull requests you created" data-selected-links="/pulls /pulls/assigned /pulls/mentioned /pulls" href="/pulls">Pull requests</a>
  <a class="js-selected-navigation-item Header-link  mr-3" data-hotkey="g i" data-ga-click="Header, click, Nav menu - item:issues context:user" aria-label="Issues you created" data-selected-links="/issues /issues/assigned /issues/mentioned /issues" href="/issues">Issues</a>
  <div class="mr-3">
  	<a class="js-selected-navigation-item Header-link" data-ga-click="Header, click, Nav menu - item:marketplace context:user" data-octo-click="marketplace_click" data-octo-dimensions="location:nav_bar" data-selected-links=" /marketplace" href="/marketplace">Marketplace</a>      
	</div>
  <a class="js-selected-navigation-item Header-link  mr-3" data-ga-click="Header, click, Nav menu - item:explore" data-selected-links="/explore /trending /trending/developers /integrations /integrations/feature/code /integrations/feature/collaborate /integrations/feature/ship showcases showcases_search showcases_landing /explore" href="/explore">Explore</a>
</nav>
*/ ?>

<div class="navbar">
<?php if ( $MenuLogin == "logged") { ?>
  <a href="/get-involved/profile/?k=<?= $NewKToEncrypt ?>" class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>">PROFILE</a>
  <a href="/get-involved/nominate/?k=<?= $NewKToEncrypt ?>"<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?>>NOMINATE</a>
  <a href="/get-involved/list/?k=<?= $NewKToEncrypt ?>"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
  <a href="/about/?k=<?= $NewKToEncrypt ?>"<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?>>ABOUT</a>
<?php } else { ?>
  <a href="/where-to-file/prepare-to-file-your-petition-to-the-board-of-elections.html" class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>">HOW TO</a>
  <a href="/get-involved/propose"<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?>>NOMINATE</a>
  <a href="/get-involved/interested"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
  <a href="/about/"<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?>>ABOUT</a>
<?php } ?>  
</div>

<?php /* php 

  <title>Your Profile</title>
    <meta name="description" content="GitHub is where people build software. More than 40 million people use GitHub to discover, fork, and contribute to over 100 million projects.">
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub">
  <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub">
  
  
  <meta property="fb:app_id" content="1401488693436528">
  <meta property="og:url" content="https://github.com">
  <meta property="og:site_name" content="GitHub">
  <meta property="og:title" content="Build software better, together">
  <meta property="og:description" content="GitHub is where people build software. More than 40 million people use GitHub to discover, fork, and contribute to over 100 million projects.">
  <meta property="og:image" content="https://github.githubassets.com/images/modules/open_graph/github-logo.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="1200">
  <meta property="og:image" content="https://github.githubassets.com/images/modules/open_graph/github-mark.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="620">
  <meta property="og:image" content="https://github.githubassets.com/images/modules/open_graph/github-octocat.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="620">

  <meta property="twitter:site" content="github">
  <meta property="twitter:site:id" content="13334762">
  <meta property="twitter:creator" content="github">
  <meta property="twitter:creator:id" content="13334762">
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:title" content="GitHub">
  <meta property="twitter:description" content="GitHub is where people build software. More than 40 million people use GitHub to discover, fork, and contribute to over 100 million projects.">
  <meta property="twitter:image:src" content="https://github.githubassets.com/images/modules/open_graph/github-logo.png">
  <meta property="twitter:image:width" content="1200">
  <meta property="twitter:image:height" content="1200">
  */
?>
 