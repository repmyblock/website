<?php
	include "brandheader.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";

	if ( ! empty ($_POST)) {
		
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/brand/db_generic.php";	

		header("Location: /" . CreateEncoded (
														array("FirstName" => trim($_POST["FirstName"]),	
																	"LastName" => trim($_POST["LastName"]),
																	"Email" => trim($_POST["Email"]))) .
						$middleuri . "/brand/" . $BrandingName . "/findvoter");
		exit();
	}
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
?>
<DIV class="main">
		
		<DIV class="right f80"><?= $BrandingTitle ?></DIV>
	
		
		<P class="f60 p20">
			Pour nous aider, rien de plus simple :
		</P>
		
		<UL>
		<P CLASS="f80">
			<B># 1 :</B> Regardez le reportage de Martin Weill.
		</P>
		
		<P CLASS="f60">	
			<UL CLASS="f60">
				<A HREF="/<?= $middleuri ?>/brand/<?= $BrandingName ?>/index">Les liens vers le reportage.</A>
			</UL>
		</P>
	
		<P CLASS="f80">
			<B># 2 :</B> Suivre et liker ces comptes sociaux.
		</P>
		
		<P CLASS="f60">	
			<UL CLASS="f60">
				<A HREF="https://linkedin.com/company/socdemsamerica" TARGET="PDSol">LinkedIn</A>
				<A HREF="https://youtube.com/channel/UC2gELyUBFpZ61T5uZxJgV3A" TARGET="PDSol">YouTube</A>
				<A HREF="https://twitter.com/SocDemsAmerica" TARGET="PDSol">Twitter</A>
				<A HREF="https://facebook.com/SocDemsAmerica" TARGET="PDSol">Facebook</A>
				<A HREF="https://www.tiktok.com/@SocDemsAmerica" TARGET="PDSol">TikTok</A>
				<A HREF="https://instagram.com/socdemsamerica" TARGET="PDSol">Instagram</A>
				<A HREF="https://www.threads.net/@socdemsamerica" TARGET="PDSol">Threads</A>
				<A HREF="https://www.reddit.com/r/SocDemsAmerica" TARGET="PDSol">Reddit</A>
			</UL>
		</P>
		
		<P CLASS="f80">
			<B># 3 :</B> Imprimer l'affiche et la partager en section.
		</P>
		
		<P CLASS="f60">	
			<UL CLASS="f60">
				<A HREF="https://militantps.fr/appel/SolidariteNewYork.pdf" TARGET="PDSol">T&eacute;l&eacute;charger l'affiche au format PDF</A>
			</UL>
		</P>
		
		<P CLASS="f80">
			<B># 4 :</B> Demandez &agrave; des Am&eacute;ricains de s'inscrire ci-dessous.<BR>
			<UL CLASS="f60">If a French-speaking person asked you to come here, it's because they watched a documentary about the inequalities in New York City, and you can do something about it with a signature.</UL>

			<UL CLASS="f60">As an American, you can help get <A HREF="https://draftaoc.us" TARGET="AOC">AOC drafted for president in 2028</A> 
				or help get <A HREF="http://socialists.us/direct/index/socialistsforbiden" TARGET="SOCBIDDEN">Socialists delegates to the Chicago Convention</A>.
			</UL>
			
			<UL CLASS="f60"><B>Fill out the survey below</B> to check your voting registration, and we will direct you to the right place</A>.
			</UL>

		</P>
							

		
		
		
		<FORM METHOD="POST" ACTION="">			
		
		<P class="f60">
			<DIV class="f60"><B>First Name:</B></DIV> 
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="FirstName" PLACEHOLDER="First Name" VALUE="<?= $_POST["FirstName"] ?>"><DIV>
		</P>
			
		<P class="f60">
			<DIV class="f60"><B>Last Name:</B></DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="LastName" PLACEHOLDER="Last Name" VALUE="<?= $_POST["LastName"] ?>"></DIV>
		</P>
	
		<P class="f60">
			<DIV class="f60"><B>Email:</B></DIV>
			<DIV><INPUT class="" type="text" autocorrect="off" autocapitalize="none" NAME="Email" PLACEHOLDER="Last Name" VALUE="<?= $_POST["Email"] ?>"></DIV>
		</P>
		
		<P>
			<DIV><INPUT class="" TYPE="Submit" NAME="CheckRegistration" VALUE="Participate in the political process"></DIV>
		</P>
		

</UL>
		
		<P class="f80 p20">
			Voila ! Aider un am&eacute;ricain ne demandait pas grand chose. N'oubliez pas de partager le reportage.
		</P>
		
		
		<P>
			<DIV class="videowrapper center">
				<iframe style="overflow:hidden" frameborder="0" type="text/html" src="https://www.dailymotion.com/embed/video/x8qibw8?autoplay=1" width="100%" height="100%" allowfullscreen title="Dailymotion Video Player" allow="autoplay"></iframe>
			</DIV>
	</P>
		
		
		<P class="f40">
			By clicking the "Register" button, you are creating a 
			RepMyBlock account, and you agree to RepMyBlock's 
			<A HREF="/text/terms">Terms of Use</A> and 
			<A HREF="/text/privacy">Privacy Policy.</A>
		</P>

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
