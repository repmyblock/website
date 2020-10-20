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
	
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";

?>

<div class="row">
  <div class="main">
		<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
			<div class="col-9 float-left">
				<div class="Subhead">
			  	<h2 class="Subhead-heading">Update Voter Information</h2>
				</div>

			
			 	<DIV class="panels">		
				<P>
				<B>Update the voter information.</B><BR>
				This information is not shared with anyone except who you share it with.
			</P>
			
			<P>
			
				<A HREF="/ldg/<?= $k ?>/sendlinkupdate">Send them a link to enrol into RepMyBlock.</A><BR>
				<A HREF="/ldg/<?= $k ?>/sendlinkreginfo">Send them information to update their voter registration information.</A><BR>
				<A HREF="/ldg/<?= $k ?>/sendlinkcandidate">Send them information on a candidate you like.</A><BR>
				
</P>
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
