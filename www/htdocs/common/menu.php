  <!--- Start Menu --->
<?php
  WriteStderr($rmbperson, "RMBPerson in Menu");
  
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
  ?>
  <DIV class="justifymobile">
      <NAV class="mobilemenu" aria-label="">
    <h3 class="mobilemenu"><?= $MenuDescription ?></h3>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_SUMMARY ) { ?><a class="<?php if ( $Menu == "summary" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/summary/summary">Summary</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DISTRICT ) { ?><a class="<?php if ( $Menu == "district" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/district/index">District</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PETITIONS ) { ?><a class="<?php if ( $Menu == "petitions" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/petitions/downloads">Petitions</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_WALKSHEETS ) { ?><a class="<?php if ( $Menu == "walksheets" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/walksheets/petitions">Walksheets</a><?php } ?>
     <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PLEDGES ) { ?><a class="<?php if ( $Menu == "pledge" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/pledges/index">Pledges</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_VOTERS ) { ?><a class="<?php if ( $Menu == "voters" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/voters/voterlist">Voters</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_TEAM ) { ?><a class="<?php if ( $Menu == "team" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/team/index">Team</a><?php } ?>
     <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DOCU ) { ?><a class="<?php if ( $Menu == "documentary" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/documentary/county">Documentary</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_MESSAGES ) { ?><a class="<?php if ( $Menu == "messages" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/messages/messages">Messages</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DOWNLOADS ) { ?><a class="<?php if ( $Menu == "downloads" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/downloads/downloads">Downloads</a><?php } ?>
    <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PROFILE ) { ?><a class="<?php if ( $Menu == "profile" ) { echo "selected "; } ?>mobilemenu" href="/<?= $k ?>/lgd/profile/user">Personal Profile</a><?php } ?>
  </nav>

<?php } else { 
  $DIVCol="col-9";
  ?>
        <DIV class="col-3 float-left pr-4">
          <NAV class="menu" aria-label="Personal settings">
            <H3 class="menu-heading"><?= $MenuDescription ?></H3>
<?php if ( ! empty ($rmbperson["SystemUser_Priv"]) ) { ?>
            <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_SUMMARY ) { ?><A class="<?php if ( $Menu == "summary" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/summary/summary">Summary</a><?php } ?>

	        <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PETITIONS ) { ?><A class="<?php if ( $Menu == "petitions" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/petitions/downloads">Petitions</a><?php } ?>

            <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DISTRICT ) { ?><A class="<?php if ( $Menu == "district" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/district/index">District</a><?php } ?>
              
            <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_WALKSHEETS ) { ?><A class="<?php if ( $Menu == "walksheets" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/walksheets/petitions">Walksheets</a><?php } ?>
              	
            <A class="<?php if ( $Menu == "candidates" ) { echo "selected "; } ?>menu-item" href="/<?= $k ?>/lgd/candidates/list">Candidates</A>
            <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_PLEDGES ) { ?><A class="<?php if ( $Menu == "pledge" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/pledges/index">Pledges</a><?php } ?>
               	
            <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_VOTERS ) { ?><a class="<?php if ( $Menu == "voters" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/voters/voterlist">Voters</a><?php } ?>
               	
            <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_TEAM ) { ?><a class="<?php if ( $Menu == "team" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/team/index">Team</a><?php } ?>
              
            <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DOCU ) { ?><a class="<?php if ( $Menu == "documentary" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/documentary/county">Documentary</a><?php } ?>
              	
            <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_MESSAGES ) { ?><a class="<?php if ( $Menu == "messages" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/messages/messages">Messages</a><?php } ?>
              	
            <?php if ( $rmbperson["SystemUser_Priv"] & PERM_MENU_DOWNLOADS ) { ?><a class="<?php if ( $Menu == "downloads" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/<?= $k ?>/lgd/downloads/downloads">Downloads</a><?php } ?>
     
          </NAV>

          <NAV class="menu" aria-label="Profile">
            <?php if ($rmbperson["SystemUser_Priv"] & PERM_MENU_PROFILE ) { ?><A class="<?php if ( $Menu == "profile" ) { echo "selected "; } ?>menu-item" href="/<?= $k ?>/lgd/profile/user">Personal Profile</A><?php } ?>
          	
            <?php if ($rmbperson["SystemUser_Priv"] & PERM_ADMIN_MENU) { ?><A class="<?php if ( $Menu == "admin" ) { echo "selected "; } ?>menu-item" href="/<?= $k ?>/admin/index">Admin Profile</A><?php } ?>
        
      <?php } ?>
    </NAV>
        </DIV>
<?php }
  ### Verification email
  PrintVerifMenu($VerifEmail, $VerifVoter); 
?>        <!--- End Menu --->
