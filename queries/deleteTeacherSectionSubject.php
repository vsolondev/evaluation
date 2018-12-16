<?php
require_once '../connection.php';

$teacher_section_subject = [
    ':TeacherSectionSubjectId' => $_POST['teachersectionsubjectid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM teacher_section_subject WHERE TeacherSectionSubjectId = :TeacherSectionSubjectId');

if ($query->execute($teacher_section_subject)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>