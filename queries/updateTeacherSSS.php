<?php
require_once '../connection.php';

$teacher_sss = [
    ':TeacherSectionSubjectId' => $_POST['teachersectionsubjectid'],
    ':SectionSubjectScheduleId' => $_POST['sectionsubjectscheduleid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE teacher_sss SET SectionSubjectScheduleId = :SectionSubjectScheduleId WHERE TeacherSectionSubjectId = :TeacherSectionSubjectId');

if ($query->execute($teacher_sss)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>