<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 	
	
	
	preg_match('/\/ltr\/(.*)/', $_SERVER['REQUEST_URI'], $matches);
	$FindInfoDB = $matches[1];

	$Dear = "Hello";
	if ( ! empty ($FirstName)) {
		$Dear = "Dear " . $FindInfoDB;
	}
	//	/ltr/AXKDJFD
	
?>
<div class="main">
	<div class="row">
		
	<P CLASS="f80"><B><?= $Dear ?>,</B></P>

	<UL>
	
	<P CLASS="f60">
		My name is Theo Chino, and I found your information in the Democratic Party 
		database, the New York City Voter database, and various commercial databases.
	</P>
	
	<P CLASS="f60">
		I am writing because I would like to ask you <B>to run</B> and represent your block 
		as a member of the board of <B>the Democratic Party</B> in your borough.
		<I>(If you live in Brooklyn, Queens, or the Bronx.)</I>
	</P>
	
	<P CLASS="f60">
		The position I would like you to run for is to be a member of the  
		Democratic Party County Committee.
	</P>
	
	<P CLASS="f60">
		The minimum commitment is one meeting every two years. <B>The time commitment 
		per	year is about 32 hours.</B> That commitment includes learning about 
		it, gathering the documentation, and participating at that meeting.
	</P>
	
	<P CLASS="f60">
		<B>The only thing you will have to do is select the leadership 
		of the party in your county.</B> Choosing the right leader will ensure 
		that we have an inclusive party that represents the diversity of our city.
	</P>

	<P CLASS="f60">
		<B>WNYC produced this guide to power a few years ago.</B> It does explain
		what the County Committee is.
	</P>
	
	<P>
		<CENTER><iframe width="560" height="315" src="https://www.youtube.com/embed/MnI7iBxCN4A" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></CENTER>
	</P>
	
	<P CLASS="f60">
		<B>We have built the website Rep My Block to simplify the process of running.</B> 		
	</P>
	
	<P CLASS="f60">
		To represent 
		your block, you need to ask about 30 of your neighbors to sign a petition. 
	<P>
	
	<P CLASS="f60">
		<B>When you register on the RepMyBlock website:</B>
		<BR>
			* you will be able to verify that your voter registration is current, <BR>
			* you will be able to download a legal petition that you will print at home and,<BR>
			* download a walk sheet of the Democrats in your neighborhood who can sign the petition.<BR>
	</P>
		
	<P CLASS="f60">
		Currently, the Democratic party board is held by lawyers that want to be judges, 
		aspirants to politicals offices, and retirees. These are the members 
		of the party deciding for all of us.
	</P>
	
	<P CLASS="f60">
		We need all the members of the community from all professional bodies; 
		architects, computers, scientists, 
		physicians, journalists, writers, artists, bodegueros, 
		small business owners, tenants, landlords, police officers, firefighters, 
		secretaries, executives, students to represent us.
	</P>
	
	<P CLASS="f60">
		If you are not interested, please share this message 
		with a neighbor that would.
	</P>
	
	<P CLASS="f60">
		The deadline for submitting the signatures is March 30<SUP>th</SUP>, 2020. 
	</P>
	
	<P>
		<FONT SIZE=+2><B><A HREF="https://repmyblock.nyc/get-involved/interested">Visit the RepMyBlock website</A></B></FONT>
	</P>
	
	<P>
		Regards,<BR>
		Theo Chino<BR>
		<I>(718) 701.0140</I>
	</P>

</DIV>
</DIV>

<?php
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; 
?>
