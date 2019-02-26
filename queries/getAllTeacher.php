<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$query = $conn->prepare(
    'SELECT * FROM teacher 
    INNER JOIN department ON teacher.DepartmentId = department.DepartmentId
    INNER JOIN teacher_account ON teacher_account.TeacherId = teacher.TeacherId
    INNER JOIN account ON account.AccountId = teacher_account.AccountId'
);

if ($query->execute()) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>