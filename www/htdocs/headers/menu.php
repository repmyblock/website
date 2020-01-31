<?php	if ($MobileDisplay == true) { ?>
<div class="">
  <nav class="mobilemenu" aria-label="">
    <h3 class="mobilemenu"><?= $MenuDescription ?></h3>
    <a class="<?php if ( $Menu == "summary" ) { echo "selected "; } ?>mobilemenu" href="/lgd/?k=<?= $k ?>">Summary</a>
    <a class="<?php if ( $Menu == "district" ) { echo "selected "; } ?>mobilemenu" href="/lgd/district/?k=<?= $k ?>">District</a>
    <a class="<?php if ( $Menu == "petitions" ) { echo "selected "; } ?>mobilemenu" href="/lgd/petitions/?k=<?= $k ?>">Petitions</a>
    <a class="<?php if ( $Menu == "voters" ) { echo "selected "; } ?>mobilemenu" href="/lgd/voters/?k=<?= $k ?>">Voters</a>
    <a class="<?php if ( $Menu == "team" ) { echo "selected "; } ?>mobilemenu" href="/lgd/team/?k=<?= $k ?>">Team</a>
    <a class="<?php if ( $Menu == "messages" ) { echo "selected "; } ?>mobilemenu" href="/lgd/messages/?k=<?= $k ?>">Messages</a>
    <a class="<?php if ( $Menu == "downloads" ) { echo "selected "; } ?>mobilemenu" href="/lgd/downloads/?k=<?= $k ?>">Downloads</a>
  </nav>

  <nav class="" aria-label="Profile">
  	<a class="<?php if ( $Menu == "profile" ) { echo "selected "; } ?>" href="/lgd/profile/?k=<?= $k ?>">Personal Profile</a>  
  </nav>

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
<?php } else { ?>
<div class="col-3 float-left pr-4">
  <nav class="menu position-relative" aria-label="Personal settings" data-pjax>
    <h3 class="menu-heading"><?= $MenuDescription ?></h3>
    <a class="<?php if ( $Menu == "summary" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/lgd/?k=<?= $k ?>">Summary</a>
    <a class="<?php if ( $Menu == "district" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/lgd/district/?k=<?= $k ?>">District</a>
    <a class="<?php if ( $Menu == "petitions" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/lgd/petitions/?k=<?= $k ?>">Petitions</a>
    <a class="<?php if ( $Menu == "voters" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/lgd/voters/?k=<?= $k ?>">Voters</a>
    <a class="<?php if ( $Menu == "team" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/lgd/team/?k=<?= $k ?>">Team</a>
    <a class="<?php if ( $Menu == "messages" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/lgd/messages/?k=<?= $k ?>">Messages</a>
    <a class="<?php if ( $Menu == "downloads" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" href="/lgd/downloads/?k=<?= $k ?>">Downloads</a>
  </nav>

  <nav class="menu" aria-label="Profile">
  	<a class="<?php if ( $Menu == "profile" ) { echo "selected "; } ?>menu-item" href="/lgd/profile/?k=<?= $k ?>">Personal Profile</a>  
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
<?php } ?>
