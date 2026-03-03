<?php
  $Menu = "profile";  
  $BigMenu = "represent";  

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";  
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_repmyblock.php";  
  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); } 
  
  $rmb = new RepMyBlock();
  $rmbperson = $rmb->FindPersonUserProfile($URIEncryptedString["SystemUser_ID"]);

  if ( empty ($URIEncryptedString["MenuDescription"])) { $URIEncryptedString["MenuDescription"] = "District Not Defined";}  
  $Party = PrintParty($URIEncryptedString["UserParty"]);
   
  
  if ( empty(trim($_POST["FirstName"])) && empty (trim($_POST["LastName"]))) {
    $error_msg = "<P class=\"f60\"><B><FONT COLOR=BROWN>Please enter your full name to locate your voter registration card.</FONT></B>" .
                        "</P>";
                        
  } else {
      
    if ( ! empty (trim($_POST["dateofbith"]))) {
      WriteStderr($_POST, "Input \$_POST");
  
      // Search in the database.
      // We need to put verification on the first and lastname so they don't pass 
      // bogus data.    
      $DBFirstName = trim($_POST["FirstName"]);
      $DBLastName = trim($_POST["LastName"]);
      $DOB = trim($_POST["dateofbith"]);
      
      // Before we go and search the Database, we need to check that the DOB info is right.
      
       $result = $rmb->SearchVoterDB($DBFirstName, $DBLastName, $DOB, "active");
      WriteStderr($result, "SearchVoterDB(DBFirstName: $DBFirstName, DBLastName: $DBLastName, DOB: $DOB)");
      
      
      switch(count($result)) {
        case 0:
          //echo "Did not find anything\n";
          $error_msg = "<P class=\"f60\"><FONT COLOR=BROWN><B>We don't have</FONT> $DBFirstName $DBLastName " . 
                        "<FONT COLOR=BROWN>born</FONT> " . PrintShortDate($DOB) . " <FONT COLOR=BROWN>in our database.<BR></B></FONT> " .
                        "It my not be your fault. We get our data from the Board of Election files and sometimes they contain errors. " .
                        "If you believe it's a mistake, check your registration with the local board of election on their website." . 
                        "</P>";
          break;      
        
        case 1:        
          header("Location: /" .CreateEncoded ( array( 
                  "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
                  "Raw_Voter_ID" => $resultPass["Raw_Voter_ID"],
                  "FirstName" => $URIEncryptedString["FirstName"],
                  "LastName" => $URIEncryptedString["LastName"],
                  "VotersIndexes_ID" => $result[0]["VotersIndexes_ID"],
                  "UniqNYSVoterID" => $result[0]["Raw_Voter_UniqNYSVoterID"],
                  "UserParty" => $result[0]["Raw_Voter_RegParty"]
                ))  . "/lgd/profile/result");
          exit();
        
        default:
          if ( ! empty ($result)) {
            foreach($result as $var) {
              if ( ! empty ($var)) {
                $EncryptURL .= "&vi[]=" . $var["VotersIndexes_ID"];
              }  
            }
          }
               
          
          
          header("Location: /" . CreateEncoded ( array( 
                  "SystemUser_ID" => $URIEncryptedString["SystemUser_ID"],
                  "Raw_Voter_ID" => $URIEncryptedString["Raw_Voter_ID"],
                  "FirstName" => $URIEncryptedString["FirstName"],
                  "LastName" => $URIEncryptedString["LastName"],
                  "VotersIndexes_ID" => $result[0]["VotersIndexes_ID"],
                  "UniqNYSVoterID" => $result[0]["Raw_Voter_UniqNYSVoterID"],
                  "UserParty" => $result[0]["Raw_Voter_RegParty"],
                  "SystemUser_Priv" => $URIEncryptedString["SystemUser_Priv"],
                  "vi[]" => $var["VotersIndexes_ID"]
                ))   . "/lgd/profile/select");
          exit();
          
          
      
      }    
    } else {
      if (  ! empty ($_POST["Year"]) || ! empty ($_POST["Day"]) || ! empty ($_POST["Month"])) {
        $error_msg = "<P class=\"f60\"><B><FONT COLOR=BROWN>Please enter your full date of birth to locate your voter registration card.</FONT></B>" .
                        "</P>";
      }
    }
  }
  
   

 
    
  // This is because we'll add some logic later.
  $FirstName = $URIEncryptedString["FirstName"];
  $LastName = $URIEncryptedString["LastName"];
  
  $TopMenus = [ 
                ["k" => $k, "url" => "profile/user", "text" => "Public Profile"],
                ["k" => $k, "url" => "profile/voter/card", "text" => "Voter Profile"], 
                ["k" => $k, "url" => "profile/candidate/public", "text" => "Candidate Profile"],
                ["k" => $k, "url" => "profile/team/section", "text" => "Team Profile"]
              ];

  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
  if ( $MobileDisplay == true) {   $Cols = "col-12"; $SizeField = " SIZE=10"; } else { $Cols = "col-9"; }
?>

 <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Voter Profile</h2>
          </div>

 
      <?php  PlurialMenu($k, $TopMenus);  ?>


        <div class="clearfix gutter d-flex flex-shrink-0">
    
          <div class="col-16">
  
            <?= $error_msg ?>
  
           	<form ACTION="" METHOD="POST">
		                  
		        <div class="field">
		          <input type="<?= $TypeUsername ?>" id="username" autocorrect="off" class="input" name="FirstName" placeholder=" " required style="max-width: 380px;" <?php if (!empty ($FirstName)) { echo " VALUE=\"" . $FirstName . "\""; } ?>>
		          <label for="username">First Name</label>
		        </div>
		        
		           <div class="field">
		          <input type="<?= $TypeUsername ?>" id="username" autocorrect="off" class="input" name="LastName" placeholder=" " required style="max-width: 380px;" <?php if (!empty ($LastName)) { echo " VALUE=\"" . $LastName . "\""; } ?>>
		          <label for="username">Last Name</label>
		        </div>
		        
		        <div class="field">
		          <input type="date" id="next_meeting" class="input" name="dateofbith"  placeholder=" ">
		    			<label for="next_meeting">Date of birth</label>
		  			</div>
		    
      
                <p><INPUT class="f60bold" TYPE="Submit" NAME="SaveInfo" VALUE="Search Voter Registration"></p>
      
              </form> 
      
              </div>
            </div>
          </div>
        </div>
      </div>    
    </div>
  </div>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?>
  </body>
</html>