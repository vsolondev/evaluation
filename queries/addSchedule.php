<?php
require_once '../connection.php';

$schedule = [
    ':ScheduleDateFrom' => $_POST['scheduledatefrom'],
    ':ScheduleTimeFrom' => $_POST['scheduletimefrom'],
    ':ScheduleDateTo' => $_POST['scheduledateto'],
    ':ScheduleTimeTo' => $_POST['scheduletimeto']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO schedule (ScheduleDateFrom, ScheduleTimeFrom, ScheduleDateTo, ScheduleTimeTo) VALUES (:ScheduleDateFrom, :ScheduleTimeFrom, :ScheduleDateTo, :ScheduleTimeTo)');
if ($query->execute($schedule)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>