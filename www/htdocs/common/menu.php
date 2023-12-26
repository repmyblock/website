<!--- Start Menu ---><?php
  WriteStderr($rmbperson, "RMBPerson in /common/menu.php");
  
  if (empty ($rmbperson["SystemUser_EDAD"])) { 
    if (empty ($URIEncryptedString["EDAD"])) { 
      $MenuDescription = "District Not Defined";
    } else {
      $MenuDescription = ParseEDAD($URIEncryptedString["EDAD"]);
    } 
  } else {
    $MenuDescription = ParseEDAD($rmbperson["SystemUser_EDAD"]);
  } 
  
	if ($MobileDisplay == true) { 
		$DIVCol="col-12"; 
		$DivClass1 = "justifymobile";
		$DivClass2 = "mobilemenu"; $DivClass3 = "";
		$DivClass4 = "mobilemenu";
		$DivClass5 = "mobilemenu";
		$DivClass6 = "";
		$DivClass7 = "";
	} else { 
		$DIVCol="col-9";
		$DivClass1 = "col-3 float-left pr-4";
		$DivClass2 = "menu"; $DivClass3 = "Personal settings";
		$DivClass4 = "menu-heading";
		$DivClass5 = "js-selected-navigation-item menu-item";
		$DivClass6 = "Profile";
		$DivClass7 = "menu-item";
	}
  ?>
  
	  <DIV class="<?= $DivClass1 ?>">
	    <NAV class="<?= $DivClass2 ?>" aria-label="<?= $DivClass3 ?>">
	      <H3 class="<?= $DivClass4 ?>"><?= $MenuDescription ?></H3>
				<?php if ( ! empty ($rmbperson["SystemUser_Priv"]) ) { ?>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_SUMMARY ) { ?><A class="<?php if ( $Menu == "summary" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/summary/summary">Summary</a><?php } ?>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PETITIONS ) { ?><A class="<?php if ( $Menu == "petitions" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/petitions/downloads">Petitions</a><?php } ?>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DISTRICT ) { ?><A class="<?php if ( $Menu == "district" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/district/index">District</a><?php } ?>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_WALKSHEET ) { ?><A class="<?php if ( $Menu == "walksheets" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/walksheets/petitions">Walksheets</a><?php } ?>
	        <A class="<?php if ( $Menu == "candidates" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/candidates/list">Candidates</A>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PLEDGES ) { ?><A class="<?php if ( $Menu == "pledge" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/pledges/index">Pledges</a><?php } ?>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_VOTERS ) { ?><a class="<?php if ( $Menu == "voters" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/voters/voterlist">Voters</a><?php } ?>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_TEAM ) { ?><a class="<?php if ( $Menu == "team" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/team/index">Team</a><?php } ?>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DOCU ) { ?><a class="<?php if ( $Menu == "documentary" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/documentary/county">Documentary</a><?php } ?>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_MESSAGES ) { ?><a class="<?php if ( $Menu == "messages" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/messages/messages">Messages</a><?php } ?>
	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DOWNLOADS ) { ?><a class="<?php if ( $Menu == "downloads" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/downloads/downloads">Downloads</a><?php } ?>    
	      </NAV>

	      <NAV class="<?= $DivClass2 ?>" aria-label="<?= $DivClass6 ?>">
	        <?php if ($rmbperson["SystemUser_Priv"] & PERM_MENU_PROFILE ) { ?><A class="<?php if ( $Menu == "profile" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/lgd/profile/user">Personal Profile</A><?php } ?>
	        <?php if ($rmbperson["SystemUser_Priv"] & PERM_ADMIN_MENU) { ?><A class="<?php if ( $Menu == "admin" ) { echo "selected "; } ?><?= $DivClass5 ?>" href="/<?= $k ?>/admin/index">Admin Profile</A><?php } ?>
			<?php } ?>
			</NAV>
	  </DIV>
<?php 
  // Verification email (I might need to remove these variables ...)
  $VerifEmail = false; $VerifVoter = false;
  PrintVerifMenu($VerifEmail, $VerifVoter); 
?><!--- End Menu --->
