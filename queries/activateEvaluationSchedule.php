<?php
require_once '../connection.php';

$param = [
    ':EvaluationScheduleId' => $_POST['evaluationscheduleid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE evaluation_schedule SET IsActive = 0');
$query->execute();

$query = $conn->prepare('UPDATE evaluation_schedule SET IsActive = 1 WHERE EvaluationScheduleId = :EvaluationScheduleId');

if ($query->execute($param)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>