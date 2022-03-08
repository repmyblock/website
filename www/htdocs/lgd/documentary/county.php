<?php
	if ( ! empty ($k)) { $MenuLogin = "logged";  }  
	$Menu = "documentary";
	// $BigMenu = "represent";	
	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";	
	require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
	$rmb = new repmyblock();
	$rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
	
	if ( ! empty ($_POST)) {
		$rmb->RecordWatch($URIEncryptedString["SystemUser_ID"], $rmbperson["SystemUser_FirstName"] . " " . 
												$rmbperson["SystemUser_LastName"],  $rmbperson["SystemUser_email"]);
		$result = $rmb->GetMoviePassword();
		header("Location: /" . CreateEncoded (array("MovieCode" => $result["ZeMoviePwd_Password"],
																									"SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
																						)) . "/lgd/documentary/county");
		exit();
	} 
	
	WriteStderr($result, "Result");
		
	include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

<?php if ( ! empty ($URIEncryptedString["MovieCode"])) { ?>
<script>
function myFunction(col) {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput[" + col + "]");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[col];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function myFunctionCopy(value) {
  var copyText = document.getElementById(value);  
  // copyText.value = value;
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
}
</script>
<?php } ?>

<div class="row">
  <div class="main">
	<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>

		<div class="col-9 float-left">
			
			<div class="Subhead">
		  	<h2 class="Subhead-heading">County: A documentary</h2>
			</div>			
				<?php 
					WriteStderr($Decrypted_k, "Decrypted_k:");
					$NewKEncrypt = CreateEncoded (array("Candidate_ID" => $result[0]["Candidate_ID"]));
				?>	
				
				
				<?php if (! empty($URIEncryptedString["MovieCode"])) { ?>
				<P>
					To watch the documentary, you must press play on the documentary, and then you must 
					enter <FONT COLOR=BROWN><B><?= $URIEncryptedString["MovieCode"] ?></B></FONT> in the password window.
				</P>
		
				<P>
				<CENTER>
					<TD><INPUT TYPE="text" Size=20 id="myInputRMBC0"  value="<?= $URIEncryptedString["MovieCode"] ?>"></TD>
					<TD>&nbsp;</TD>
					<TD><button class="btn btn-primary" onclick="myFunctionCopy('myInputRMBC0')">Copy the password to paste in the movie</button></TD>
				</CENTER>
				
				
				<P CLASS="f60">
					<B><A HREF="/<?= $k ?>/exp/register/movie" TARGET="foward">Share the documentary with friends and familly.</A></B>
				</P>
				
				</P>
				
				<?php } else { ?>
						<P CLASS="f60">
					Before you can view <B><I>County: A documentary</I></B>, you must agree that we share your name 
					and email with the filmmaker.
				</P>
				
				<P>
					Please consider donating to his project so he can submit his documentary about the County Committee to 
					various film festivals.	<A HREF="https://www.gofundme.com/f/county-film">The County Go-Fund me page.</A>
				</P>
				
			
			<?php } ?>
					
				
				<P CLASS="f40">
					<script src="https://fast.wistia.com/embed/medias/f0ekqijjtz.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_f0ekqijjtz videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/f0ekqijjtz/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>
				</P>	
				
				
				<?php if ( empty($URIEncryptedString["MovieCode"])) { ?>
				
				<p>
					
					<FORM ACTION="" METHOD="POST">
					<button type="submit" NAME="MOVIE_PASSWORD" class="btn btn-primary">Get the password and accept sharing your info with the filmmaker</button>
					</FORM>
				</p>
			
				</P>
				
				<?php } else { ?>
				
				<P>
					Please consider donating to his project so he can submit his documentary about the County Committee to 
					various film festivals.	<B><A HREF="https://www.gofundme.com/f/county-film">The County Go-Fund me page.</A></B>
				</P>
	
				<P>
					<B><A HREF="/<?= $k ?>/exp/register/movie" TARGET="foward">Share the documentary with friends and familly.</A></B>
				</P>
	
				<?php } ?>
	
	
		
			
				
			</div>	
		</DIV>
		
	</div>
</DIV>




<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";	?>
