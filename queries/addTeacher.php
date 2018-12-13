<?php
require_once '../connection.php';

$teacher = [
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':MiddleName' => $_POST['middlename'],
    ':DepartmentId' => $_POST['departmentid']
];

$account = [
    ':Username' => $_POST['username'],
    ':Password' => $_POST['password'],
    ':Pin' => $_POST['pin'],
    ':IsLocked' => 0
];

$teacher_account = [
    ':TeacherId' => null,
    ':AccountId' => null
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO teacher (FirstName, LastName, MiddleName, DepartmentId) VALUES (:FirstName, :LastName, :MiddleName, :DepartmentId)');
$query->execute($teacher);
$teacher_account[':TeacherId'] = $conn->lastInsertId();

$query = $conn->prepare('INSERT INTO account (Username, Password, Pin, IsLocked) VALUES (:Username, :Password, :Pin, :IsLocked)');
$query->execute($account);
$teacher_account[':AccountId'] = $conn->lastInsertId();

$query = $conn->prepare('INSERT INTO teacher_account (TeacherId, AccountId) VALUES (:TeacherId, :AccountId)');
if ($query->execute($teacher_account)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>