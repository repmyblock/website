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
				Progressive Democrats of America is guided by the progressive vision of a renewed 
				nation, fully integrated into the community of nations and peoples, respectful of 
				the rule of law at home and abroad, and committed to the universal values of human 
				dignity, justice and respect, and stewardship of the planet on which we live.
			</P>
			
			<P class="f50">
				Progressive Democrats of America was founded in 2004 to transform the Democratic Party and our country. We seek to build a 
				party and government controlled by citizens, not corporate elites-with policies that serve the broad public 
				interest, not just private interests.
			</P>
			
			<P>
				As a grassroots organization operating inside the Democratic Party, and outside in movements for peace and 
				justice, PDA has played a key role in the rise of the progressive movement. Our inside/outside strategy is 
				guided by the belief that a lasting majority will require a revitalized Democratic Party built on firm 
				progressive principles.
			</P>
			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/search">Click here to check your registration</A>
			</P>
			
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


