<?php
require_once '../connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$param = [
    ':StudentId' => $_SESSION['studentid']
];

$returnData = [
    'success' => false,
    'data' => []
];

$query = $conn->prepare(
    'SELECT * FROM student 
    INNER JOIN student_account ON student.StudentId = student_account.StudentId
    INNER JOIN account ON account.AccountId = student_account.AccountId
    WHERE student.StudentId = :StudentId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetch();
}

echo json_encode($returnData);
?>