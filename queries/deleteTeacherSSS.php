<?php
require_once '../connection.php';

$teacher_sss = [
    ':TeacherSectionSubjectId' => $_POST['teachersectionsubjectid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM teacher_sss WHERE TeacherSectionSubjectId = :TeacherSectionSubjectId');

if ($query->execute($teacher_sss)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>