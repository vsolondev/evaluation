<?php
require_once '../connection.php';

$param = [
    ':SectionSubjectScheduleId' => $_POST['sectionsubjectscheduleid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE section_subject_schedule SET TeacherId = NULL WHERE SectionSubjectScheduleId = :SectionSubjectScheduleId');

if ($query->execute($param)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>