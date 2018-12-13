<?php
require_once '../connection.php';

$department = [
    ':DepartmentId' => $_POST['departmentid'],
    ':DepartmentName' => $_POST['departmentname']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE department SET DepartmentName = :DepartmentName WHERE DepartmentId = :DepartmentId');

if ($query->execute($department)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>