

<div class="col-3 float-left pr-4">
  <nav class="menu position-relative" aria-label="Personal settings" data-pjax>
    <h3 class="menu-heading">ED 73 / AD 93</h3>
    <a class="<?php if ( $Menu == "summary" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" aria-current="page" data-selected-links="avatar_settings /settings/profile" href="/lgd/?k=<?= $k ?>">Summary</a>
    <a class="<?php if ( $Menu == "district" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" data-selected-links=" /settings/admin" href="/lgd/district">District</a>
    <a class="<?php if ( $Menu == "petitions" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" data-selected-links=" /settings/security" href="/lgd/petitions">Petitions</a>
    <a class="<?php if ( $Menu == "electors" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" data-selected-links="audit_log /settings/security-log" href="/lgd/electors">Electors</a>
    <a class="<?php if ( $Menu == "team" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" data-selected-links=" /settings/emails" href="/lgd/team">Team</a>
    <a class="<?php if ( $Menu == "messages" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" data-selected-links=" /settings/emails" href="/lgd/messages">Messages</a>
    <a class="<?php if ( $Menu == "downloads" ) { echo "selected "; } ?>js-selected-navigation-item menu-item" data-selected-links=" /settings/emails" href="/lgd/downloads">Downloads</a>

  </nav>

  <nav class="menu" aria-label="Profile">
  	<a class="<?php if ( $Menu == "profile" ) { echo "selected "; } ?>menu-item" href="/lgd/profile">Personal Profile</a>  
  </nav>

  <nav class="menu" aria-label="Other Candidates" data-pjax>
  	<h3 class="menu-heading">Other Candidates</h3>
    <a class="menu-item d-flex flex-items-center" href="/organizations/repmyblock/settings/profile"><img class="avatar" src="https://avatars1.githubusercontent.com/u/56751304?s=40&amp;v=4" width="20" height="20" alt="@repmyblock" />
    	<span class="pl-2 flex-auto css-truncate css-truncate-target" style="max-width: 170px" title="repmyblock">Bernie Sanders</span>
    </a>
          
    <a class="menu-item d-flex flex-items-center" href="/organizations/walkthecounty/settings/profile">
      <img class="avatar" src="https://avatars3.githubusercontent.com/u/57964615?s=40&amp;v=4" width="20" height="20" alt="@walkthecounty" />
      <span class="pl-2 flex-auto css-truncate css-truncate-target" style="max-width: 170px" title="walkthecounty">Andrew Yang</span>
    </a>
  </nav>
</div>