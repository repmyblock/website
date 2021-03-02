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
		
	<P CLASS="BckGrndElement">PETITIONING DURING COVID-19</P>


	<P CLASS="BlueBox">
		<A HREF="/exp/<?= $middleuri ?>/candidateinfo" class="w3-button w3-bar-item w3-blue w3-hover-text-red BlueBox">HELP YOUR FAVORITE CANDIDATE ON THE BALLOT!<BR>DOWNLOAD AND SIGN THEIR PETITION FROM YOUR HOME.</a>
	</P>
	
	
	<P>
		To use the RepMyBlock petition engine, you need to be with two <I>(or more)</I> members of the same party at the same address 
		and a printer. One member signs the petition while the other member witness. After that, we work with 
		the campaigns to arrange for you to mail it to them or volunteer to come and pick them up. <B>All you have to do is slip it under the door.</B>
	</P>
	
	<P>
		<P CLASS="f80 center"><A HREF="/exp/website/register">To access voters lists, register and log into the Rep My Block website</A></P>
	</P>
	
	<P CLASS="BckGrndElement">ZOOM WITH PAPERBOY LOVE PRINCE</P>

	<P>
		<B>Sal Albanese</B>, <B>Badrun Khan</B>, <B>Ben Yee</B>, <B>Vittoria Fariello</B>, and <B>Jared Rich</B> discuss with 
		Paperboy Love Prince the weaponization of the electoral process in five one-hour candids chats. These videos were 
		recorded while Paperboy Love Prince was running for congress and discovering first hand the different steps of running. 
		Those video chats' goal is to demonstrate there is hope, but it will require every voter to participate in the process 
		beyond showing up to the polls to vote. <B>Democracy depends on it!</B>
	</P>

	<P>
		<P CLASS="f80 center"><A HREF="/exp/website/training">Access to the video chats</A></P>
	</P>

	
	
	<P CLASS="BckGrndElement">REPRESENT YOUR BLOCK AT YOUR PARTY COMMITTEE</P>

	<P CLASS="BckGrndCenter">I WANT TO</P>

	<DIV>
		<A class="action-runfor" HREF="/exp/<?= $middleuri ?>/interested" CLASS="RunCC"><img class="action-runfor" src="/images/options/RunFor.png" alt="RUN FOR COUNTY COMMITTEE"></A>
		<A class="action-nominate" HREF="/exp/<?= $middleuri ?>/propose" CLASS="NomCandidate"><img class="action-nominate" src="/images/options/Nominate.png" alt="NOMINATE A CANDIDATE"></A>
	</DIV>

	<P CLASS="BlueBox">
		<A HREF="/exp/<?= $middleuri ?>/interested" class="w3-button w3-bar-item w3-blue w3-hover-text-red BlueBox">ACT NOW! PETITIONING RUNS FROM<BR>MARCH 2 TO MARCH 25, 2021.</a>
	</P>

	<BR>

	
	<P CLASS="BckGrndElement">HOW IT WORKS</P>

	<P>
		<B>The County Committee is the most basic committee of any New York party; it's their backbone.</B>
	</P>
	
	<P>	
		The County Committee is the most basic committee of any New York party; it's the backbone because it selects the local platform and 
		the candidates that will represent our values. Many registered Democrats or Republicans dont even know its existence. 
		It's the body that validates the party backroom deals. 
	</P>
	
	<P CLASS="MediaCenter">
	 <iframe width="560" height="315" src="https://www.youtube.com/embed/MnI7iBxCN4A?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</P>

	<P>
		<B>The time commitment is about 32 hours a year.</B>
	</P>
	
		<P CLASS="BckGrndElement">DOWNLOAD FORM</P>

	<P>
		<B><FONT SIZE=+1><A HREF="https://pdf.repmyblock.nyc/NYS/NYC/CRU_PreFile">NYC BOE Pre Assigned Indentification Number Application</A></FONT></B>
	</P>
		
		<P CLASS="MediaCenter">
	 <iframe width="560" height="315" src="https://www.youtube.com/embed/lDt7hQFxPB8?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</P>
		

	
	</CENTER>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
