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
	<P CLASS="BckGrndCenter">I WANT TO</P>

	<DIV>
		<A class="action-runfor" HREF="/exp/<?= $middleuri ?>/interested" CLASS="RunCC"><img class="action-runfor" src="/images/options/RunFor.png" alt="RUN FOR COUNTY COMMITTEE"></A>
		<A class="action-nominate" HREF="/exp/<?= $middleuri ?>/propose" CLASS="NomCandidate"><img class="action-nominate" src="/images/options/Nominate.png" alt="NOMINATE A CANDIDATE"></A>
	</DIV>

	<P CLASS="BlueBox">
		<A HREF="/exp/<?= $middleuri ?>/interested" class="w3-button w3-bar-item w3-blue w3-hover-text-red BlueBox">ACT NOW! PETITIONING RUNS FROM<BR>MARCH 2 TO MARCH 25, 2021.</a>
	</P>

	<BR>

	<P CLASS="BckGrndElement">DOWNLOAD FORM</P>

	<P>
		<B><FONT SIZE=+1><A HREF="<?= $FrontEndPDF ?>/NYS/NYC/CRU_PreFile">NYC BOE Pre Assigned Indentification Number Application</A></FONT></B>
	</P>
		
		<P CLASS="MediaCenter">
	 <iframe width="560" height="315" src="https://www.youtube.com/embed/lDt7hQFxPB8?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</P>
		
	
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
	
	</CENTER>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
