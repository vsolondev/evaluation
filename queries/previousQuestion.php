<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$param = [
    ':QuestionId' => $_POST['questionid']
];

$query = $conn->prepare(
    'SELECT * FROM question WHERE QuestionId = (SELECT MAX(QuestionId) from question WHERE QuestionId < :QuestionId)'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetch();
}

echo json_encode($returnData);
?>