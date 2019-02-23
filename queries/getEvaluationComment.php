<?php
require_once '../connection.php';

$param = [
    ':StudentId' => $_POST['studentid'],
    ':TeacherId' => $_POST['teacherid']
];

$returnData = [
    'success' => false,
    'data' => []
];

$query = $conn->prepare(
    'SELECT GoodComment, BadComment FROM evaluation WHERE StudentId = :StudentId AND TeacherId = :TeacherId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetch();
}

echo json_encode($returnData);
?>