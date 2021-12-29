<?php 
	/***************************
	* File: about.php
	* Purpose: About page that explain what this software is about.
	* Author: Theo Chino
	*/
	
	$BigMenu = "home";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
	
?>


<div class="main">
	<DIV CLASS="intro center">
		<P>
			<h1 CLASS="intro">Volunteer to the cause.</H1>
		</P>
		
		<P CLASS="f60">
			<B>Rep My Block</B> is a non-partisan effort to re-organize the political process in the United States.
			</P>
			
			<P CLASS="f40">
				Everyone skills are welcome. We need writers, story tellers, actors, lawyers, phylosophers, public relations,
				data analysts, statisticians, philosophers, videographers, psychiatrists, database managers, accountants, computer engineers and 
				programmers. <B>And politicians!</B>
			</P>
			
			<P CLASS="f40">
				<B>It's important that each volunteer understanding that:</B>
				<OL>
					<LI>Everyone is welcome to donate their talent and noone will be judged for the quality of the work.</LI>
					<LI>Each donation will go into a virtual bucket for evaluation and triage.</LI>
					<LI>Each donation will be credited to the rightfull owner and the anyonymity of each volunteer will be respected.</LI>
					<LI>Each volunteer will never be required to accomplish a task on the project; except if a letter of 
						recomendation is sought.</LI>
				</OL>
			
			</P>
			
			<P>
				<H2><P CLASS="f60">Computer Programmers</P></H2>
			</P>

			<P CLASS="f40"> 
				The code for Rep My Block is on GitHub at <A HREF="https://github.com/repmyblock" TARGET="GitHub">https://github.com/repmyblock</A>. 
				Please contact us via the GitHub system.
			</P>

			
			<P CLASS="f40">
				<H2><P CLASS="f60">Psychologists, psychiatrists and philosophers</P></H2>
			</P>
			
			<P CLASS="f40">
				Running for office is taxing on the candidates mental health and a lot of work done by
				Rep My Block was to listen to the candidates. Please email us at 
				<B><A HREF="mailto:mentalhealth@repmyblock.org">mentalhealth@repmyblock.org</A></B>. If candidate
				sound or act crazy, it's because the position can push them to the brink of sanity.
			</P>
			
			<P>
				<H2>Artists, Writers, and Video producers</h2>
			</P>
			
			<P CLASS="f40">
				We need to explain the political system to regular folks from ages 4 to 99, and we need help 
				to explain it to various groups. Please write to 
				<B><A HREF="mailto:mentalhealth@repmyblock.org">artsvolunteer@repmyblock.org</A></B> if you which to volunteer.
			</P>
			
			<P>
			<H2><P CLASS="f60">Feeder projects</P></h2>
			</P>
			
			<P CLASS="f40">
				Some of the aspect of the project depend on external project such as the 
				<A HREF="https://www.nationalvoterfile.org">National Voter File</A> to organize 
				the canvassers. The National Voter file project need 3,600 volunteers to request, lobby for law change, 
				for the free access of the data file.
				<B><A HREF="mailto:feeder@repmyblock.org">voterlist@repmyblock.org</A></B> so we can connect with organizations 
				like <A HREF="https://www.progcode.org/" TARGET="progcode">Progressive Coders</A>, the local
			 	<A HREF="https://www.lwv.org/" TARGET="lwv">League of Woman Voters</A>.
			</P>
			
		</P>
	</DIV>
	
	<P CLASS="f60 center"><A HREF="/">Back to the main page</A></P>


</div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>