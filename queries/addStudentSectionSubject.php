<?php
require_once '../connection.php';

$student_section_subject = [
    ':StudentId' => $_POST['studentid'],
    ':SectionId' => $_POST['sectionid'],
    ':SubjectId' => $_POST['subjectid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO student_section_subject (StudentId, SectionId, SubjectId) VALUES (:StudentId, :SectionId, :SubjectId)');
if ($query->execute($student_section_subject)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>