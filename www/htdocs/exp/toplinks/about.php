<?php 
	/***************************
	* File: about.php
	* Purpose: About page that explain what this software is about.
	* Author: Theo Chino
	*/
	
	$BigMenu = "about";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	$HeaderTwitter = 1; /* This is needed to trigger the different header */
	$HeaderTwitterPicLink = "https://static.repmyblock.org/pics/paste/AboutPageNonPartisan.jpg";
	$HeaderTwitterDesc = "Get your nominating petition kit here! The County Committee is the most basic committee of the Democratic and Republican Parties; its their backbone. The &hellip; Continue reading Rep My Block &rarr;";
	$HeaderTwitterTitle = "Create your faction inside the Democratic or Republican party.";     
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
?>
<DIV class="main_wopad">
	<DIV class="intro center">
			<DIV class="tadpad">
				<P class="BlueBox w3-blue">
			Rep My Block is a non partisan website
		</P>
	</DIV>
	</DIV>
	
	<DIV CLASS="intro">
		<P class="f40 adpad">
			Rep My Block is a non-partisan effort to collect, organize, and make accessible the membership of local party 
			rosters across the United States. The basis of good local governance is transparency at every level.
		</P>
	</DIV>
	
	<P class="BckGrndElement f80 center">THE MAJOR POLITICAL TENDENCIES</P>
	
	<P class="f40 adpad">
		The world is run by various political ideologies competing against each other. Rep My Block 
		is non-partisan; therefore, we welcome all ideologies and help them contact the local 
		representatives of those ideologies.
	</P>

  <UL class="f40 adpad">
  	<B><A TARGET="political" TARGET="political" HREF="https://www.idgroup.eu">Nationalists</A>:</B> Conservative Party USA: <A TARGET="political" HREF="https://conservativepartyusa.org">https://conservativepartyusa.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://www.idu.org">Democrat Union</A>:</B> Republican National Committee: <A TARGET="political" HREF="https://gop.com">https://gop.com</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://ialp.com">International Alliance of Libertarian Parties</A>:</B> Libertarian: <A TARGET="political" HREF="https://www.lp.org">https://www.lp.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://www.idc-cdi.com">Centrist Democrat</A>:</B> Frederick Douglass Foundation: <A TARGET="political" HREF="https://fdfnational.org">https://fdfnational.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://liberal-international.org">Liberals and centrists</A>:</B> Center for New Liberalism: <A TARGET="political" HREF="https://cnliberalism.org">https://cnliberalism.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://progressive-alliance.info">Progressive Alliance</A>:</B> Progressive Democrats of America: <A TARGET="political" HREF="https://pdamerica.org">https://pdamerica.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://socialistinternational.org">Social democrats and Socialists</A>:</B> Social Democrats of America: <A TARGET="political" HREF="https://socialists.us">https://socialists.us</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://globalgreens.org">Greens and regionalists</A>:</B> Green Party US: <A TARGET="political" HREF="https://www.gp.org">https://www.gp.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://progressive.international">Progressive International</A>:</B> Democrat Socialists of America: <A TARGET="political" HREF="https://www.dsausa.org">https://www.dsausa.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="http://www.solidnet.org">Communists and Workers' parties</A>:</B> Communist Party USA: <A TARGET="political" HREF="https://www.cpusa.org">https://www.cpusa.org</A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://internationalsocialist.net">Socialists Alternative</A>:</B> Socialist Alternative: <A TARGET="political" HREF="https://socialistalternative.org">https://socialistalternative.org</A><BR>
		<B><A TARGET="political" TARGET="political" HREF="https://ipa-aip.org">International People's Assembly</A>:</B> Party for Socialism and Liberation: <A TARGET="politital" HREF="https://pslweb.org">https://pslweb.org</A></A><BR>
    <B><A TARGET="political" TARGET="political" HREF="https://pp-international.net">Pirates Parties International</A>:</B> United States Pirate Party: <A TARGET="political" HREF="https://uspirates.org">https://uspirates.org</A><BR>
	</UL>
	
	<P class="f40 adpad">
		The RMB Code is used once you register to let the leader of these groups contact you so you can effectively 
		organize with them inside the Republican or Democratic parties of the United States.
	</P>
	
	<P class="f40 adpad">
		The goal of Rep My Block is to suppress the role of money in the political conversation while 
		respecting each individual's ideology without judgment.
	</P>
	
	<P class="BckGrndElement f80 center">ZOOM WITH PAPERBOY LOVE PRINCE</P>

	<P class="f40 adpad">
		<B>Sal Albanese</B>, <B>Badrun Khan</B>, <B>Ben Yee</B>, <B>Vittoria Fariello</B>, and <B>Jared Rich</B> discuss the 
		weaponization of the electoral process with Paperboy Love Prince in five one-hour candid chats. 
	</P>
	
	<P class="f40 adpad">
		<B><A HREF="/<?= $middleuri ?>/training/zoom/withpaperboy">These videos</A></B> were 
		recorded while Paperboy Love Prince was running for congress, and discovering first-hand, the different steps 
		involved in running for public office. The goal of these video chats is to demonstrate that there is hope, but 
		it will require every voter to participate in the political process by going beyond just showing up to the polls 
		to vote. <B>Democracy depends on it!</B>
	</P>
	
	<P class="f60 adpad">
		<P class="center f60"><A HREF="/<?= $middleuri ?>/training/zoom/withpaperboy">Access the video chats</A></P>
	</P>
	
	<P class="adpad">
		<DIV class="videowrapper center">
			<iframe src="https://www.youtube.com/embed/KtYLNV3_npk?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>	
		</DIV>
	</P>
	
	<P class="adpad">
		<P class="center f60"><A HREF="/<?= $middleuri ?>/training/zoom/withpaperboy">Access the video chats</A></P>
	</P>
	
	<P class="f80 center adpad"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></P>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
