<?php
require_once '../connection.php';

$teacher_sss = [
    ':TeacherId' => $_POST['teacherid'],
    ':SectionSubjectScheduleId' => $_POST['sectionsubjectscheduleid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO teacher_sss (TeacherId, SectionSubjectScheduleId) VALUES (:TeacherId, :SectionSubjectScheduleId)');
if ($query->execute($teacher_sss)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>