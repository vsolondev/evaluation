<?php
require_once '../connection.php';

$student_section_subject = [
    ':StudentSectionSubjectId' => $_POST['studentsectionsubjectid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM student_section_subject WHERE StudentSectionSubjectId = :StudentSectionSubjectId');

if ($query->execute($student_section_subject)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>