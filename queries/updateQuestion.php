<?php
require_once '../connection.php';

$question = [
    ':QuestionId' => $_POST['questionid'],
    ':Question' => $_POST['question']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE question SET Question = :Question WHERE QuestionId = :QuestionId');

if ($query->execute($question)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>