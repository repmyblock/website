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
		
	<P CLASS="BckGrndElement">WHAT IS THE COUNTY COMMITTEE</P>

	<P>
		<B>The County Committee is the body that elects the chair of the County Chair.</B>
	</P>
	
	<P>	
		The most important job of the County Committee member is to elect the County Chair of the party 
		and select the replacement of any state assembly member that resigned. Many registered Democrats or Republicans ignore its existence. 
	</P>
	
	<P CLASS="MediaCenter">
	 <iframe width="560" height="315" src="https://www.youtube.com/embed/KtYLNV3_npk?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</P>

	<P>
		<B>The time commitment is about 32 hours every two years or about 3 minutes a day.</B>
	</P>
	
			<P CLASS="BckGrndElement">REPRESENT YOUR BLOCK AT YOUR PARTY COMMITTEE</P>

		<DIV>
		<A class="action-runfor" HREF="/exp/<?= $middleuri ?>/register" CLASS="RunCC"><img class="action-runfor" src="/images/options/RunFor.png" alt="RUN FOR COUNTY COMMITTEE"></A>
		<A class="action-nominate" HREF="/exp/<?= $middleuri ?>/propose" CLASS="NomCandidate"><img class="action-nominate" src="/images/options/Nominate.png" alt="NOMINATE A CANDIDATE"></A>
	</DIV>

	<P CLASS="BlueBox">
		<A HREF="/exp/<?= $middleuri ?>/interested" class="w3-button w3-bar-item w3-blue w3-hover-text-red BlueBox">ACT NOW! PETITIONING RUNS FROM<BR>FEBRUARY 2022 TO MARCH 2022.</a>
	</P>

	<BR>

		
	<P CLASS="BckGrndElement">HOW IT REALLY WORKS</P>


	<P CLASS="MediaCenter">
	 <iframe width="560" height="315" src="https://www.youtube.com/embed/MnI7iBxCN4A?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</P>
	
	<P>
		<P CLASS="f80 center"><A HREF="/exp/<?= $middleuri ?>/register">To access voters lists, register and log into the Rep My Block website</A></P>
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
		<P CLASS="f80 center"><A HREF="/exp/website/training">Access the video chats</A></P>
	</P>


	
	
	</CENTER>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
