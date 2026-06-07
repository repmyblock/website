<?php
header('Content-Type: application/json');

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";

$q = trim($_GET['k'] ?? '');

WriteStderr($_GET, "POST IN Search Candidates: $q");


if ($q === '') {
    echo json_encode([
        'ok' => false,
        'error' => 'Missing candidate name'
    ]);
    exit;
}

$r = new welcome(0);

$result = $r->SearchForCandidateName(
    ElectionDateFrom: "NOW",
    NotOnBallot: 'no',
    CandidateName: $q
);



for ($i = 0; $i < count($result); $i++) {
	$result[$i]["PicturePath"] = "/shared/pics/" . (!empty($result[$i]["CandidateProfile_PicFileName"]) ?
									         			$result[$i]["CandidateProfile_PicFileName"] : "0000/NoPicture.jpg");
  $result[$i]["DetailURL"] = "/" . numbertoalpha($result[$i]["CANDPROFID"]) . "_" . 
  														strtolower(preg_replace('/[^a-zA-Z0-9]+/', '', $result[$i]["CandidateProfile_Alias"])); #. "/voter/detail";
}

WriteStderr($result, "Candidate List");

echo json_encode([
    'ok' => true,
    'query' => $q,
    'candidates' => $result
]);
exit;

?>