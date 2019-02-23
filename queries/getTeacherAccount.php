<?php
require_once '../connection.php';

session_start();

$param = [
    ':TeacherId' => $_SESSION['teacherid']
];

$returnData = [
    'success' => false,
    'data' => []
];

$query = $conn->prepare(
    'SELECT * FROM teacher 
    INNER JOIN teacher_account ON teacher.TeacherId = teacher_account.TeacherId
    INNER JOIN account ON account.AccountId = teacher_account.AccountId
    WHERE teacher.TeacherId = :TeacherId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetch();
}

echo json_encode($returnData);
?>