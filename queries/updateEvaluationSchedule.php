<?php
require_once '../connection.php';

$evaluation_schedule = [
    ':EvaluationScheduleId' => $_POST['evaluationscheduleid'],
    ':ScheduleDateFrom' => $_POST['scheduledatefrom'],
    ':ScheduleDateTo' => $_POST['scheduledateto']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE evaluation_schedule SET ScheduleDateFrom = :ScheduleDateFrom, ScheduleDateTo = :ScheduleDateTo WHERE EvaluationScheduleId = :EvaluationScheduleId');

if ($query->execute($evaluation_schedule)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>