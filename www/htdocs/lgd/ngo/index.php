<?php
  if ( ! empty ($k)) { $MenuLogin = "logged";  }  
  $Menu = "ngo";
  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_ngos.php";  
  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  $rmb = new NGOs(0);
  
  if ( ! empty ($_POST)) {
			
			switch($_POST["grade"]) {
				case 'number': $grade = "number"; break;
				case 'letter': $grade = "letter"; break;
				default: $grade = null;
			}
			
			switch($_POST["endorsetype"]) {
				case 'none': $endtype = "none"; break;
				case 'single': $endtype = "single"; break;
				case 'multiple': $endtype = "multiple"; break;
				default: $endtype = null;
			}
			
			$contactin = (isset($_POST['candoorg']) && $_POST['candoorg'] === 'yes') ? 'yes' : 'no';
			$contactout = (isset($_POST['orgtocan']) && $_POST['orgtocan'] === 'yes') ? 'yes' : 'no';
		
			$NGOID = $rmb->SaveNewNGO(trim($_POST["orgname"]), trim($_POST["orgstatus"]), trim($_POST["orgserialid"]), trim($_POST["orgwebsite"]));			
			$NGOEndID = $rmb->SaveNGOEndor($NGOID, $endtype,  $grade, $contactin, $contactout);			
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
  
  $TopMenus = [ 
		            ["k" => $k, "url" => "voters/voterlist", "text" => "NGO Definition"],
    		        ["k" => $k, "url" => "voters/voterquery", "text" => "Endorsements"]
        		  ];
  
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
          
          <DIV>
           <?php PlurialMenu($k, $TopMenus); ?>
          </DIV>
           
          <BR>
          <FORM ACTION="" METHOD="POST">
         		<DIV class="f40 js-collaborated-repos-empty">
                        
              <div class="field">
          			<input type="text" id="orgname"  class="input" name="orgname" placeholder=" " required  VALUE="<?= $_POST["VALUE"] ?>">
			          <label for="orgname">Organization Name<SUP>*</SUP></SUP></label>
      			  </div>
                 
              <div class="field">
          			<input type="text" id="orgstatus"  class="input" name="orgstatus" placeholder=" " required  VALUE="<?= $_POST["VALUE"] ?>">
			          <label for="orgstatus">NGO IRS Tax Type<SUP>*</SUP></label>
      			  </div>
         
              <div class="field">
          			<input type="text" id="orgserialid"  class="input" name="orgserialid" placeholder=" "   VALUE="<?= $_POST["VALUE"] ?>">
			          <label for="orgserialid">IRS EIN Number</label>
      			  </div>
                        
              <div class="field">
          			<input type="text" id="orgwebsite"  class="input" name="orgwebsite" placeholder=" "   VALUE="<?= $_POST["VALUE"] ?>">
			          <label for="orgwebsite">NGO Website</label>
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
