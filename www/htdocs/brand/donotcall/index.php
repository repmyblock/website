<?php
	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80"><?= $BrandingTitle ?></DIV>
	
			<P class="f50">
				The Do Not Call or Contact list is designed to reduce the amount of campaign 
				literature that ends up in your mailbox.
			</P>
			
			<P>
				To get started, simply send an email to
				<B><A HREF="mailto:donotcall@register.repmyblock.org">donotcall@register.repmyblock.org</A></B>.
				Follow the instructions to create a username, verify your profile, and 
				confirm your voter registration.
			</P>
			
			<P>
				We'll then send you a PDF form by email. Print, sign, and return it, and we will provide 
				it to all campaigns in your district.
			</P>
			
			<P>
				<CENTER><A HREF="mailto:donotcall@register.repmyblock.org"><IMG SRC="<?= $HeaderTwitterPicLink ?>"></A></CENTER>
			</P>
			
			<?php /*
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/search">Click here to check your registration</A>
			</P>
			*/ ?>
			
			<P class="f60">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
			<P class="f50">
				<?= $BrandingMaintainer ?>
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>


