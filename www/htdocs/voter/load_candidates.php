<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";

$r = new welcome();

$decoded = base64_decode($_GET['k'] ?? '');
parse_str($decoded, $params);

$offset = intval($params['offset'] ?? 0);
$state  = $params['state'] ?? null;
$date   = $params['date'] ?? 'NOW';
$team   = $params['team'] ?? null;

$result = $r->CandidatesForElection(
  ElectionDateFrom: $date,
  ElectionDateTo: null,
  ElectionState: $state,
  ActiveTeam: $team,
  Offset: $offset,
  CandidateElectionID: null,
  Limit: 600
);

foreach ($result as $var) {
  include $_SERVER["DOCUMENT_ROOT"] . "/voter/candidate_card.php";
}
?>