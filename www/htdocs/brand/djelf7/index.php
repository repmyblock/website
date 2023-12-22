<?php
	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV class="right f80"><?= $BrandingTitle ?></DIV>
	
			<P class="f60">
				A Street Activist differs from an Armchair Activist in that we have direct experience with the 
				communities that others might claim to understand or work with. (Media pundits, celebs and astroturf 
				activists just repeat what the consensus is, as determined by those with power.) We are the 
				"hands on" component and the workers of the movement! Our knowledge is traditionally undervalued 
				and therefore underreported by media that focuses on those with money power and access. 
			</P>
			
			
			<P class="f60">
				I participate and am a member of all the groups. Democrats, Republicans, Greens, Libertarians, and more! 
				I know each group's personnel, capabilities and perspective. As a Street activist I get closer to the 
				epicenter of activity and therefore have a more accurate view of events than pundits and celebrities. 
				I have been high and I have been low. I have run businesses and had several stints of homelessness 
				since the age of 16 after running away from home. I have experienced failure and success in many fields.
			</P>

			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/search">Join the Revolution by helping candidates on the ballot</A>
			</P>

			<P class="f60">
				I hosted the only 3rd Party and Independent candidate forum/debates in NYC for the 2021 election cycle 
				In '22 I ran a program called Unified Platform 22 - Working with over 30 candidates across the nation with 
				representatives from all major and minor party lines as well as many independents I assembled a coalition 
				of candidates to create a unified agreement across a variety of policies. Individual interviews and topical 
				panel discussions were conducted to facilitate conditional work.
			</P>
			
		
				<P class="adpad center">
		<DIV class="videowrapper center">
	 		<iframe src="https://www.youtube.com/embed/M7KY6jEIdV8?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	</P>
			
			<P class="f50">
				<?= $BrandingMaintainer ?>
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>


