<?php


	if ( ! empty ($k)) { $MenuLogin = "logged"; }
	$Menu = "admin";
	$BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();

	if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}	
	$Party = NewYork_PrintParty($UserParty);
	
	if ( ! empty ($_POST)) {
		WriteStderr($_POST, "Post:");
		
		
		$AddNewCategory = 1;
	}
	
	
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";


	/*
		DROP TABLE SurveyCategory;
		CREATE TABLE SurveyCategory (
			SurveyCategory_ID int unsigned  primary key auto_increment,
  	  Candidate_ID int unsigned,
		  TeamMember_ID int unsigned,
		  SystemUser_ID int unsigned,
			SurveyCategory_Name varchar(256),
		  SurveyCategory_Type int unsigned
		);

		DROP TABLE SurveyValues;
		CREATE TABLE SurveyValues (
			SurveyValues_ID  int unsigned primary key auto_increment,
  	  Candidate_ID int unsigned,
		  TeamMember_ID int unsigned,
		  SystemUser_ID int unsigned,
		  SurveyCategory_ID int unsigned,
		  SurveyValues_Name varchar(256)
		);

		DROP TABLE VotersSurvey;
		CREATE TABLE VotersSurvey (
			VotersSurvey_ID int unsigned primary key auto_increment,
		  Candidate_ID int unsigned,
		  TeamMember_ID int unsigned,
		  SystemUser_ID int unsigned,
		  VotersIndexes_ID int unsigned,
 		  SurveyCategory_ID int unsigned,
		  SurveyValues_Name int unsigned
		);
	*/

?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Create Categories</h2>
				</div>

			
			 	<DIV class="panels">		
				<P>
				<B>Update the voter information.</B><BR>
				This information is not shared with anyone except who you share it with.
			</P>
		
			<?php
				// To deal with the referer
				$KeyWords = PrintReferer(1);
			?>
			
			<P>
				<FORM ACTION="" METHOD="POST">
				
				<?php if ($AddNewCategory ==1 ) {  ?>
				<INPUT TYPE="hidden" NAME="CatName" VALUE="<?= $_POST["CatName"] ?>"><BR>
				Name of the category: <INPUT TYPE="text" NAME="CatValue" VALUE=""><BR>
				
				
			<?php } else { ?>
				
				Name of the category: <INPUT TYPE="text" NAME="CatName" VALUE="<?= $_POST["CatName"] ?>"><BR>
				Type of answers: <SELECT NAME="TypeAnswer">
														<OPTION VALUE="">&nbsp;</OPTION>
														<OPTION VALUE="checkBoxes">Checkboxes (Multiple Option)</OPTION>
														<OPTION VALUE="radio">Radios (One Option)</OPTION>
														<OPTION VALUE="openfields">Open Fields (Writen Field)</OPTION>
												</SELECT>		
				
	
		<?php } ?>
	<INPUT TYPE="SUBMIT" VALUE="Create the category">	
			</FORM>
					<P>
				<BR>
				
			<A HREF="<?= PrintReferer()  ?>">Return to previous menu</A></B>
		</P>	
		</div>
		
		
		
									
		
	
			</DIV>
		</FORM>
		</DIV>
	</DIV>
</DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
