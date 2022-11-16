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
			<h1 CLASS="intro">HOW TO RUN FOR COUNTY COMMITTEE</H1>
		</P>
		
		<P CLASS="f40">
			The process to run for County Committee is the same as other positions 
			in New York State. Running for President of the United States, City Council, 
			or County Committee follow the same process. 			
		</P>
		
		<P CLASS="f40">
			Rep My Block strives to simplify the process of running through a streamlined 
			petitioning process from other antiquated options in use for decades.
		</P>		
	</DIV>
	
	<H2>Yes, I want to run</H2>
	
	<P CLASS="f40 justify">
		The first step is merely saying, I am doing it. The process is designed  
		to dissuade people from running through a convoluted process. We built this website to 
		streamline the process to remove as many obstacles as possible that prevent everyday 
		citizens from running.
	</P>
	
	<P CLASS="f40 justify">
		The party, like any Non-Profit Organization or For-Profit Corporation, has bylaws. 
		You can find the bylaws of the various Democratic, Republican, Conservative and Working 
		Families Parties County Committee at the Board of Election. 
		<I>(We are working on getting the Bylaws from the other parties, and we will publish 
	them as soon as we have them.)</I>
	</P>
	
	<DIV class="videowrapper center">
			<iframe src="https://www.youtube.com/embed/MgAY-Ipyk1Q?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register to Run</A></P>

	<H2>Voter Registration Verification</H2>

	<P CLASS="f40 justify">
		Congratulations, youve  decided to run! Before you start, we need to verify 
		that your voter registration with the Board of Election is valid and correct. 
		Through Rep My Block you can verify that you are registered in an electoral 
		party based on your convictions.

	</P>
	
	<P CLASS="f40 justify">
		If you are not registered to vote or are not registered in a party, you can 
		<A HREF="https://vote.nyc/page/register-vote" TARGET=NEW>download and 
		print a form</A> or go to the 
		<A HREF="https://dmv.ny.gov/more-info/electronic-voter-registration-application" TARGET="NEW">DMV website</A> 
		and register. 
	</P>
	
		
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register to Run</A></P>
	
	<H2>Petitioning</H2>
	
	<P CLASS="f40 justify">
		This step is <?= $ImportantDates["NY"]["CycleLength"] ?> days long in <?= $ImportantDates["NY"]["Cycle"] ?>, 
		it will span from <?= $ImportantDates["NY"]["LongDate"]["FirstPetitionDay"] ?>, 
		to <?= $ImportantDates["NY"]["LongDate"]["LastPetitionDay"] ?>.  
		Rep My Block will supply a list of registered voters in your district. 
	</P>

	<DIV class="videowrapper center">
	 <iframe src="https://www.youtube.com/embed/cizp2jVf-Yk?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	
	<P CLASS="f40 justify">
		Contrary to the conventional way of collecting signatures, you won't need to stop 
		random voters in the street,  but knock on your neighbors' doors. Our  Walk Sheets are organized 
		by building by building. We eliminate the need to collect three times the amount of signatures in 
		the hope of collecting enough valid signatures <I>(defined by office and district)</I>. This alone 
		saves time and energy. Rep My Block petitions have already earned reliability status by 
		holding up in challenges.
	</P>	
	
	<DIV class="videowrapper center">
		 <iframe src="https://www.youtube.com/embed/XUGFbBCcIS4?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register to Run</A></H2></CENTER></P>

	<H2>Prepare for Filing</H2>
	
	<P CLASS="f40 justify">
		After collecting the required number of signatures, you must bind the petitions according to the 
		New York State Board of Elections' stringent and detailed rules. 
	</P>

	<P CLASS="f40 justify">
		Rep My Block is composed of hundreds of volunteers that have done the process. If you have any 
		questions, a volunteer will be able to answer you put them together.	
	</P>

	<DIV class="videowrapper center">
		<iframe src="https://www.youtube.com/embed/9GfIm72Ksz0?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register to Run</A></P>
	
	<H2>Filing with the BoE</H2>

	<P CLASS="f40 justify">
		Head to the Board of Election and drop off your properly bound petitions between 
		<?= $ImportantDates["NY"]["LongDate"]["FirstSubmitDay"] ?>, and 
		<?= $ImportantDates["NY"]["LongDate"]["LastPetitionDay"] ?>. 
		
	<DIV class="videowrapper center">
		<iframe src="https://www.youtube.com/embed/G0yRhVGz2TM?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	
	<P CLASS="f40 justify">
		Rep My Block is a community-based system that uses the power of the community.
		We can set up dropping points throughout the community and submit the petitions 
		for you. All you will need to do is to staple your petition together and drop 
		them at a drop-off location. Here is how to properly file your petition sheets 
		with the Board of Election.
	</P>

	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register to Run</A></P>
	
	<H2> Election Day</H2>
	
	<P CLASS="f40 justify">
		In this exciting step where you run for County Committee! Remind your neighbors to vote for 
		you on <?= $ImportantDates["NY"]["LongDate"]["PrimaryElection"] ?> <I>(be sure to collect 
			their contact info during petitioning)</I>.
	</P>
	
	<P CLASS="f40 justify">
		The night before, we suggest posting flyers around your district to remind your voters to vote for you.  	
	</P>
	
	<P CLASS="f40 justify">
		Rep My Block resources will have a few tools to help you create a quick flyer to post around your block. 
		We also explain the Department of Sanitation rules about postering.
	</P>

	<DIV class="videowrapper center">
		<iframe src="https://www.youtube.com/embed/WXRd6lF3Ix4?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register to Run</A></P>

	<H2>Success!</H2>
	
	<P CLASS="f40 justify">
		</B>Finally!</B> Finally! You spent 27 hours completing the previous six steps and are now a County Committee member. 
		<B>It is now time to attend your first meeting!</B>
	</P>

	<DIV class="videowrapper center">
		<iframe src="https://www.youtube.com/embed/ZyKD5H0y0KM?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>

	<P CLASS="f40 justify">
		By now, Rep My Block will have connected you with other County Committee members that hopefully share 
		your vision, and together you work to get your ideas across.
	</P>

	<DIV class="videowrapper center">
		<iframe src="https://www.youtube.com/embed/LqOsuibAGNw?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	
	<P CLASS="f40 justify">
		The business of the County Committee meeting is to elect the leadership of the County Party. As a committee member, you will be approached asking to support a candidate. It's the most critical part because it will dictate how the party will behave during the next two-year cycle.
	</P>
	
	<P CLASS="f40 justify">
		The business of the County Committee meeting is to elect the leadership of the County Party. 
		As a committee member, you will be approached asking to support a candidate. It's the most 
		critical part because it will dictate how the party will behave during the next two-year cycle.
	</P>
	
	<P CLASS="f40 justify">
		It's where all drama takes place. You can see what to expect at the first meeting by checking 
		the videos of those meetings.
	</P>
	
	<DIV class="videowrapper center">
		<iframe src="https://www.youtube.com/embed/wPDC_XeTbc4?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register to Run</A></P>
	
</DIV>
	
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>