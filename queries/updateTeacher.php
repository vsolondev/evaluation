<?php
require_once '../connection.php';

$teacher = [
    ':TeacherId' => $_POST['teacherid'],
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':MiddleName' => $_POST['middlename'],
    ':DepartmentId' => $_POST['departmentid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE teacher SET FirstName = :FirstName, LastName = :LastName, MiddleName = :MiddleName, DepartmentId = :DepartmentId WHERE TeacherId = :TeacherId');

if ($query->execute($teacher)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>