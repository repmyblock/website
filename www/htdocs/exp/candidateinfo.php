<?php 
	$BigMenu = "howto";
	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_showthebooks.php";  
	
	if (! empty ($_POST)) {	
		$key = array_search('Download the petition', $_POST);
		header("Location: " . $FrontEndPDF . "/NYS/p" . $key . "/multipetitions");
		
		exit();
	}
	
	$showbooks = new ShowTheBooks();
	$result = $showbooks->ListCandidates();				
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<FORM ACTION="" METHOD="POST">

<div class="main">
	<div class="row">
		<div class="register">				
		<P>
			<h1 CLASS="intro">Candidates Running for Office in 2021</H1>
		</P>
		
		<P CLASS="f40">
			<TABLE BORDER=0 CLASS="nothing">
			<?php if (! empty ($result)) {
					foreach ($result as $var) {
						if (! empty ($var)) { 
							if ( $var["Candidate_SuspendCampaign"]  != "yes") {								
								if ( empty ($var["Candidate_PetID"] )) { $var["Candidate_PetID"] = 0;	}
								 ?>
							
			
			<TR><td align="LEFT" COLSPAN=4><h2>&nbsp;<?= $var["Candidate_CouncilDistrict"] ?></H2></TD></TR>
			
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
