<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$param = [
    ':EvaluationId' => $_POST['evaluationid'],
    ':QuestionId' => $_POST['questionid']
];

$query = $conn->prepare(
    'SELECT * FROM student_teacher_rating WHERE EvaluationId = :EvaluationId AND QuestionId = :QuestionId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetch();
}

echo json_encode($returnData);
?>