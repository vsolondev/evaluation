<?php
require_once '../connection.php';

$teacher_section_subject = [
    ':TeacherId' => $_POST['teacherid'],
    ':SectionId' => $_POST['sectionid'],
    ':SubjectId' => $_POST['subjectid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO teacher_section_subject (TeacherId, SectionId, SubjectId) VALUES (:TeacherId, :SectionId, :SubjectId)');
if ($query->execute($teacher_section_subject)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>