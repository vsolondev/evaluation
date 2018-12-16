<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$student_section_subject = [
    ':StudentId' => $_POST['studentid']
];

$query = $conn->prepare(
    'SELECT * FROM student_section_subject
    INNER JOIN section ON section.SectionId = student_section_subject.SectionId
    INNER JOIN subject ON subject.SubjectId = student_section_subject.SubjectId
    WHERE StudentId = :StudentId'
);

if ($query->execute($student_section_subject)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>