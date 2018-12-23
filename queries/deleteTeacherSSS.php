<?php
require_once '../connection.php';

$teacher_sss = [
    ':TeacherSectionId' => $_POST['teachersectionid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM teacher_sss WHERE TeacherSectionId = :TeacherSectionId');

if ($query->execute($teacher_sss)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>