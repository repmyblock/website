<?php $WebReferer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL; ?> 
 
    <DIV class="footer">
      <P class="footerclass1">
        <DIV class="FooterTitle">REP MY BLOCK</DIV>
        <DIV class="FooterInfo">Represent Community By Running For County Committee</DIV>
      </P>
      <P class="footerclass2">
        <DIV class="FooterLinks">
<?php if ( $MenuLogin == "logged") { ?>
          <A<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?> href="/<?= $middleuri ?>/toplinks/about">ABOUT</a>
          <A<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?> href="/<?= $middleuri ?>/training/steps/torun">REPRESENT</a>
          <A<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?> href="/<?= $middleuri ?>/propose/nomination">NOMINATE</a>
<?php } else { ?>              
          <A HREF="/<?= $middleuri ?>/toplinks/about">ABOUT</A>
          <A HREF="/<?= $middleuri ?>/register/user">REPRESENT</A>
          <A HREF="/<?= $middleuri ?>/propose/nomination">NOMINATE</A>
<?php } ?>          <A HREF="/<?= $middleuri ?>/training/steps/torun">HOWTO</A>
          <A HREF="/<?= $middleuri ?>/user/contact">CONTACT</A>
          <A TARGET="BUGPAGE" HREF="<?= $FrontEndBugs ?>/bugs/<?= CreateEncoded ( array(   
                                                                  "Referer" =>  $WebReferer,
                                                                  "URI" => $_SERVER['REQUEST_URI'],
                                                                  "DocumentRoot" => $_SERVER['DOCUMENT_ROOT'],
                                                                  "Version" => $BetaVersion,
                                                                  "PageRequestTime" => $_SERVER['REQUEST_TIME']
                                                                ))?>/intake">BUGS</A>
<?php if ( $MenuLogin == "logged") { ?>
          <A class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>" href="/<?= $middleuri ?>/lgd/profile">PROFILE</a>
<?php } else { ?>              
          <A HREF="/<?= $middleuri ?>/user/login">LOGIN</A>
<?php } ?>        </DIV>
        <DIV class="FooterSocial">
          <A TARGET="twitter" class="FooterSocial" HREF="https://twitter.com/RepMyBlock">Twitter</A>
          <A TARGET="facebook" class="FooterSocial" HREF="https://www.facebook.com/RepMyBlock">Facebook</A>
          <A TARGET="instagram" class="FooterSocial"  HREF="https://www.instagram.com/RepMyBlockNYC">Instagram</A>
        </DIV>
        <DIV class="FooterStuff">
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