<?php
require_once '../connection.php';

$admin = [
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':MiddleName' => $_POST['middlename']
];

$account = [
    ':Username' => $_POST['username'],
    ':Password' => $_POST['password'],
    ':Pin' => $_POST['pin'],
    ':IsLocked' => 0
];

$admin_account = [
    ':AdminId' => null,
    ':AccountId' => null
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO admin (FirstName, LastName, MiddleName) VALUES (:FirstName, :LastName, :MiddleName)');
$query->execute($admin);
$admin_account[':AdminId'] = $conn->lastInsertId();

$query = $conn->prepare('INSERT INTO account (Username, Password, Pin, IsLocked) VALUES (:Username, :Password, :Pin, :IsLocked)');
$query->execute($account);
$admin_account[':AccountId'] = $conn->lastInsertId();

$query = $conn->prepare('INSERT INTO admin_account (AdminId, AccountId) VALUES (:AdminId, :AccountId)');
if ($query->execute($admin_account)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>