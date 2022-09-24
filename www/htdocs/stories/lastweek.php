<?php
//	$imgtoshow = "/brand/RunWithMe/RunWithMe.png";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
?>
<DIV class="main">
	<DIV CLASS="left f80">We nominated John Oliver for the Manhattan County Committee</DIV>

<P CLASS="f60">
	We nominated John Oliver to the Manhattan County Committee, and we need your help to get his attention.
	<B>We ask you to leave this flyer on your chair when you leave the show.</B>
</P>

<P CLASS="f60">
	The county committee is the backbone of the Republican and Democratic parties. Their members elect the chair and the executive committee of the party. 
	<B>John Oliver is one of those members.</B>
</P>
		
<P>
	<CENTER><IMG ALT="County Comittee Postcard" SRC="/images/JohnOliverStory/CountyCommitteePostcard.jpg"></CENTER>
</P>
	
<P CLASS="f60">
	Last year, we nominated John Oliver to be a Judicial Delegate, but the party changed his name on the list.
</P>

<P>
	<CENTER><IMG ALT="County Comittee Postcard" SRC="/images/JohnOliverStory/JohnOliverJudge.jpg"></CENTER>
</P>

<P CLASS="f60">
	<B>Video:</B> What is the County Committee?
</P>

<P>
	<CENTER>
	<DIV class="videowrapper">
		<iframe src="https://www.youtube.com/embed/KtYLNV3_npk" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</DIV>
	</CENTER>
</P>

<P CLASS="f60">
	<A HREF="https://www.cityandstateny.com/politics/2022/09/brooklyn-dems-meeting-cut-short-amid-disorganization-and-delays/377500">This article by City and State explains how dysfunctional the party is when organizing the meeting.</A>
</P> 

<P CLASS="f60">
	We need John Oliver to witness the process in person, and we need your help to get his attention.
</P> 

<P CLASS="f80">
	And wherever you are in the United States, please consider joining your local County 
	Committee <I>(or whatever name your County gives to that body.)</I> Email us, and we'll help you.
</P> 

<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>