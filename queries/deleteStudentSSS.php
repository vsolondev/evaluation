<?php
require_once '../connection.php';

$student_sss = [
    ':StudentSectionSubjectId' => $_POST['studentsectionsubjectid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM student_sss WHERE StudentSectionSubjectId = :StudentSectionSubjectId');

if ($query->execute($student_sss)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>