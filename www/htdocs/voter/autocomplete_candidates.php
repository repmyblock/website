<?php
header('Content-Type: application/json');

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";

$r = new welcome();
$q = strtoupper(trim($_GET['k'] ?? ''));

if (strlen($q) < 3) {
    echo json_encode([]);
    exit;
}

$terms = preg_split('/\s+/', $q);
$terms = array_filter($terms, fn($t) => strlen($t) >= 3);
$boolean = '+' . implode('* +', $terms) . '*';

echo json_encode($r->ReturnCandidatesNames($boolean, 10));
?>