<?php
require_once '../connection.php';

$student = [
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':MiddleName' => $_POST['middlename'],
    ':YearLevelId' => $_POST['yearlevelid'],
    ':DepartmentId' => $_POST['departmentid'],
    ':CourseId' => $_POST['courseid']
];

$account = [
    ':Username' => $_POST['username'],
    ':Password' => $_POST['password'],
    ':Pin' => $_POST['pin'],
    ':IsLocked' => 0
];

$student_account = [
    ':StudentId' => null,
    ':AccountId' => null
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO student (FirstName, LastName, MiddleName, YearLevelId, DepartmentId, CourseId) VALUES (:FirstName, :LastName, :MiddleName, :YearLevelId, :DepartmentId, :CourseId)');
$query->execute($student);
$student_account[':StudentId'] = $conn->lastInsertId();

$query = $conn->prepare('INSERT INTO account (Username, Password, Pin, IsLocked) VALUES (:Username, :Password, :Pin, :IsLocked)');
$query->execute($account);
$student_account[':AccountId'] = $conn->lastInsertId();

$query = $conn->prepare('INSERT INTO student_account (StudentId, AccountId) VALUES (:StudentId, :AccountId)');
if ($query->execute($student_account)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>