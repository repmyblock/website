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
				We are members of the Queens Democratic County Committee working to make this elected body more 
				democratic, transparent, inclusive, accountable, and accessible.
			</P>
			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/search">Click here to check your registration</A>
			</P>
		
			<P class="f60">
				<B>Please note:</B> We're not experts. QCC4All members are just people like you who
				decided to run and pieced together the rules--which can change at any minute. But
				this process is supposed to be open to grassroots voters and that's why we all need to
				participate--to grow democracy and have our voices heard in the Party, which makes
				so many crucial decisions in Queens.
			</P>
			
			<P>
				<A HREF="/brand/<?= $BrandingName ?>/HowToRunForCountyCommittee.pdf">Download the informal guide</A> <I>(created Jan 3rd 2020)</I>
			</P>
			
			<P class="f50">
				Watch this 26 minutes documentary that explains what it means to be part of the governance of the County Democratic party.
			<B><A HREF="/<?= $middleuri ?>/register/movie">Click here to watch the whole documentary.</A></B>
				<I>(Press the PLAY button and enter the password (all in uppercase) <FONT COLOR=BROWN><B>QCC4ALL</B></FONT> to access the documentary.)</I>
			</P>
			
			<P class="f50">
				<?= $BrandingMaintainer ?>
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>


