<?php
require_once '../connection.php';

$section_subject_schedule = [
    ':SectionSubjectScheduleId' => $_POST['sectionsubjectscheduleid'],
    ':SubjectId' => $_POST['subjectid'],
    ':ScheduleId' => $_POST['scheduleid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE section_subject_schedule SET SubjectId = :SubjectId, ScheduleId = :ScheduleId WHERE SectionSubjectScheduleId = :SectionSubjectScheduleId');

if ($query->execute($section_subject_schedule)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>