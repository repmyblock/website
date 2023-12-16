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
				Suite au reportage de Martin Weill sur TMC, vous pouvez nous aider &agrave; New York 
				en quelques click simple.
			</P>
			

			
			<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/aide">Regardez le reportage et ensuite cliquez sur ce lien pour nous aider.</A>
			</P>
			
		
			<P>
			<DIV class="videowrapper center">
				<iframe style="overflow:hidden" frameborder="0" type="text/html" src="https://www.dailymotion.com/embed/video/x8qibw8?autoplay=1" width="100%" height="100%" allowfullscreen title="Dailymotion Video Player" allow="autoplay"></iframe>
			</DIV>
	</P>
		
				<P class="f60">
				<B>Retrouvez le reportage ici :</B>
			</P>
			
			<UL class="f60">
				<P class="f60">
					Elle vient d'&eacute;tre class&eacute;e la ville la plus ch&egrave;re du monde. 
				</P>
							
			<P class="f80"></B><A  TARGET="TMC" HREF="https://www.tf1.fr/tmc/martin-weill/videos/les-reportages-de-martin-weill-new-york-la-fin-du-reve-partie-1-94816573.html">Partie 1 : la d&eacute;mesure</A></B></P>
				<UL class="f60">
				A Manhattan, des 
				penthouses se vendent &agrave; 200 millions de dollars et les agents immobiliers 
				sp&eacute;cialis&eacute;s dans le luxe sont devenus 
				les nouveaux rois de la cit&eacute;. 
			</UL>
				
				<P class="f60">
				New York, terre d'accueil historique, serait-elle en
				train de devenir un 
				repaire pour millionnaires ? Qui peut encore croquer dans la Grosse Pomme ? 
				
			</P>
			
			<P class="f80"><B><A TARGET="TMC" HREF="https://www.tf1.fr/tmc/martin-weill/videos/les-reportages-de-martin-weill-new-york-la-fin-du-reve-partie-2-81510722.html">Partie 2 : les in&eacute;galit&eacute;s</A></B></P>
				<UL class="f60">
				De Central Park au 
				Bronx menac&eacute; par la gentrification, des th&eacute;&acirc;tres de Broadway aux refuges 
				pour SDF pleins &agrave; 
				craquer, Martin Weill a rencontr&eacute; ceux qui courent apr&eacute;s le r&ecirc;ve new-yorkais... 
				et ceux qui 
				n'y croient plus. 
				</UL>
		
		
				<P class="f60">
				Bienvenue dans la ville la plus attractive du globe mais aussi l'une des plus in&eacute;galitaires.
			</P>
			
					</UL>
		
			
			
				<P class="f80bold center">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/aide">Appuyez ici pour nous aider.</A>
			</P>
			
			
			<P class="f50">
				<?= $BrandingMaintainer ?>
			</P>

			<P class="f50">
				Rep My Block is provided Free of Charge to any candidate that wishes to integrate 
				its services.
			</P>
			
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>


