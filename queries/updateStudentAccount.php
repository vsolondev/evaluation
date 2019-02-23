<?php
require_once '../connection.php';

session_start();

$param = [
    ':StudentId' => $_SESSION['studentid'],
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

$query = $conn->prepare('UPDATE student SET FirstName = :FirstName, LastName = :LastName, MiddleName = :MiddleName WHERE StudentId = :StudentId');

// To get the AccountId from student_account using studentid session
$query2 = $conn->prepare('SELECT * FROM student_account WHERE StudentId = ' . $_SESSION['studentid'] );
$query2->execute();

// Store AccountId to param3
$param3[':AccountId'] = $query2->fetch()['AccountId'];

$query3 = $conn->prepare('UPDATE account SET Pin = :Pin WHERE AccountId = :AccountId');

if ( $query->execute($param) && $query3->execute($param3) ) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>