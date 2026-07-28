<?php 
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_voterfile.php";
	$r = new VoterFile();
	
	if ( ! empty ($_POST)) {
		$r->SavePersonal(
				trim($_POST["id"]), trim($_POST["tendency"]),
				trim($_POST["PARTYNAME"]), trim($_POST["PARTYURL"]),
				trim($_POST["PARTYCITY"])
		);		
		header("location: /savequestions" . $returnID["Survey_ID"]);
		exit();
	}
	include $_SERVER["DOCUMENT_ROOT"] . "/headers/headers.php";
?>
  <section>
    <h1>Volunteer Survey</h1>
    
    <p>Thanks for answering the survey.</P>
    	
    <P>We'll contact you soon</p>

		<P>
			Most board of elections are very partisan and requires a lot of diplomacy to get some basic information.
		</P>

		<P>
			This information is very sensitive, but it does allow us to smooth the sharing process when we can match the board of elections and party commissioners with people with the same value system.
		</P>
		
		<P>
			YOU DO NOT HAVE TO ANSWER ANY QUESTIONS IF YOU DO NOT FEEL COMFORTABLE.
		</P>


		<P>
			<A HREF="/">Return to the main page.</A> The voter lists will be shared with 
    	<A HREF="https://www.progcode.org" TARGET="political">https://progcode.org</A>,
    	<A HREF="https://repmyblock.org" TARGET="political">https://repmyblock.org</A> and any
    	campaign that wants it.
		</P>

		
		<P>
			You can visit the Rep My Block website at <A HREF="https://www.repmyblock.org/web/exp/toplinks/about" TARGET="party">https://www.repmyblock.org/web/exp/toplinks/about</A> to 
			get more information about the ideological groups.
		</P>
		
		<?php if (! empty ($_GET)) { foreach($_GET as $index => $var); } ?>		
		<FORM ACTION="" METHOD="POST">
			<INPUT TYPE="hidden" NAME="id" VALUE="<?= $index ?>">
			
			<P>
				<TABLE>
				<TR><TD COLSPAN=3><B>Local Party</B></TD></TR>

			
				<TR>
									 
				 <TD>Party&nbsp;Local&nbspName</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="PARTYNAME" SIZE=40>
				 </TD>
				 
				 </TR>
				 <TR>
				  <TD>Website</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="PARTYURL" SIZE=40>
				 </TD>
				 
				  <TR>
				  <TD>City</TD>
    		<TD>&nbsp;</TD>
		  	<TD>
				 	<INPUT TYPE="TEXT" NAME="PARTYCITY" SIZE=40>
				 </TD>
			 
    	</TR>
				
				</TABLE>
			</P>
			
			
			
			
			<P>
				<TABLE>
					<TR><TD COLSPAN=3><B>Republicans</B></TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="0" NAME="tendency"></TD><TD>Independent</TD><TD>&nbsp;</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="14" NAME="tendency"></TD><TD>Project Civica</TD><TD><A HREF="https://projectcivica.org" TARGET="party">https://projectcivica.org</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="1" NAME="tendency"></TD><TD>Nationalists</TD><TD><A HREF="https://www.idgroup.eu" TARGET="party">https://www.idgroup.eu</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="2" NAME="tendency"></TD><TD>Democrat Union</TD><TD><A HREF="https://www.idu.org" TARGET="party">https://www.idu.org</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="4" NAME="tendency"></TD><TD>Centrist Democrat</TD><TD><A HREF="https://www.idc-cdi.com" TARGET="party">https://www.idc-cdi.com</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="5" NAME="tendency"></TD><TD>Liberals and centrists</TD><TD><A HREF="https://liberal-international.org" TARGET="party">https://liberal-international.org</TD></TR>
					<TR><TD COLSPAN=3>&nbsp;</TD></TR>
				
					<TR><TD COLSPAN=3><B>Democrats</B></TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="0" NAME="tendency"></TD><TD>Independent</TD><TD>&nbsp;</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="13" NAME="tendency"></TD><TD>Progressive Victory</TD><TD><A HREF="https://www.progressivevictory.win" TARGET="party">https://www.progressivevictory.win</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="5" NAME="tendency"></TD><TD>Liberals and centrists</TD><TD><A HREF="https://liberal-international.org" TARGET="party">https://liberal-international.org</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="6" NAME="tendency"></TD><TD>Progressive Alliance</TD><TD><A HREF="https://progressive-alliance.info" TARGET="party">https://progressive-alliance.info</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="7" NAME="tendency"></TD><TD>Social democrats and Socialists</TD><TD><A HREF="https://socialistinternational.org" TARGET="party">https://socialistinternational.org</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="9" NAME="tendency"></TD><TD>Progressive International</TD><TD><A HREF="https://progressive.international" TARGET="party">https://progressive.international</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="10" NAME="tendency"></TD><TD>Communists and Workers' parties</TD><TD><A HREF="http://www.solidnet.org" TARGET="party">http://www.solidnet.org</TD></TR>
					<TR><TD COLSPAN=3>&nbsp;</TD></TR>

					<TR><TD COLSPAN=3><B>Independents</B></TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="8" NAME="tendency"></TD><TD>Greens and regionalists</TD><TD><A HREF="https://globalgreens.org" TARGET="party">https://globalgreens.org</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="11" NAME="tendency"></TD><TD>Socialists Alternative</TD><TD><A HREF="https://internationalsocialist.net" TARGET="party">https://internationalsocialist.net</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="3" NAME="tendency"></TD><TD>International Alliance of Libertarian Parties</TD><TD><A HREF="https://ialp.com" TARGET="party">https://ialp.com</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="12" NAME="tendency"></TD><TD>Pirates</TD><TD><A HREF="https://pp-international.net" TARGET="party">https://pp-international.net</TD></TR>
					<TR><TD><INPUT TYPE="radio" VALUE="0" NAME="tendency"></TD><TD>Independent</TD><TD>&nbsp;</TD></TR>
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
