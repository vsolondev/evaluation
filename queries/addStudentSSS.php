<?php
require_once '../connection.php';

$student_sss = [
    ':StudentId' => $_POST['studentid'],
    ':SectionSubjectScheduleId' => $_POST['sectionsubjectscheduleid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO student_sss (StudentId, SectionSubjectScheduleId) VALUES (:StudentId, :SectionSubjectScheduleId)');
if ($query->execute($student_sss)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>