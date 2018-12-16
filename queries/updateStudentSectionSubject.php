<?php
require_once '../connection.php';

$student_section_subject = [
    ':StudentSectionSubjectId' => $_POST['studentsectionsubjectid'],
    ':SectionId' => $_POST['sectionid'],
    ':SubjectId' => $_POST['subjectid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE student_section_subject SET SectionId = :SectionId, SubjectId = :SubjectId WHERE StudentSectionSubjectId = :StudentSectionSubjectId');

if ($query->execute($student_section_subject)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>