<?php
require_once '../connection.php';

$schedule = [
    ':ScheduleDay' => $_POST['scheduleday'],
    ':ScheduleTimeFrom' => $_POST['scheduletimefrom'],
    ':ScheduleTimeTo' => $_POST['scheduletimeto']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO schedule (ScheduleDay, ScheduleTimeFrom, ScheduleTimeTo) VALUES (:ScheduleDay, :ScheduleTimeFrom, :ScheduleTimeTo)');
if ($query->execute($schedule)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>