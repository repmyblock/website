<?php 
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }

	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	/* User is logged */
?>

<div class="main_wopad center">

	<DIV class="tadpad">
		<P class="BlueBox">
			<A HREF="/<?= $middleuri ?>/training/steps/torun" class="w3-blue w3-hover-text-red">
				Click here to learn how to run for County Committee member, Precinct Committee Officer or Precint Committee Person.
				<?php /* <BR>Click here! - Deadline March 31<SUP>st</SUP>, 2023. */ ?>
			</a>
		</P>
	</DIV>
	
	<P class="BckGrndElement f80">WATCH COUNTY</P>
	
	<P class="f40 adpad">
		<B>COUNTY:</B> A Documentary (2022) - A documentary that explores the County Committee 
		political machine in New York City, suppression at the local levels of American
		 democracy, and the activists on the ground seeking to reform the system. 
		 A short documentary by <A HREF="https://www.imdb.com/title/tt20049084/" TARGET="other">Fahim Hamid</A>.
	</P>
	
	<P class="center f80 adpad"><A class="action-runfor" HREF="/<?= $middleuri ?>/exp/register/movie">Watch COUNTY: A Documentary</A></P>

	<P class="adpad">
		<CENTER>
			<A class="action-runfor" HREF="/<?= $middleuri ?>/exp/register/movie"><IMG SRC="/images/documentary/CountyDocumentary.png"></A>
		</CENTER>
	</P>
		
	<P class="BckGrndElement f80">CANDIDATES VOLUNTEER GUIDE</P>

	<P class="f40 adpad">
		<A HREF="/<?= $middleuri ?>/exp/voter/guide">
			<H2>Download the RepMyBlock Volunteer Guide</H2>
		</a>
	</P>
	
	<P class="f40 adpad">
		These candidates are running for office and are looking for volunteers to help them.
	</P>
	
	<P class="BckGrndElement f80">REPRESENT YOUR BLOCK AT YOUR PARTY COMMITTEE</P>

	<DIV class="f60 adpad">
		<A class="action-runfor" HREF="/<?= $middleuri ?>/exp/register/register" class="RunCC"><img class="action-runfor" src="/images/options/RunFor.png" alt="RUN FOR COUNTY COMMITTEE"></A>
		<A class="action-runfor" HREF="/<?= $middleuri ?>/exp/propose/nomination" class="NomCandidate"><img class="action-runfor" src="/images/options/Nominate.png" alt="NOMINATE A CANDIDATE"></A>
	</DIV>
	
	<BR>
	
	<P class="BckGrndElement f80">WHAT IS THE COUNTY COMMITTEE</P>

	<P class="f60 adpad">
		<B>The County Committee is the body that elects the party county chair.</B>
	</P>
	
	<P class="adpad">
		<DIV class="videowrapper">
	 		<iframe src="https://www.youtube.com/embed/CD3dwRtVY64?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
</P>
	
		<P class="f40 adpad">
		The most important responsibilities of a county committee member are to elect the chairperson of the party and to select a replacement for any state assembly member that
		resigns or that can no longer fulfill their duties as an assembly member. 
	</P>
	
	<P class="f40 adpad">
		<B>The time commitment is about 32 hours every two years or about 3 minutes a day.</B>
	</P>

	<P class="BckGrndElement f80">VOLUNTEER TO MAKE REPMYBLOCK BETTER</P>

		<P class="f40 adpad">
			<B>Rep My Block</B> is an unincorporated organization run by volunteers who donate their skills, knowledge, 
			and resources. RepMyBlock is decentralized to avoid political filling requirements.
		</P>

		
		<P class="f40 adpad">
			<B>Rep My Block</B> relies on Computer Code by volunteers from the <A HREF="https://www.progcode.org" TARGET="ProgCode">Progressive 
			Coders Network</A> repository, such as the  <A HREF="http://www.nationalvoterfile.org" TARGET="NatVoterFile">National Voter File</A> Project. 
			We also thank all the Democratic, Republican, Green, Libertarian, 
			Conservative, Socialists, and Independent candidates who have donated their time, experiences, and data.
		</P>
		
		<P>
		<P class="center f80 adpad"><A HREF="/<?= $middleuri ?>/volunteer/tothecause">To volunteer your time or resources</A></P>
	</P>
			
	</CENTER>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
