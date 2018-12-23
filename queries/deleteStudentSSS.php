<?php
require_once '../connection.php';

$student_sss = [
    ':StudentSectionId' => $_POST['studentsectionid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM student_sss WHERE StudentSectionId = :StudentSectionId');

if ($query->execute($student_sss)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>