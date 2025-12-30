<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";

$r = new welcome(0);

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$state  = $_GET['state'] ?? null;
$date   = $_GET['date'] ?? "NOW";
$team   = $_GET['team'] ?? null;

$result = $r->CandidatesForElection(
  $date,
  null,
  $state,
  $team,
  $offset,
  600
);

foreach ($result as $var) {
  include $_SERVER["DOCUMENT_ROOT"] . "/partials/candidate_card.php";
}
?>