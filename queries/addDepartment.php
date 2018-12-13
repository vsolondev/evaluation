<?php
require_once '../connection.php';

$department = [
    ':DepartmentName' => $_POST['departmentname']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO department (DepartmentName) VALUES (:DepartmentName)');
if ($query->execute($department)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>