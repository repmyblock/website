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
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 	

	/* User is logged */
?>

<div class="main">
	<DIV CLASS="intro center">
		<P>
			<h1 CLASS="intro">Rep My Block is a non partisan website.</H1>
		</P>
		
		<P CLASS="f40">
				Rep My Block is a non-partisan effort to collect, organize and make 
				accessible the full membership of the county committees in New York State. 
				New York State's county committees are the basis of local government and 
				are made up of publicly elected representatives. However, county committee 
				membership information has traditionally been hard to access. 
		</P>
	</DIV>
	
	<P CLASS="BckGrndElement f80 center">THE MAJOR POLITICAL TENDENCIES</P>
	
	<P CLASS="f40">
		The world is run by various political ideologies competing against each other. Rep My Block 
		is non-partisan; therefore, we welcome all ideologies and help them contact the local 
		representatives of those ideologies.
	</P>

  <UL CLASS="f40">
  	<B>Nationalists:</B> <A TARGET="political" HREF="https://www.idgroup.eu">https://www.idgroup.eu</A> - RMB Code: idgroup<BR>
    <B>Democrat Union:</B> <A TARGET="political" HREF="https://www.idu.org">https://www.idu.org</A> - RMB Code: idu<BR>
    <B>International Alliance of Libertarian Parties:</B> <A TARGET="political" HREF="https://ialp.com">https://ialp.com</A> - RMB Code: libertarians<BR>
    <B>Centrist Democrat:</B> <A TARGET="political" HREF="https://www.idc-cdi.com">https://www.idc-cdi.com</A> - RMB Code: idccdi<BR>
    <B>Liberals and centrists:</B> <A TARGET="political" HREF="https://liberal-international.org">https://liberal-international.org</A> - RMB Code: liberal<BR>
    <B>Progressive Alliance:</B> <A TARGET="political" HREF="https://progressive-alliance.info">https://progressive-alliance.info</A> - RMB Code: progressive<BR>
    <B>Social democrats and Socialists:</B> <A TARGET="political" HREF="https://socialistinternational.org">https://socialistinternational.org</A> - RMB Code: socdems<BR>
    <B>Greens and regionalists:</B> <A TARGET="political" HREF="https://globalgreens.org">https://globalgreens.org</A> - RMB Code: greens<BR>
    <B>Progressive International:</B> <A TARGET="political" HREF="https://progressive.international">https://progressive.international</A> - RMB Code: bernie<BR>
    <B>Communists and Workers' parties:</B> <A TARGET="political" HREF="http://www.solidnet.org">http://www.solidnet.org</A> - RMB Code: solidnet<BR>
    <B>Socialists Alternative:</B> <A TARGET="political" HREF="https://internationalsocialist.net">https://internationalsocialist.net</A> - RMB Code: socalter<BR>
    <B>Pirates:</B> <A TARGET="political" HREF="https://pp-international.net">https://pp-international.net</A> - RMB Code: pirates<BR>
	</UL>
	
	<P CLASS="f40">
		The RMB Code is used once you register to let the leader of these groups contact you so you can effectively 
		organize with them inside the Republican or Democratic parties of the United States.
	</P>
	
	<P CLASS="f40">
		The goal of Rep My Block is to suppress the role of money in the political conversation while 
		respecting each individual's ideology without judgment.
	</P>
	
	<P CLASS="BckGrndElement f80 center">ZOOM WITH PAPERBOY LOVE PRINCE</P>

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
	<DIV class="videowrapper center">
		<iframe src="https://www.youtube.com/embed/KtYLNV3_npk?feature=oembed" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>	
	</DIV>
</P>
	
			<P>
		<P CLASS="center f60"><A HREF="/<?= $middleuri ?>/training/zoom/withpaperboy">Access the video chats</A></P>
	</P>

	
	<P CLASS="f80 center"><A HREF="/<?= $middleuri ?>/exp/register/register">Register on the Rep My Block website</A></P>
</div>

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>