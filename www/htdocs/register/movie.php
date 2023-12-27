<?php
  
  $HeaderTwitter = 1;
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/DeadMembers.jpg";
	$HeaderTwitterDesc = "Are you alive? Don't let dead committee members decide for you. Watch the documentary!";   
	$HeaderTwitterTitle = "Watch the full documentary 'County' on the Rep My Block website.";   
	
	$HeaderOGImage = $HeaderTwitterPicLink;
	$HeaderOGDescription = $HeaderTwitterDesc;
	$HeaderOGImageWidth = "450";
	$HeaderOGImageHeight = "265";
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	
	switch($k) { 
		case "invalidcode": 
		case "emailreg": 
			$oldk = $k;
			$k = "web";
		break;
	}
		

	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
		

	$EmailCode = "NOTIF@REPMYBLOCK.ORG";
	
	if ( $k != "web") {
		// Check for the team.
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_login.php";
		$r = new login();	
		$result = $r->CheckForValidityOfTeam($k);	
		
		WriteStderr($result, "Result Validity Team");
		
		if ( $result["Team_Active"] == "yes")  {
			$MailToTextToAdd = " for team " . $k;
			$MailURLText = " FOR TEAM <FONT COLOR=BLUE>" . $k . "</FONT>";
			
			if ( ! empty ($result["Team_EmailCode"])) {
				$EmailCode = $result["Team_EmailCode"];
			}
			
		}
	}
	
	$MailToText = "mailto:" . $EmailCode . "?" . 
								"subject=I want to register" . $MailToTextToAdd;

	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
								 
	$MailToText .= "&body=DO NOT CHANGE THE SUBJECT. Just send the email as is for the computer to reply with the link.";
								
	$MultipleMailToText = "mailto:infos@repmyblock.org?" . 
								"subject=Multiple users for one account&" . 
								"body=Please enable the multipleusers for one account feature.";							
?>
<DIV class="main">
		
	<P>
		<DIV class="right f80">Watch the documentary</DIV>
	</P>
	
	<?php switch($oldk) { 
		case "invalidcode": ?>
		
		<P class="f60">
			<B><FONT COLOR=brown>The code you were given is invalid.</FONT></B> 
		</P>
		
		
		<P class="f40">	
			In order to use the RepMyBlock website you must register by sending an email
			and following the registration process.
		</P>
		
	<?php break;
		case "emailreg": ?>
		
		<P class="f60">
			<B><FONT COLOR=brown>That email address is already in our database.</FONT></B> 
		</P>
		
		
		<P class="f40">	
			Use the <A HREF="/<?= $k ?>/exp/forgot/forgotpwd">forgot my password</A> or the 
			<A HREF="/<?= $k ?>/exp/forgot/forgotuser">forgot the username</A> screen to 
			retreive your information.
		</P>
		
		<P class="f40">	
			If two people in the same household use the same email, send us an email 
			at <A HREF="<?= $MultipleMailToText ?>">infos@repmyblock.org</A></B> to enable 
			the <B>multiple users under same email</B> feature.
		</P>
		
	<?php break; 
	} ?>
	
	<P class="f40">
		<B>COUNTY: A Documentary (2022)</B> - A documentary that explores the County Committee political 
		machine in New York City, suppression at the local levels of American democracy, and the activists 
		on the ground seeking to reform the system. A short documentary by <A HREF="https://www.imdb.com/title/tt20049084/" TARGET="COUNTYMOVIE">Fahim Hamid</A>.
	</P>
	
	<P class="f60">
		<CENTER><P CLASS="f40"><B>Press the PLAY button and enter the password </B><I>(all in uppercase)</I><B> <FONT COLOR=BROWN><B>QCC4ALL</B></FONT> to access the documentary.</B></P></CENTER>
	</P>
		
	
	
	<P>		
		<CENTER>
			<DIV class="videowrapper">
				<script src="https://fast.wistia.com/embed/medias/qmt1psxdt4.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_embed wistia_async_qmt1psxdt4" style="height:360px;position:relative;width:640px"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/qmt1psxdt4/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div>			
			</DIV>		
		</CENTER>
	</P>
	
	<P><BR><BR></P>
	
	<?php /*
	<P>		
		<CENTER>
			<DIV class="videowrapper">
				<script src="https://fast.wistia.com/embed/medias/qmt1psxdt4.jsonp" async></script>
				<script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>
				<div class="wistia_embed wistia_async_qmt1psxdt4 videoFoam=true" style="position:relative;">
					<div class="wistia_swatch" style="left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;">
						<img src="https://fast.wistia.com/embed/medias/qmt1psxdt4/swatch" style="filter:blur(5px);object-fit:contain;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" />
					</div>
				</DIV>
			</DIV>		
		</CENTER>
	</P>
	

	
	<P>		
		<CENTER>
			<DIV class="videowrapper">
				<iframe title="vimeo-player" src="https://player.vimeo.com/video/795649609?h=a303d838a9" width="640" height="360" frameborder="0" allowfullscreen></iframe>
			</DIV>		
		</CENTER>
	</P>
	
	*/ ?>
	
	<P class="f40">
		Please follow the film on <B><A HREF="https://www.facebook.com/countyfilm" TARGET="COUNTYMOVIE">Facebook</A></B> and <B><A HREF="https://www.instagram.com/county_film/">Instagram</A></B>
		for news, upcoming live screenings & events. Consider donating to the movies' <B><A HREF="https://www.gofundme.com/f/county-film" TARGET="COUNTYMOVIE">go fund me</A></B> page.
	</P>
	
	<P class="f60">
			<A HREF="<?= $MailToText ?>">If you are inspired and have a few hours to help <B><font color="BROWN"><?= $result["Team_Name"] ?></FONT></B> members
			get on the ballot, click on this link to open you mail program or
			send an email to <B><?= $EmailCode ?></B> with the subject "<FONT COLOR=BROWN><B>I WANT TO REGISTER<?= $MailURLText ?></B></FONT>"</A>
			and you will receive a link with the registration information.
	</P>
	
	<P class="f40">
		Don't forget to check <B>your SPAM folder</B> for the registration email from us.
	</P>
	
	
	<P class="f40">
		If you made several requests, <A HREF="/<?= $middleuri ?>/contact/investigate">click here to alert us 
		and we will investigate</A>.
	</P>
	
	<P class="f40">
		By clicking the "Register" button, you are creating a 
		RepMyBlock account, and you agree to RepMyBlock's 
		<A HREF="/<?= $middleuri ?>/policies/terms">Terms of Use</A> and 
		<A HREF="/<?= $middleuri ?>/policies/privacy">Privacy Policy.</A>
	</P>

	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>