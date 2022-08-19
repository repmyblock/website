<?php 
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	/* User is logged */
?>

<div class="main">
	<CENTER>
	<P CLASS="BlueBox">
		<A HREF="/<?= $middleuri ?>/training/steps/torun" class="w3-blue w3-hover-text-red">
				How to run for County Committee?<BR>Click here!
		</a>
	</P>
	
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
			
			
	<P CLASS="BckGrndElement f80">CANDIDATES VOTER GUIDE</P>

	<P>
		<A HREF="/<?= $middleuri ?>/exp/voter/guide">
			<H2>Download the New York State RepMyBlock Voter Guide</H2>
		</a>

		
	</P>
			
		
	<P CLASS="BckGrndElement f80">REPRESENT YOUR BLOCK AT YOUR PARTY COMMITTEE</P>

	

		<DIV CLASS="f60">
		<A class="action-runfor" HREF="/<?= $middleuri ?>/exp/register/register" CLASS="RunCC"><img class="action-runfor" src="/images/options/RunFor.png" alt="RUN FOR COUNTY COMMITTEE"></A>
		<A class="action-runfor" HREF="/<?= $middleuri ?>/exp/propose/nomination" CLASS="NomCandidate"><img class="action-runfor" src="/images/options/Nominate.png" alt="NOMINATE A CANDIDATE"></A>
	</DIV>
	
		<BR>

	
	
	<P CLASS="BckGrndElement f80">ZOOM WITH PAPERBOY LOVE PRINCE</P>

	<P CLASS="f40">
		<B>Sal Albanese</B>, <B>Badrun Khan</B>, <B>Ben Yee</B>, <B>Vittoria Fariello</B>, and <B>Jared Rich</B> discuss the 
		weaponization of the electoral process with Paperboy Love Prince in five one-hour candid chats. These videos were 
		recorded while Paperboy Love Prince was running for congress, and discovering first-hand, the different steps 
		involved in running for public office. The goal of these video chats is to demonstrate that there is hope, but 
		it will require every voter to participate in the political process by going beyond just showing up to the polls 
		to vote. <B>Democracy depends on it!</B>
	</P>
	
	<P>
		<P CLASS="center f60"><A HREF="/<?= $middleuri ?>/training/zoom/withpaperboy">Access the video chats</A></P>
	</P>
	
		<P>
	<DIV class="videowrapper">
	 		<iframe src="https://www.youtube.com/embed/KtYLNV3_npk?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
</P>
	
			<P>
		<P CLASS="center f60"><A HREF="/<?= $middleuri ?>/training/zoom/withpaperboy">Access the video chats</A></P>
	</P>

	
	<P CLASS="BckGrndElement f80">THE STRUCTURE OF THE COUNTY COMMITTEE</P>
	<P CLASS="f40">	
		<B>Ben Yee</B> present the Stucture of the Manhattan County Committee. There are slight different from one county to the other, but the basic 
		logic is the same. If you are outside New York, you can find the process by googling <B>"County Chair"</B> and the name of your party.
	</P>
	
	<P>
	<DIV class="videowrapper">
	 <iframe width="560" height="315" src="https://www.youtube.com/embed/MgAY-Ipyk1Q?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	</P>
	
	<P>
		<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">To access voters lists, register and log into the Rep My Block website</A></P>
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
