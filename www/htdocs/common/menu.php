<?php
	WriteStderr($rmbperson, "RMBPerson in Menu");
	
	if (empty ($URIEncryptedString["EDAD"])) { 
		$MenuDescription = "District Not Defined";
	} else {
		$MenuDescription = ParseEDAD($URIEncryptedString["EDAD"]);
	} 
	
	if ($MobileDisplay == true) { 
	$DIVCol="col-12";
	?>
<div class="justifymobile">
  <nav class="mobilemenu" aria-label="">
    <h3 class="mobilemenu"><?= $MenuDescription ?></h3>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_SUMMARY ) { ?><a class="<?php if ( $Menu == "summary" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/summary/summary">Summary</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DISTRICT ) { ?><a class="<?php if ( $Menu == "district" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/district/district">District</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PETITIONS ) { ?><a class="<?php if ( $Menu == "petitions" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/petitions/petitions">Petitions</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_VOTERS ) { ?><a class="<?php if ( $Menu == "voters" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/voters/voterlist">Voters</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_TEAM ) { ?><a class="<?php if ( $Menu == "team" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/team/team">Team</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_MESSAGES ) { ?><a class="<?php if ( $Menu == "messages" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/messages/messages">Messages</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DOWNLOADS ) { ?><a class="<?php if ( $Menu == "downloads" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/downloads/downloads">Downloads</a><?php } ?>
  	<?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PROFILE ) { ?><a class="<?php if ( $Menu == "profile" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/profile/profile">Personal Profile</a><?php } ?>
  </nav>

<?php /*
  <nav class="" aria-label="Other Candidates">
  	<h3 class="">Other Candidates</h3>
    <a class="d-flex flex-items-center" href="/special/?k=<?= $k ?>"><img class="avatar" src="https://avatars1.githubusercontent.com/u/56751304?s=40&amp;v=4" width="20" height="20" alt="@repmyblock" />
    	<span class="" style="max-width: 170px" title="repmyblock">Bernie Sanders</span>
    </a>
          
    <a class="" href="/special/?k=<?= $k ?>">
      <img class="avatar" src="https://avatars3.githubusercontent.com/u/57964615?s=40&amp;v=4" width="20" height="20" alt="@walkthecounty" />
      <span class="" style="max-width: 170px" title="walkthecounty">Andrew Yang</span>
    </a>
  </nav>
</div>
*/ ?>

<?php } else { 
	$DIVCol="col-9";
	?>
<div class="col-3 float-left pr-4">
	  <nav class="menu position-relative" aria-label="Personal settings" data-pjax>
	    <h3 class="menu-heading"><?= $MenuDescription ?></h3>
			<?php if ( ! empty ($rmbperson["SystemUser_Priv"]) ) { ?>
		 		<?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_SUMMARY ) { ?><a class="<?php if ( $Menu == "summary" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/summary/summary">Summary</a><?php } ?>
		    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DISTRICT ) { ?><a class="<?php if ( $Menu == "district" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/district/district">District</a><?php } ?>
	 			<?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PLEDGES ) { ?><a class="<?php if ( $Menu == "pledge" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/pledges/pledges">Pledges</a><?php } ?>
	    	<?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PETITIONS ) { ?><a class="<?php if ( $Menu == "petitions" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/petitions/petitions">Petitions</a><?php } ?>
	   		<?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_VOTERS ) { ?><a class="<?php if ( $Menu == "voters" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/voters/voterlist">Voters</a><?php } ?>
	    	<?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_TEAM ) { ?><a class="<?php if ( $Menu == "team" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/team/team">Team</a><?php } ?>
	    	<?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_MESSAGES ) { ?><a class="<?php if ( $Menu == "messages" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/messages/messages">Messages</a><?php } ?>
	    	<?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DOWNLOADS ) { ?><a class="<?php if ( $Menu == "downloads" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/downloads/downloads">Downloads</a><?php } ?>
		  </nav>

		  <nav class="menu" aria-label="Profile">
	  		<?php if ($rmbperson["SystemUser_Priv"] & PERM_MENU_PROFILE ) { ?><a class="<?php if ( $Menu == "profile" ) { echo "selected "; } ?>menu-item" href="/<?= $k ?>/lgd/profile/profile">Personal Profile</a><?php } ?>
	  		<?php if ($rmbperson["SystemUser_Priv"] & PERM_ADMIN_MENU) { ?><a class="<?php if ( $Menu == "admin" ) { echo "selected "; } ?>menu-item" href="/<?= $k ?>/admin/index">Admin Profile</a><?php } ?>
			<?php } ?>
	  </nav>
	
  
<?php /*

  <nav class="menu" aria-label="Other Candidates" data-pjax>
  	<h3 class="menu-heading">Other Candidates</h3>
    <a class="menu-item d-flex flex-items-center" href="/special/?k=<?= $k ?>"><img class="avatar" src="https://avatars1.githubusercontent.com/u/56751304?s=40&amp;v=4" width="20" height="20" alt="@repmyblock" />
    	<span class="pl-2 flex-auto css-truncate css-truncate-target" style="max-width: 170px" title="repmyblock">Bernie Sanders</span>
    </a>
          
    <a class="menu-item d-flex flex-items-center" href="/special/?k=<?= $k ?>">
      <img class="avatar" src="https://avatars3.githubusercontent.com/u/57964615?s=40&amp;v=4" width="20" height="20" alt="@walkthecounty" />
      <span class="pl-2 flex-auto css-truncate css-truncate-target" style="max-width: 170px" title="walkthecounty">Andrew Yang</span>
    </a>
  </nav>
*/ ?>
</div>

<?php }
	### Verification email
	PrintVerifMenu($VerifEmail, $VerifVoter); 
?>
