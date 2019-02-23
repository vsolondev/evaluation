<?php
require_once '../connection.php';

session_start();

$param = [
    ':AdminId' => $_SESSION['adminid'],
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':MiddleName' => $_POST['middlename']
];

$param3 = [
    ':AccountId' => 0,
    ':Pin' => $_POST['pin']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE admin SET FirstName = :FirstName, LastName = :LastName, MiddleName = :MiddleName WHERE AdminId = :AdminId');

// To get the AccountId from admin_account using adminid session
$query2 = $conn->prepare('SELECT * FROM admin_account WHERE AdminId = ' . $_SESSION['adminid'] );
$query2->execute();

// Store AccountId to param3
$param3[':AccountId'] = $query2->fetch()['AccountId'];

$query3 = $conn->prepare('UPDATE account SET Pin = :Pin WHERE AccountId = :AccountId');

if ( $query->execute($param) && $query3->execute($param3) ) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>