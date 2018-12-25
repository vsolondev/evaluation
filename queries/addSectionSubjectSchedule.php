<?php
require_once '../connection.php';

$section_subject_schedule = [
    ':SectionId' => $_POST['sectionid'],
    ':SubjectId' => $_POST['subjectid'],
    ':ScheduleId' => $_POST['scheduleid'],
    ':TeacherId' => null
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO section_subject_schedule (SectionId, SubjectId, ScheduleId, TeacherId) VALUES (:SectionId, :SubjectId, :ScheduleId, :TeacherId)');
if ($query->execute($section_subject_schedule)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>