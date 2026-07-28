<?php 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterfile.php";
	$r = new VoterFile();
	
	if ( ! empty ($_POST)) {
		if ($_POST["experience"] == "na") { $Exp = NULL; } else {	$Exp = $_POST["experience"]; }
		if ($_POST["raw"] == "na") { $Raw = NULL; } else {	$Raw = $_POST["experience"]; }
		
		$returnID = $r->SaveSurvey(trim($_POST["First"]), trim($_POST["Last"]), trim($_POST["EMAIL"]),
										$_POST["STATE"], trim($_POST["COUNTY"]), trim($_POST["ZIP"]), $Exp, $Raw);		
		$r->SaveLocalBOE($returnID["Survey_ID"], trim($_POST["BOENAME"]) , trim($_POST["BOEURL"]));
		
		header("location: /savedsurvey/" . $returnID["Survey_ID"]);
		exit();
	}

	$result = $r->ListStates();
	
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>

  <body class="index">
    <div class="container">
  <header>
    <img src="images/logo.png" />
    <ul>
      <li>
        <a href="https://trello.com/b/IlZkwYc0/national-voter-file-states-pipeline">State pipeline</a>
      </li>
      <li>
        <a href="https://github.com/getmovement/national-voter-file/graphs/contributors">Contributors</a>
      </li>
      <li>
        <a href="https://github.com/getmovement/national-voter-file">Fork us on GitHub</a>
      </li>
    </ul>
  </header>

  <section>
    <h1>Volunteer Survey</h1>
    
    <p>This is a non-partisan survey <I>(all answers are optional)</I></p>
    
    <P>
    	<FORM ACTION="" METHOD="POST">
    	<TABLE>
    		
    		<TR><TD COLSPAN=3><B>Your information</B></TD></TR>
    		
    		<TR><TD COLSPAN=3>&nbsp;</TD></TR>
    		
    		<TR><TD COLSPAN=1>Your</TD></TR>
    	
    	<TR>
    		<TD>State</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<SELECT NAME="STATE">
				 	<OPTION VALUE="">&nbsp;</OPTION>
				 	<?php foreach ($result as $var) {
				 		if (! empty ($var)) { ?>
				 			<OPTION VALUE="<?= $var["States_ID"] ?>"><?= $var["States_Name"] ?></OPTION>
				 		<?php  			
				 		}
				 	} ?>
					 </SELECT>
				 </TD>
				</TR>
				
				<TR>
									 
				 <TD>County</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="COUNTY" SIZE=30>
				 </TD>
			 
    	</TR>
    	
    	<TR>
									 
				 <TD>Zipcode</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="ZIP" SIZE=10>
				 </TD>
			 
    	</TR>
			
			
			<TR><TD COLSPAN=3>&nbsp;</TD></TR>
 
				
				<TR>
									 
				 <TD>First Name</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="First" SIZE=20>
				 </TD>
			 
    	</TR>
    	
    	<TR>
									 
				 <TD>Last Name</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="Last" SIZE=20>
				 </TD>
			 
    	</TR>
    	
    	<TR>
									 
				 <TD>Email</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="EMAIL" SIZE=40>
				 </TD>
			 
    	</TR>
    	
    				<TR><TD COLSPAN=3>&nbsp;</TD></TR>
    				
    				
    					<TR><TD COLSPAN=3><B>County Board of Election</B></TD></TR>
 
				
				<TR>
									 
				 <TD>BOE Name</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="BOENAME" SIZE=40>
				 </TD>
				 
				 </TR>
				 <TR>
				  <TD>Website</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="BOEURL" SIZE=50>
				 </TD>
			 
    	</TR>
 	
    	<TR><TD COLSPAN=3>&nbsp;</TD></TR>
    	
   		 <TR>
				  <TD COLSPAN=3>Do you have experience dealing with your local board of elections?</TD>
    	</TR>


 				 <TR>
				  <TD COLSPAN=2>&nbsp;</TD>
				  <TD>
				  	<INPUT TYPE="radio" NAME="experience" Value='yes'>Yes
				  	<INPUT TYPE="radio" NAME="experience" Value='no'>No
				  	<INPUT TYPE="radio" NAME="experience" Value='n/a'>N/A
				  </TD>
    		</TR>
    		
    		<TR><TD COLSPAN=3>&nbsp;</TD></TR>
    		
    		 <TR>
				  <TD COLSPAN=3>Have you ever requested the raw voter data?</TD>
    	</TR>


 				 <TR>
				  <TD COLSPAN=2>&nbsp;</TD>
				  <TD>
				  	<INPUT TYPE="radio" NAME="raw" Value='yes'>Yes
				  	<INPUT TYPE="radio" NAME="raw" Value='no'>No
				  	<INPUT TYPE="radio" NAME="raw" Value='n/a'>N/A
				  </TD>
    		</TR>
    		
    		<TR><TD COLSPAN=3>&nbsp;</TD></TR>
    		
 				 <TR>
				  <TD COLSPAN=2>&nbsp;</TD>
				  <TD>
				  	<INPUT TYPE="submit" NAME="submit" Value='Save my answers'>
				  </TD>
    		</TR>
 
			 </TABLE>
			</FORM>
			 
			 
		 	
		 	
		 </P>
   
   
  </section>
</div>



  </body>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/headers/fpoter.php"; ?>
