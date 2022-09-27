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
			<h1 CLASS="intro">Rep My Block is a non partisan website.</H1>
		</P>
		
		<P CLASS="f40">
			<B>
				Rep My Block is a non-partisan effort to collect, organize and make 
				accessible the full membership of the county committees in New York State. 
				New York State's county committees are the basis of local government and 
				are made up of publicly elected representatives. However, county committee 
				membership information has traditionally been hard to access. 
			</B>
		</P>
	</DIV>
	
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