<?php 
	$BigMenu = "represent";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/DeadlineDates.php";	

	/* User is logged */


?>


<div class="main">
	<DIV CLASS="intro center">
		<P>
			<h1 CLASS="intro">I WANT TO RUN FOR COUNTY COMMITTEE</H1>
		</P>
		
		<P CLASS="f40">
			The process to run for County Committee is the same as other positions 
			in New York State. Running for President of the United States, City Council, 
			or County Committee follow the same process. 			
		</P>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></P>

	<H2>The First Step</H2>
	
		<P CLASS="f40 justify">
			The first step is merely saying, "I am doing it." The process will not make much sense, but everything is like that to dissuade people 
			from running. We built this website to streamline the process to remove all the hoops from running.
		</P>
		
		<P CLASS="f40 justify">
			The party, like any Non-Profit Organisation or For-Profit Corporation, has bylaws. You can find the bylaws of the various Democratic, 
			Republican, Conservative and Working Families Parties County Committee at the Board of Election. 
			<I>(We are working on getting the Bylaws from the other parties, and we will publish them as soon as we have them.)</I>
		</P>
		
		<DIV class="videowrapper">
			<CENTER>
				<iframe src="https://www.youtube.com/embed/MgAY-Ipyk1Q?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</CENTER>
		</DIV>
		
		<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></P>
	



	<H2>The Second Step</H2>
	

		<P CLASS="f40 justify">
			You have decided to run, <B>congratulation!</B>
			Before you start, we need to ensure that your voter registration with the board of election is correct. 
			You will require that you are registered in an electoral party based on your convictions.
		</P>
		
		<P CLASS="f40 justify">
			If you are not registered to vote or are not registered in a party, you can print a form or go to the DMV website and register. 
		<B>You can verify your registration automatically on the Rep My Block website.</B>
		</P>
		
			
		<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></P>



	<H2>The Third Step</H2>
	
		
	<P CLASS="f40 justify">
		This step is <?= $ImportantDates["NY"]["CycleLength"] ?> days long, and in <?= $ImportantDates["NY"]["Cycle"] ?>, 
		it will start on <?= $ImportantDates["NY"]["LongDate"]["FirstPetitionDay"] ?>, 
		and it ends on <?= $ImportantDates["NY"]["LongDate"]["LastPetitionDay"] ?>.  
		Rep My Block will supply a list of registered voters in your district. 
	</P>
	

	<DIV class="videowrapper">
			<CENTER>
	 <iframe src="https://www.youtube.com/embed/cizp2jVf-Yk?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</CENTER>
	</DIV>
	
	<P CLASS="f40 justify">
		Contrary to the presidential petitioning, won't need to stop random voter in the street but knock on your neighbors' doors. 
		The Rep My Block website has the walk sheet that is organized by streets. 
	</P>	
	
	<DIV class="videowrapper">
			<CENTER>
		 <iframe src="https://www.youtube.com/embed/XUGFbBCcIS4?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</CENTER>
		</DIV>
	

	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></H2></CENTER></P>



	<H2>The Fourth Step</H2>
	
	<P CLASS="f40 justify">
		Once you have collected the required numbers of signatures, you will need to bind the petitions according to the New York State Board of Elections' stringent rules.
	</P>

	<P CLASS="f40 justify">
		Rep My Block is composed of hundreds of volunteers that have done the process. If you have any questions, a volunteer will be able to answer you put them together.
	</P>

	

	<DIV class="videowrapper">
			<CENTER>
	 <iframe src="https://www.youtube.com/embed/9GfIm72Ksz0?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</CENTER>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></P>

	
	


	<H2>The Fifth Step</H2>
	
	
	<P CLASS="f40 justify">
		This step is where you go to the Board of Election to drop your petitions between 
		<?= $ImportantDates["NY"]["LongDate"]["FirstSubmitDay"] ?>, and <?= $ImportantDates["NY"]["LongDate"]["LastPetitionDay"] ?>. 

	
	<DIV class="videowrapper">
			<CENTER>
	 <iframe src="https://www.youtube.com/embed/G0yRhVGz2TM?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</CENTER>
	</DIV>
	
	<P CLASS="f40 justify">
		Rep My Block is a community-based system that uses the power of the community. We will setup dropping points throughout the 
		community and submit the petition for you. 
		All you will need to do is to staple your petition together and drop them at a drop off location. 
	</P>

	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></P>
	
		


	<H2>The Sixth Step</H2>
	
	
	<P CLASS="f40 justify">
		This step is the exciting step where you run for County Committee, and you remind your neighbors to vote for you on <?= $ImportantDates["NY"]["LongDate"]["PrimaryElection"] ?>.
	</P>
	
	<P CLASS="f40 justify">
		The night before, we sugest that you put some flyers around your neighborhood to remind your voters to vote for you.
	</P>
	
	<P CLASS="f40 justify">
		Rep My Block resources will have a few tools to help you create a quick flyer to put around your block and explain 
		the Department of Sanitation rules regarding those flyers.
	</P>

	
	<DIV class="videowrapper">
			<CENTER>
	 <iframe src="https://www.youtube.com/embed/WXRd6lF3Ix4?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</CENTER>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></P>



	<H2>The Seventh Step</H2>
	
	
	<P CLASS="f40 justify">
		</B>Finally!</B> You spend 27 hours completing the previous six steps. <B>It is now time to attend your first meeting!</B>
	</P>

	<DIV class="videowrapper">
			<CENTER>
	 <iframe src="https://www.youtube.com/embed/ZyKD5H0y0KM?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</CENTER>
</DIV>


	<P CLASS="f40 justify">
		Rep My Block will have contacted you with other County Committee members that hopefully share your vision, and 
		<B>you will need to work together to get your ideas across.</B>
	</P>

	<DIV class="videowrapper">
			<CENTER>
	 <iframe src="https://www.youtube.com/embed/LqOsuibAGNw?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</CENTER>
	</DIV>
	
	<P CLASS="f40 justify">
		The business of the County Committee meeting is to elect the leadership of the County Party. As a committee member, you will be approached asking to support a candidate. It's the most critical part because it will dictate how the party will behave during the next two-year cycle.
	</P>
	
	<P CLASS="f40 justify">
		<B>It's where all drama takes place.</B> You can see what to expect at the first meeting
		by <A HREF="https://www.revolutions.nyc/expectations/WhatToExpect.pdf">checking out 
		the flyer distributed</B> at the last Manhattan meeting.
	</P>
	
	<DIV class="videowrapper">
			<CENTER>
	 <iframe src="https://www.youtube.com/embed/wPDC_XeTbc4?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</CENTER>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></P>




<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>