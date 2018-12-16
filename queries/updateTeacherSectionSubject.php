<?php
require_once '../connection.php';

$teacher_section_subject = [
    ':TeacherSectionSubjectId' => $_POST['teachersectionsubjectid'],
    ':SectionId' => $_POST['sectionid'],
    ':SubjectId' => $_POST['subjectid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE teacher_section_subject SET SectionId = :SectionId, SubjectId = :SubjectId WHERE TeacherSectionSubjectId = :TeacherSectionSubjectId');

if ($query->execute($teacher_section_subject)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>