<?php
require_once '../connection.php';

$section_subject_schedule = [
    ':SectionSubjectScheduleId' => $_POST['sectionsubjectscheduleid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM section_subject_schedule WHERE SectionSubjectScheduleId = :SectionSubjectScheduleId');

if ($query->execute($section_subject_schedule)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>