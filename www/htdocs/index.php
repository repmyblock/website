<?php 
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	/* User is logged */
?>

<div class="main center">

	<P CLASS="BlueBox">
		<A HREF="/<?= $middleuri ?>/training/steps/torun" class="w3-blue w3-hover-text-red">
				How to run for County Committee?<BR>Click here!
		</a>
	</P>
	
	<P CLASS="BckGrndElement f80">CANDIDATES VOLUNTEER GUIDE</P>

	<P>
		<A HREF="/<?= $middleuri ?>/exp/voter/guide">
			<H2>Download the RepMyBlock Volunteer Guide</H2>
		</a>
	</P>
	
	<P CLASS="f40">
		These candidates are running for office and are looking for volunteers to help them.
	</P>
	
	<P CLASS="BckGrndElement f80">REPRESENT YOUR BLOCK AT YOUR PARTY COMMITTEE</P>

	

		<DIV CLASS="f60">
		<A class="action-runfor" HREF="/<?= $middleuri ?>/exp/register/register" CLASS="RunCC"><img class="action-runfor" src="/images/options/RunFor.png" alt="RUN FOR COUNTY COMMITTEE"></A>
		<A class="action-runfor" HREF="/<?= $middleuri ?>/exp/propose/nomination" CLASS="NomCandidate"><img class="action-runfor" src="/images/options/Nominate.png" alt="NOMINATE A CANDIDATE"></A>
	</DIV>
	
		
	
		<BR>
	
	<P CLASS="BckGrndElement f80">WHAT IS THE COUNTY COMMITTEE</P>

	<P CLASS="f60">
		<B>The County Committee is the body that elects the chair of the County Chair.</B>
	</P>
	
	<P>
		<DIV class="videowrapper">
	 		<iframe src="https://www.youtube.com/embed/CD3dwRtVY64?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
</P>
	
		<P CLASS="f40">
		The most important job of the County Committee member is to elect the County Chair of the party and 
		select the replacement of any state assembly member that resigned.
		Many registered Democrats or Republicans ignore its existence. 
	</P>
	
	<P CLASS="f40">
		<B>The time commitment is about 32 hours every two years or about 3 minutes a day.</B>
	</P>
			
			
			
			
	
			
		
	

	
	
	
		

<P CLASS="BckGrndElement f80">VOLUNTEER TO MAKE REPMYBLOCK BETTER</P>

		<P CLASS="f40">
			<B>Rep My Block</B> is an unincorporated organization run by volunteers who donate their skills, knowledge, and resources. RepMyBlock is decentralized to avoid political filling requirements.
		</P>

		
		<P CLASS="f40">
			<B>Rep My Block</B> relies on Computer Code by volunteers from the <A HREF="https://www.progcode.org" TARGET="ProgCode">Progressive 
			Coders Network</A> repository, such as the  <A HREF="http://www.nationalvoterfile.org" TARGET="NatVoterFile">National Voter File</A> Project. 
			We also thank all the Democratic, Republican, Green, Libertarian, 
			Conservative, Socialists, and Independent candidates who have donated their time, experiences, and data.
		</P>
		
		<P>
		<P CLASS="center f80"><A HREF="/<?= $middleuri ?>/volunteer/tothecause">To volunteer your time or ressources</A></P>
	</P>
			
	</CENTER>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
