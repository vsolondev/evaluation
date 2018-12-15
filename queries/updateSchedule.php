<?php
require_once '../connection.php';

$schedule = [
    ':ScheduleId' => $_POST['scheduleid'],
    ':ScheduleDay' => $_POST['scheduleday'],
    ':ScheduleTimeFrom' => $_POST['scheduletimefrom'],
    ':ScheduleTimeTo' => $_POST['scheduletimeto']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE schedule SET ScheduleDay = :ScheduleDay, ScheduleTimeFrom = :ScheduleTimeFrom, ScheduleTimeTo = :ScheduleTimeTo WHERE ScheduleId = :ScheduleId');

if ($query->execute($schedule)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>