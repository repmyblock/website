<?php 
	$BigMenu = "howto";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_showthebooks.php";  

	$showbooks = new ShowTheBooks();
	
	if (! empty ($_POST)) {	
		
		$key = array_search('Download the petition', $_POST);
		if ( ! empty ($key)) {
			header("Location: " . $FrontEndPDF . "/NYS/p" . $key . "/multipetitions");	
			exit();
		}
	
		$key = array_search('Show only those candidates', $_POST);
		$result = $showbooks->ListCandidatesByParty($_POST["Party"], $_POST["Position"]);				
				
	} 
	
	$result = $showbooks->ListCandidatesByParty($_POST["Party"], $_POST["Position"]);				
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
	
	$Positions = Array ('Mayor','Public Advocate','Comptroller','Staten Island Borough President', 'Queens Borough President',
											'Manhattan Borough President','Brooklyn Borough President','Bronx Borough President','Manhattan District Attorney',
											'Council District 01','Council District 02','Council District 03','Council District 04','Council District 05','Council District 06',
											'Council District 07','Council District 08','Council District 09','Council District 10','Council District 11','Council District 12',
											'Council District 13','Council District 14','Council District 15','Council District 16','Council District 17','Council District 18',
											'Council District 19','Council District 20','Council District 21','Council District 22','Council District 23','Council District 24',
											'Council District 25','Council District 26','Council District 27','Council District 28','Council District 29','Council District 30',
											'Council District 31','Council District 32','Council District 33','Council District 34','Council District 35','Council District 36',
											'Council District 37','Council District 38','Council District 39','Council District 40','Council District 41','Council District 42',
											'Council District 43','Council District 44','Council District 45','Council District 46','Council District 47','Council District 48',
											'Council District 49','Council District 50','Council District 51');
	$PartyAbbrev = Array("DEM", "REP", "CON", "WOR", "BLK" );
	$PartyNames = Array( "Democrat", "Republican", "Conservative", "Working Familly", "Independent" );
	
	$numbers = range(0,3);
	shuffle($numbers);
	
?>

<FORM ACTION="" METHOD="POST">

<div class="main">
	<div class="row">
		<div class="register">				
		<P>
			<h1 CLASS="intro">Candidates Running for Office in 2021</H1>
		</P>
		
		
		<P>
		<SELECT NAME="Position">
			<OPTION NAME=""></OPTION>
				<?php 
				for ($i = 0; $i < count($Positions); $i++) {
					if ( $_POST["Position"] == $Positions[$i]) { $Selection = " Selected";} else { $Selection = ""; }
					echo "<OPTION VALUE=\"". $Positions[$i] . "\"" . $Selection . ">" . $Positions[$i] . "</OPTION>\n";
				}
				?>
			
		</SELECT>
		
		
		<SELECT NAME="Party">
			<OPTION NAME=""></OPTION>
			<?php 
			foreach ($numbers as $number) {
				if ( $_POST["Party"] == $PartyAbbrev[$number]) { $Selection = " Selected";} else { $Selection = ""; }
				echo "<OPTION VALUE=\"". $PartyAbbrev[$number] . "\"" . $Selection . ">" . $PartyNames[$number] . "</OPTION>\n";
			}
			if ( $_POST["Party"] == $PartyAbbrev[4]) { $Selection = " Selected";} else { $Selection = ""; }
			echo "<OPTION VALUE=\"". $PartyAbbrev[4] . "\"" . $Selection . ">" . $PartyNames[4] . "</OPTION>\n";
			?>
		</SELECT>
		
		<INPUT TYPE="SUBMIT" NAME="SELECT" VALUE="Show only those candidates">&nbsp;</TD>
		</P>
		
		<P><BR></P>
		
		
		<?php
			
			if ( empty ($result)) {
				
				echo "<P><CENTER><H1><FONT COLOR=BROWN>No candidates found</FONT></H1></CENTER><p>";
				
				
			}
		
		
		?>
		
		
		<P CLASS="">
			<TABLE BORDER=0 CLASS="nothing">
			<?php if (! empty ($result)) {
					foreach ($result as $var) {
						if (! empty ($var)) { 
							if ( $var["Candidate_SuspendCampaign"]  != "yes") {								
								if ( empty ($var["Candidate_PetID"] )) { $var["Candidate_PetID"] = 0;	}
								 ?>
							
			
			<TR><td align="RIGHT" COLSPAN=4><h2>&nbsp;<?= $var["Candidate_CouncilDistrict"] ?>&nbsp;</H2></TD></TR>
			
			<TR>
				<td COLSPAN=3><b>&nbsp;<FONT SIZE=+3><?= $var["Candidate_FirstName"] ?> <?= $var["Candidate_LastName"] ?></FONT></B> - <?= NewYork_PrintParty($var["Candidate_Party"]) ?></TD>
				<TD ALIGN=RIGHT><INPUT TYPE="SUBMIT" NAME="<?= $var["Candidate_PetID"] ?>" VALUE="Download the petition">&nbsp;</TD>
			</TR>
			
			<TR>
				
				
				
				
				<TD VALIGN=TOP>
					<BR>&nbsp;
				<img src="https://www.showthebooks.org/politico/pics/<?= $var["Candidate_Picture"] ?>" width="60">&nbsp;</td>				
				<td>&nbsp;</TD>
	
			<TD>
				<BR>
				<b><FONT SIZE=+1><a href="<?= $var["Candidate_Web"] ?>" target="CandidateWeb"><?= $var["Candidate_Web"] ?></a></FONT></b><br>				
				<b>Email:</b> <a href="mailto://<?= $var["Candidate_Email"] ?>" target="Candidate_Email"><?= $var["Candidate_Email"] ?></a><br>					
				<B>Donate:</B> <A TARGET=OTHER href="<?= $var["Candidate_DonationLink"] ?>">Donate to <?= $var["Candidate_FirstName"] ?>'s campaign</A><BR>
				<?php 
					if ( ! empty ($var["Candidate_Twitter"])) { echo "<B>Twitter:</B> <A TARGET=OTHER HREF=\"https://twitter.com/" . $var["Candidate_Twitter"] . "\">" . $var["Candidate_Twitter"] . "</A><BR>"; }; 
					if ( ! empty ($var["Candidate_Instagram"])) { echo "<B>Instagram:</B> <A TARGET=OTHER HREF=\"https://instagram.com/" . $var["Candidate_Instagram"] . "\">" . $var["Candidate_Instagram"] . "</A><BR>"; }; 
					if ( ! empty ($var["Candidate_Telephone"])) { echo "<B>Telephone:</B> " . formatPhoneNumber($var["Candidate_Telephone"]) . "<BR>"; }; 
					if ( ! empty ($var["Candidate_Ballotpedia"])) { echo "<B>Ballotpedia:</B> <A TARGET=OTHER HREF=\"" . $var["Candidate_Ballotpedia"] . "\">" . $var["Candidate_Ballotpedia"] . "</A><BR>"; }; 
					if ( ! empty ($var["Candidate_Facebook"])) { echo "<B>Facebook:</B> <A TARGET=OTHER HREF=\"" . $var["Candidate_Facebook"] . "\">" . $var["Candidate_Facebook"] . "</A><BR>"; }; 
					if ( ! empty ($var["Candidate_YouTube"])) { echo "<B>YouTube:</B> <A TARGET=OTHER HREF=\"" . $var["Candidate_YouTube"] . "\">" . $var["Candidate_YouTube"] . "</A><BR>"; }; 
					if ( ! empty ($var["Candidate_LinkIn"])) { echo "<B>LinkedIn:</B> <A TARGET=OTHER HREF=\"" . $var["Candidate_LinkIn"] . "\">" . $var["Candidate_LinkIn"] . "</A><BR>"; }; 
					?>
					<BR>
					<font size=-1><A TARGET=OTHER HREF="<?= $FrontEndBugs ?>/bugs/<?= $var["Candidate_ID"] ?>/candidatereport"><B>Report erroneous information with a candidate</B></A></FONT>
			
		
					
				<b><BR>&nbsp;<BR>
				
						
				</td>
		
		<?php	}
						}
					}
			}
			?>
		</TABLE>
		</P>
		
	
	</DIV>
	</DIV>
</div>
</FORM>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php"; ?>
