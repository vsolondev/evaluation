<?php
require_once '../connection.php';

$schedule = [
    ':ScheduleId' => $_POST['scheduleid'],
    ':ScheduleDateFrom' => $_POST['scheduledatefrom'],
    ':ScheduleTimeFrom' => $_POST['scheduletimefrom'],
    ':ScheduleDateTo' => $_POST['scheduledateto'],
    ':ScheduleTimeTo' => $_POST['scheduletimeto']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE schedule SET ScheduleDateFrom = :ScheduleDateFrom, ScheduleTimeFrom = :ScheduleTimeFrom, ScheduleDateTo = :ScheduleDateTo, ScheduleTimeTo = :ScheduleTimeTo WHERE ScheduleId = :ScheduleId');

if ($query->execute($schedule)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>