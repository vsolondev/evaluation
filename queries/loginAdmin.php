<?php
require_once '../connection.php';

$returnData = [
    'success' => false
];

$param = [
    'Username' => $_POST['username'],
    'Password' => $_POST['password']
];

$query = $conn->prepare(
    'SELECT * FROM admin_account
	INNER JOIN account ON account.AccountId = admin_account.AccountId
	INNER JOIN admin ON admin.AdminId = admin_account.AdminId
    WHERE Username = :Username AND
    Password = :Password'
);

$query->execute($param);
$count = $query->rowCount();

if ($count == 1) {
    $returnData['success'] = true;

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();
    $_SESSION['adminid'] = $query->fetch()['AdminId'];
    $_SESSION['role'] = 'ADMIN';
}

echo json_encode($returnData);
?>