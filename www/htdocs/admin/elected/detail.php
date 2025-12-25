<?php
  if ( ! empty ($k)) { $MenuLogin = "logged"; }
  $Menu = "admin";
  $BigMenu = "represent";  

  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_sec.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_admin.php";
  require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_admin.php";

  if (empty ($URIEncryptedString["SystemUser_ID"])) { goto_signoff(); }
  if ( empty ($URIEncryptedString["MenuDescription"])) { $MenuDescription = "District Not Defined";}
  
  $rmb = new RMBAdmin();  
  $rmbperson = $rmb->SearchUserVoterCard($URIEncryptedString["SystemUser_ID"]);
  $result = $rmb->ListSingleElected($URIEncryptedString["CandidateProfile_ID"])[0];
  
  if ( $MobileDisplay == true ) { $TypeEmail = "email"; $TypeUsername = "username";
  } else { $TypeEmail = "text"; $TypeUsername = "text"; }

  WriteStderr($result, "List Single Candidate");
  
  include $_SERVER["DOCUMENT_ROOT"] . "/common/headers.php";
?>

    <div class="row layout">
      <?php include $_SERVER["DOCUMENT_ROOT"] . "/common/menu.php"; ?>
      <div class="main">
        <div class="col-full">
          <div class="Subhead">
            <h2 class="Subhead-heading">Elected Maintenance</h2>
          </div>

          <div class="">
            <div class="">
              <div class="">
                <div class="">
                  <div class=""><h1><?= $result["Candidate_PetitionNameset"] ?></h1></div>
                	<DIV class=""><?= $result["CandidateElection_Text"] ?></DIV>
					    		<DIV class=""><?= $result["Candidate_DispName"] ?></DIV>
					      </div>
              </div>
                   
              <div class="">
                <div class="">

                  <div id="resp-table">
                    <div id="resp-table-header">
                      <div class="table-header-cell">District</div>
                      <div class="table-header-cell">Candidate</div>
                      <div class="table-header-cell">Actions</div>
                      <div class="table-header-cell">Election Date</div>
                    </div>
                    
                    <FORM>
                                
	                    <P>
											  <div class="field" style="--field-height: 20px">
											    <input id="alias" type="text" name="alias" required placeholder=" " value="<?= $result["CandidateElection_DBTable"] ?>">
											    <label for="alias">Position Code</label>
											    <fieldset>
											      <legend><span>Alias</span></legend>
											    </fieldset>
											  </div>
											</P>      	
	                    
	                  	<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="FirstName" required placeholder=" " value="<?= $result["CandidateElection_DBTableValue"] ?>">
											    <label for="username">District Number</label>
											    <fieldset>
											      <legend><span>Last Name</span></legend>
											    </fieldset>
											  </div>
											</P>      	            
	                                         
	                  	<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="alias" type="text" name="alias" required placeholder=" " value="<?= $result["CandidateProfile_Alias"] ?>">
											    <label for="alias">Alias</label>
											    <fieldset>
											      <legend><span>Alias</span></legend>
											    </fieldset>
											  </div>
											</P>      	
	                    
	                  	<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="FirstName" required placeholder=" " value="<?= $result["CandidateProfile_FirstName"] ?>">
											    <label for="username">First Name</label>
											    <fieldset>
											      <legend><span>Last Name</span></legend>
											    </fieldset>
											  </div>
											</P>      	

											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_LastName"] ?>">
											    <label for="username">Last Name</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   
											
											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_Website"] ?>">
											    <label for="username">Website</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   
											
											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_Email"] ?>">
											    <label for="username">Email Address</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   

											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_Twitter"] ?>">
											    <label for="username">Twitter</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   
											
											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_Facebook"] ?>">
											    <label for="username">Facebook</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   

											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_Instagram"] ?>">
											    <label for="username">Instagram</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   
											
											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_TikTok"] ?>">
											    <label for="username">TikTok</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   

											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_YouTube"] ?>">
											    <label for="username">YouTube</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   
											
											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_BallotPedia"] ?>">
											    <label for="username">BallotPedia</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   

											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_PhoneNumber"] ?>">
											    <label for="username">Phone Number</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   
											
											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_FaxNumber"] ?>">
											    <label for="username">Fax Number</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   
											
											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_Statement"] ?>">
											    <label for="username">Statement</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>   
											
											<P>
											  <div class="field" style="--field-height: 20px">
											    <input id="username" type="text" name="LastName" required placeholder=" " value="<?= $result["CandidateProfile_Donation"] ?>">
											    <label for="username">Donation Link</label>
											    <fieldset>
											      <legend><span>Password</span></legend>
											    </fieldset>
											  </div>
											</P>
											
											<P>
												<BUTTON class="button">Log In</BUTTON>
											</P>

                    <DIV class="panels">
<?php 
    if (! empty ($var)) {
      WriteStderr($var, "Voter Guide");
      print "<br style=\"clear:both\" />";
      $DateDesc = PrintShortDate($var["Elections_Date"]) . " - " . $var["Elections_Text"];
      $PrevDateDesc = $DateDesc;
      $PicturePath = "/shared/pics/" . 
                    ((empty($var["CandidateProfile_PicFileName"])) ? 
                    ((empty($var["Candidate_Party"]) || $var["Candidate_Party"] == "BLK") ? 
                      "0000/NoPicture.jpg" :                             
                      "0000/" . $var["DataState_Abbrev"] . "/" . $var["Candidate_Party"] . "_NoPic.jpg") : 
                      ($var["CandidateProfile_PicFileName"] . "?" . $addtopics));
?>
            
                      <DIV>    
                        <DIV class="f80"><B><?= $var["CandidateProfile_Alias"] ?></B></DIV>  
<?php 
          print "                        <PRE>" . print_r($URIEncryptedString, 1) . "</PRE>";
          print "                        <PRE>" . print_r($result, 1) . "</PRE>";
?>
        
                        <DIV class='container2'>
                          <DIV>
<?php if (! empty ($var["CandidateProfile_Website"])) { ?><A TARGET="NEW" HREF="<?= $var["CandidateProfile_Website"] ?>"><?php } ?><IMG class="candidate" style="float: left; margin: 0px 15px 0px 15px;" SRC="/shared/pics/<?= $PicturePath ?>" class='iconDetails'><?php if (! empty ($var["CandidateProfile_Website"])) { ?></A><?php } ?>
                            <DIV class="f60"><B><?= $DateDesc ?></B></DIV>
                            <P class="f40" style="text-margin: 0px 0px 0px 0px;">
                              <I>Running for <?= $var["CandidateElection_PetitionText"] ?></I>
                              <?php if (! empty ($var["CandidateProfile_Statement"])) { print $var["CandidateProfile_Statement"]; }  ?>
                            </P>
                          </DIV>  
                          <br style="clear:both">
                          <DIV class='container3'>
                            <P class="f60">
                              <?php if (! empty ($var["CandidateProfile_Website"])) { ?><B>Website:</B> <A TARGET="NEW" HREF="<?= $var["CandidateProfile_Website"] ?>"><?= $var["CandidateProfile_Website"] ?></A><BR><?php } ?>
                              <?php if (! empty ($var["CandidateProfile_BallotPedia"])) { ?><A TARGET="NEW" HREF="<?= $var["CandidateProfile_BallotPedia"] ?>">Ballotpedia</A><BR><?php } ?>
                              <?php if (! empty ($var["CandidateProfile_Email"])) { ?><B>Email:</B> <A TARGET="NEW" HREF="mailto:<?= $var["CandidateProfile_Email"] ?>"><?= $var["CandidateProfile_Email"] ?></A><?php } ?>
                              <?php if (! empty ($var["CandidateProfile_PhoneNumber"])) { print " <B>Telephone:</B> " . $var["CandidateProfile_PhoneNumber"] . "<BR>"; } ?>
                              <?php if (! empty ($var["CandidateProfile_Twitter"])) { ?>Twitter: <A TARGET="NEW" HREF="https://twitter.com/<?= $var["CandidateProfile_Twitter"] ?>">@<?= $var["CandidateProfile_Twitter"] ?></A><?php } ?>
                              <?php if (! empty ($var["CandidateProfile_Facebook"])) { ?>Facebook: <A TARGET="NEW" HREF="https://facebook.com/<?= $var["CandidateProfile_Facebook"] ?>"><?= $var["CandidateProfile_Facebook"] ?></A><?php } ?>
                              <?php if (! empty ($var["CandidateProfile_Instagram"])) { ?>Instagram: <A TARGET="NEW" HREF="https://instagram.com/<?= $var["CandidateProfile_Instagram"] ?>">@<?= $var["CandidateProfile_Instagram"] ?></A><?php } ?>
                              <?php if (! empty ($var["CandidateProfile_TikTok"])) { print $var["CandidateProfile_TikTok"] . " - "; } ?>
                              <?php if (! empty ($var["CandidateProfile_YouTube"])) { print $var["CandidateProfile_YouTube"] . " - "; } ?>
                              <?php if (! empty ($var["CandidateProfile_FaxNumber"])) { print $var["CandidateProfile_FaxNumber"]; } ?>
                            </P>                  
<?php if ( ! empty ($var["CandidateProfile_PDFFileName"])) { ?>            
                            <P class="f40"><A TARGET="PDFCandidate" HREF="<?= $FrontEndStatic ?>/shared/platforms/<?= $var["CandidateProfile_PDFFileName"] ?>">Download <?= $var["CandidateProfile_Alias"] ?>'s Platform</A></P>
<?php } ?>
                              </DIV>
                            </DIV>
                          </DIV>
<?php
    print "            <P>";
    print "             <PRE>" . print_r($result, 1) . "</PRE>";
    print "            </P>";   
  } else {
    header("Location:/error/404.php");
  }  
?>
                    
                    </DIV>
                    <br style="clear:both">

                   
                   	<DIV><PRE><?= print_r($result, 1) ?></PRE></DIV>
                   
<?php if ( empty ($var["SystemUser_ID"])) { ?>
                    <P CLASS="f80"><A HREF="/<?= $var["CandidateProfile_ID"] ?>/voter/claim">Claim this profile</A></P>
<?php } ?>
                   
                  </FORM>
                   
                    <DIV class="right f60">  
                      <A HREF="guide">Return to previous menu</A>
                    </DIV>
                  </DIV>
                </DIV>
              </DIV>
            </DIV>
          </DIV>
        </DIV>
      </DIV>
    </DIV>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/common/footer.php";  ?> 