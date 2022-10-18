    <DIV class="footer">
      <P CLASS="footerclass1">
        <DIV CLASS="FooterTitle">REP MY BLOCK</DIV>
        <DIV CLASS="FooterInfo">Represent Community By Running For County Committee</DIV>
      </P>
      <P CLASS="footerclass2">
        <DIV CLASS="FooterLinks">
<?php if ( $MenuLogin == "logged") { ?>
          <A<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?> href="/<?= $middleuri ?>/exp/toplinks/about">ABOUT</a>
          <A<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?> href="/<?= $middleuri ?>/training/steps/torun">REPRESENT</a>
          <A<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?> href="/<?= $middleuri ?>/exp/propose/nomination">NOMINATE</a>
<?php } else { ?>              
          <A HREF="/<?= $middleuri ?>/exp/toplinks/about">ABOUT</A>
          <A HREF="/<?= $middleuri ?>/training/steps/torun">REPRESENT</A>
          <A HREF="/<?= $middleuri ?>/exp/propose/nomination">NOMINATE</A>
<?php } ?>          <A HREF="/<?= $middleuri ?>/exp/toplinks/howto">HOWTO</A>
          <A HREF="/<?= $middleuri ?>/exp/contact/contact">CONTACT</A>
          <A TARGET="BUGPAGE" HREF="<?= $FrontEndBugs ?>/bugs/<?= CreateEncoded ( array(   
                                                                  "Referer" =>  $_SERVER['HTTP_REFERER'],
                                                                  "URI" => $_SERVER['REQUEST_URI'],
                                                                  "DocumentRoot" => $_SERVER['DOCUMENT_ROOT'],
                                                                  "Version" => $BetaVersion,
                                                                  "PageRequestTime" => $_SERVER['REQUEST_TIME']
                                                                ))?>/intake">BUG</A>
<?php if ( $MenuLogin == "logged") { ?>
          <A class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>" href="/<?= $middleuri ?>/lgd/profile">PROFILE</a>
<?php } else { ?>              
          <A HREF="/<?= $middleuri ?>/exp/login/login">LOGIN</A>
<?php } ?>        </DIV>
        <DIV CLASS="FooterSocial">
          <A TARGET="twitter" CLASS="FooterSocial" HREF="https://twitter.com/RepMyBlock">Twitter</A>
          <A TARGET="facebook" CLASS="FooterSocial" HREF="https://www.facebook.com/RepMyBlock">Facebook</A>
          <A TARGET="instagram" CLASS="FooterSocial"  HREF="https://www.instagram.com/RepMyBlockNYC">Instagram</A>
        </DIV>
        <DIV CLASS="FooterStuff">
          <I>RepMyBlock is a <A TARGET="ARMBPROJ" HREF="https://github.com/repmyblock">RepMyBlock</A> project.</I>
        </DIV>
      </P>
    </DIV>      
  <?php require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/GoogleAnalytics.php"; ?>
  </BODY>  
</HTML>
<?php
  $OverAllMicrotimeEnd = microtime(true);
  WriteStderr($OverAllMicrotimeEnd, " ------------------------------------------------------------ Microtime");
  WriteStderr(($OverAllMicrotimeEnd - $OverAllMicrotimeStart) . "\n\n\n", "Total Process Time");
?>