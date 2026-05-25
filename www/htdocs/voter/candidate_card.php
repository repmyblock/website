<?php
/* Required external variables:
   $var
   &$PrevDateDesc
   &$PrevElectionID
   &$firsttime
*/

if (
  empty($var["CandidateProfile_ID"]) ||
  $var["CandidateProfile_NotOnBallot"] === 'yes' ||
  $var["CandidateProfile_PublishProfile"] === 'no'
) {
  return;
}

$DateDesc = PrintShortDate($var["Elections_Date"]) .
            " - " .
            $var["Elections_Text"];

$PicturePath = "/shared/pics/" .
  (!empty($var["CandidateProfile_PicFileName"])
    ? $var["CandidateProfile_PicFileName"]
    : "0000/NoPicture.jpg");

$FullAlias = preg_replace('/[^a-zA-Z0-9]+/', '', $var["CandidateProfile_Alias"]);

$DetailURL = "/" .
             numbertoalpha($var["CANDPROFID"]) .
             "_" .
             strtolower($FullAlias) .
             "/voter/detail";

/* 🔑 Detect new batch */
$NewBatch =
  ($PrevDateDesc !== $DateDesc) ||
  ($PrevElectionID !== $var["CandidateElection_ID"]);

/* 🔒 Close previous batch */
if ($NewBatch && !$firsttime) {
  echo "</div>";
}

/* 🔒 Open new batch */
if ($NewBatch) {
  ?>
  <div class="election-batch">
    <div class="election-header f60bold">
      <?= $DateDesc ?>
    </div>
    <div class="district-header f60">
      <?= $var["CandidateElection_Text"] ?>
    </div>
  <?php
}
?>

<div class="candidate-card frame">
  <span class="ribbon <?= strtolower($var["Candidate_Party"]) ?>">
    <?= htmlspecialchars($var["Candidate_Party"]) ?>
  </span>

  <a href="<?= $DetailURL ?>">
    <img src="<?= $PicturePath ?>" class="imgcandidate">
  </a>

  <div class="candidate-name">
    <?= ucwords(strtolower($var["CandidateProfile_Alias"])) ?>
  </div>
</div>

<?php
$PrevDateDesc = $DateDesc;
$PrevElectionID = $var["CandidateElection_ID"];
$firsttime = false;
?>