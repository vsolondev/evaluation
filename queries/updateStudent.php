<?php
require_once '../connection.php';

$student = [
    ':StudentId' => $_POST['studentid'],
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':MiddleName' => $_POST['middlename'],
    ':YearLevelId' => $_POST['yearlevelid'],
    ':DepartmentId' => $_POST['departmentid'],
    ':CourseId' => $_POST['courseid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE student SET FirstName = :FirstName, LastName = :LastName, MiddleName = :MiddleName, YearLevelId = :YearLevelId, DepartmentId = :DepartmentId, CourseId = :CourseId  WHERE StudentId = :StudentId');

if ($query->execute($student)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>