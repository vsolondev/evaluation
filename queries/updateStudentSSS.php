<?php
require_once '../connection.php';

$student_sss = [
    ':StudentSectionSubjectId' => $_POST['studentsectionsubjectid'],
    ':SectionSubjectScheduleId' => $_POST['sectionsubjectscheduleid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE student_sss SET SectionSubjectScheduleId = :SectionSubjectScheduleId WHERE StudentSectionSubjectId = :StudentSectionSubjectId');

if ($query->execute($student_sss)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>