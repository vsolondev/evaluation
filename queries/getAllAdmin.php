<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$query = $conn->prepare(
    'SELECT * FROM admin'
);

/* 'SELECT * FROM admin 
    INNER JOIN admin_account ON admin.AdminId = admin_account.AdminId
    INNER JOIN account ON account.AccountId = admin_account.AccountId' */

if ($query->execute()) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>