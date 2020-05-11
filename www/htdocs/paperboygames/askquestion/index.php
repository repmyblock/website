<?php

	if ( ! empty ($_POST)) {
		require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	  require $_SERVER["DOCUMENT_ROOT"] . "/../statlib/Config/Vars.php";
		require $_SERVER["DOCUMENT_ROOT"] . "/../libs/funcs/general.php";
		require $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_rmppublic.php";

		$r = new RMBPublic();
		
		### I need to check the username and password.
		$resultPass = $r->InsertQuestions($_POST["FirstName"], $_POST["LastName"], $_POST["Zipcode"], 
																			$_POST["Email"], $_POST["Question"]);
	
		header("Location: saved");
		exit();
		
	}



	$imgtoshow = "/RunWithMe/RunWithMe.png";
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php"; 
	if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
	} else { $TypeEmail = "text"; $TypeUsername = "text"; }
		
		
	
	
?>
<DIV class="main">
	<DIV CLASS="right f80"><FONT SIZE=+3>Paperboys Games</FONT></DIV>
			
			<BR>
			
	<P>
		The Paperboy Games is a mix of artistery and political debates where every candidate is given a
		chance to debate publicly their oponent. This is a service offered to every candidates running f
		or office in New York City. The goal is to give a voice to every local candidate and also be entertaining.
	</P>
	
	<P>
		<B>
			To ensure that the questions are from constituent, we verify your voter 
			registration. Your information will be given to each of the candidates.</B>
	</P>
	
		<FORM ACTION="" METHOD="POST">
			
	<P>
		FirstName: <INPUT TYPE="TEXT" NAME="FirstName" SIZE=20>
		LastName: <INPUT TYPE="TEXT" NAME="LastName" SIZE=20><BR>
		Register Address Zipcode: <INPUT TYPE="TEXT" NAME="Zipcode" SIZE=10>
		Email Address: <INPUT TYPE="TEXT" NAME="Email" SIZE=20><BR>
		<textarea cols=50 rows=4 NAME="Question"></textarea><BR>
		<INPUT TYPE=SUBMIT VALUE="Send Your Question">
	
			
			
			
			
		
		
	</P>
		</FORM>
	
	
	<P>
		<A HREF="https://nycabsentee.com/" TARGET="Abstee">Request your Absentee Ballot Online</A>
	</P>
		
			
	
	</FORM>
</DIV>
		
<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/footer.php"; ?>
