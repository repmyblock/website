<?php
  if ( ! empty ($k)) { $MenuLogin = "logged";  }  
  $Menu = "ngo";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_ngos.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new NGOs(0);
  
  if ( ! empty ($_POST)) {
			
			echo "<PRE>";
			print_r($_POST, 1);
			echo "</PRE>";
			exit();
			header("Location: /" . MergeEncode(
					[
						"NGOID" => $NGOID,
						"NGOEndID" => $NGOEndID,
						"NGOEndType" => $endtype,
						"NGOEndGrade" => $grade,
						"NGOContactIn" => $contactin,
						"NGOContactOut" => $contactout
					]
			) . "/lgd/ngo/saveendorsement");				
			exit();
  }  
  
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  
   $TopMenus = array ( 
            array("k" => $k, "url" => "voters/voterlist", "text" => "NGO Definition"),
            array("k" => $k, "url" => "voters/voterquery", "text" => "Endorsements")
          );      
  
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) { $Cols = "col-12"; $selCols = "col-12";} else { $Cols = "col-9"; }
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Non Governmental Organizations</h2>
          </div>
          
          <FORM ACTION="" METHOD="POST">
         		<DIV class="f40 js-collaborated-repos-empty">
                        
             <PRE><?= print_r($URIEncryptedString,1 ) ?></PRE>
             
            
       
         <div class="field">
  <select id="orgstatus" name="orgstatus" class="select" required>
    <option value="" disabled selected hidden></option>
    <option value="501c3">501(c)(3)</option>
    <option value="501c4">501(c)(4)</option>
    <option value="527">527</option>
    <option value="other">Other</option>
  </select>
  <label for="orgstatus">NGO IRS Tax Type<SUP>*</SUP></label>
</div>


              <P class="f80">
              	What type of endorsement your organization provide?
              </P>
               
              <P>
	              <INPUT TYPE="radio" name='endorsetype' value="single">Single candidate endorsement per race<BR>
  	            <INPUT TYPE="radio" name='endorsetype' value="multiple">Multiple candidate endorsement per race<BR>
  	            <INPUT TYPE="radio" name='endorsetype' value="none">We can't endorse candidates<BR>
              </P>
              
              <P class="f80">
		          	Scoring methodology? 
		        	</P>
		        
              <P>
              	<INPUT TYPE="radio" name='grade' value="number">A numeral score?<BR>
             		<INPUT TYPE="radio" name='grade' value="letter">A letter?<BR>
             	</P>
             	
              <P class="f80">
		          	Contact methodology? 
		        	</P>
	
               
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
