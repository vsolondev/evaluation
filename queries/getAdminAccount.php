<?php
require_once '../connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$param = [
    ':AdminId' => $_SESSION['adminid']
];

$returnData = [
    'success' => false,
    'data' => []
];

$query = $conn->prepare(
    'SELECT * FROM admin 
    INNER JOIN admin_account ON admin.AdminId = admin_account.AdminId
    INNER JOIN account ON account.AccountId = admin_account.AccountId
    WHERE admin.AdminId = :AdminId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetch();
}

echo json_encode($returnData);
?>