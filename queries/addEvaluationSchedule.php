<?php
require_once '../connection.php';

$evaluation_schedule = [
    ':ScheduleDateFrom' => $_POST['scheduledatefrom'],
    ':ScheduleDateTo' => $_POST['scheduledateto']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO evaluation_schedule (ScheduleDateFrom, ScheduleDateTo) VALUES (:ScheduleDateFrom, :ScheduleDateTo)');
if ($query->execute($evaluation_schedule)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>