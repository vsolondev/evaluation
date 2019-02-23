<?php
require_once '../connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$param = [
    ':TeacherId' => $_SESSION['teacherid'],
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':MiddleName' => $_POST['middlename']
];

$param3 = [
    ':AccountId' => 0,
    ':Pin' => $_POST['pin'],
    ':Password' => $_POST['password']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE teacher SET FirstName = :FirstName, LastName = :LastName, MiddleName = :MiddleName WHERE TeacherId = :TeacherId');

// To get the AccountId from teacher_account using teacherid session
$query2 = $conn->prepare('SELECT * FROM teacher_account WHERE TeacherId = ' . $_SESSION['teacherid'] );
$query2->execute();

// Store AccountId to param3
$param3[':AccountId'] = $query2->fetch()['AccountId'];

$query3 = $conn->prepare('UPDATE account SET Pin = :Pin, Password = :Password WHERE AccountId = :AccountId');

if ( $query->execute($param) && $query3->execute($param3) ) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>