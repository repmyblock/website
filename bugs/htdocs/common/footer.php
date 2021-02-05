

		<div class="footer">
			<P CLASS="footerclass1">
				<DIV CLASS="FooterTitle">REP MY BLOCK</DIV>
				<DIV CLASS="FooterInfo">Represent Community By Running For County Committee</DIV>
			</P>
			<P CLASS="footerclass2">
				<DIV CLASS="FooterLinks">
<?php if ( $MenuLogin == "logged") { ?>
  <a href="/exp/<?= $middleuri ?>/about"<?php if ($BigMenu == "home") { echo " class=\"active\""; } ?>>ABOUT</a>
  <a href="/lgd/<?= $middleuri ?>/list"<?php if ($BigMenu == "represent") { echo " class=\"active\""; } ?>>REPRESENT</a>
  <a href="/exp/<?= $middleuri ?>/nominate"<?php if ($BigMenu == "nominate") { echo " class=\"active\""; } ?>>NOMINATE</a>
<?php } else { ?>							
					<A HREF="/exp/<?= $middleuri ?>/about">ABOUT</A>
					<A HREF="/exp/<?= $middleuri ?>/interested">REPRESENT</A>
					<A HREF="/exp/<?= $middleuri ?>/propose">NOMINATE</A>
<?php } ?>  
					<A HREF="/exp/<?= $middleuri ?>/howto">HOWTO</A>
					<A HREF="/exp/<?= $middleuri ?>/contact">CONTACT</A>
<?php if ( $MenuLogin == "logged") { ?>
				  <a href="/lgd/<?= $middleuri ?>/profile" class="right<?php if ($BigMenu == "profile") { echo " active"; } ?>">PROFILE</a>
<?php } else { ?>							
					<A HREF="/exp/<?= $middleuri ?>/login">LOGIN</A>
<?php } ?>  
				</DIV>
				<DIV CLASS="FooterSocial">
					<A TARGET="twitter" CLASS="FooterSocial" HREF="https://twitter.com/RepMyBlock">Twitter</A>
					<A TARGET="facebook" CLASS="FooterSocial" HREF="https://www.facebook.com/RepMyBlock">Facebook</A>
					<A TARGET="instagram" CLASS="FooterSocial"  HREF="https://www.instagram.com/RepMyBlockNYC">Instagram</A>
				</DIV>
				<DIV CLASS="FooterStuff">
					<I>RepMyBlock is a <A HREF="https://RepMyBLock.us">RepMyBlock</A> project.</I>
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