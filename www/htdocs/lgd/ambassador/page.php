<?php
  if ( ! empty ($k)) { $MenuLogin = "logged";  }  
  $Menu = "ambassador";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new repmyblock(0);
  
  if ( ! empty ($_POST)) {
			echo "Save to database the organization name";
			echo "<PRE>";
			print_r($_POST);
			echo "</PRE>";
			exit();
  }  
  
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; $selCols = "col-12";} else { $Cols = "col-9"; }
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Ambassador</h2>
          </div>
          
          <DIV class="f40 js-collaborated-repos-empty">
       		
       				SAVE Content Page
       				
       				Page Name: 
	
               
              <P>
	             	<INPUT TYPE="checkbox" name='cantoorg' value="yes">Do you want the candidate to contact your organization?<BR>
	             	<INPUT TYPE="checkbox" name='orgtocan' value="yes">Do you contact the candidates to invite them to be endorsed?<BR>
              </P>
            
            	<p><button type="submit" class="submitred">Save the organization data</button></p>
                         
            
            </FORM>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
