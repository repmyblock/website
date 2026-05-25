<?php
header('Content-Type: application/json');

require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/db/db_welcome.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/../libs/common/verif_nolog.php";

$r = new welcome(0);	
$q = strtoupper(trim($_GET['k'] ?? ''));

if (strlen($q) < 3) {
    echo json_encode([]);
    exit;
}

$terms = preg_split('/\s+/', $q);
$terms = array_filter($terms, fn($t) => strlen($t) >= 3);
$boolean = '+' . implode('* +', $terms) . '*';

echo json_encode($r->ReturnOpenAddress($boolean, 10));
?>