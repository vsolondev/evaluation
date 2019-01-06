<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$param = [
    ':TeacherId' => $_POST['teacherid']
];

$query = $conn->prepare(
    'SELECT * FROM teacher WHERE TeacherId = :TeacherId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetch();
}

echo json_encode($returnData);
?>