<?php 
	$BigMenu = "contact";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
	
?>
<div class="main_wopad">
	<DIV class="intro center">
		<DIV class="tadpad">
		<P class="BlueBox w3-blue">Contact Us</P>
	</DIV>
</DIV>

		
		<P class="BckGrndElement f80 center">CONTACT</P>
		
		<P class="f40 adpad">
			Please email 	<B><A HREF="mailto:infos@repmyblock.org">infos@repmyblock.org</A></B> for general inquiries.
		</P>
		

		
		<P class="BckGrndElement f80 center">MISSING RACES OR CANDIDATES</P>
		
		<P class="f40 adpad">
			Please email us at <B><A HREF="mailto:voterguide@repmyblock.org">voterguide@repmyblock.org</A></B> with any information you have, such as a copy of the ballot, 
			a link to your local Board of Elections, or other relevant election resources.
		</P>
		<P class="f40 adpad">
			
			We rely on data collected by volunteers. If you would like to help as a local contact, please complete the 
			<A HREF="https://voterfiles.org">Volunteer Survey</A> for the  <A HREF="https://voterfiles.org">National Voter File</A> Project.

		
		</P>
		

			<P class="BckGrndElement f80 center">VOLUNTEER TO MAKE REPMYBLOCK BETTER</P>

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
							

</DIV>
	


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
