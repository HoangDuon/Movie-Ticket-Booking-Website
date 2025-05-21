<?php
require_once "../model/pdo.php";

$sql = "SELECT email, phone FROM users";
$rows = pdo_query($sql);

$list = [];
foreach ($rows as $row) {
    if (!empty($row['email'])) $list[] = $row['email'];
    if (!empty($row['phone'])) $list[] = $row['phone'];
}

echo json_encode(['success' => true, 'list' => $list]);
