<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$teacher_section_subject = [
    ':TeacherId' => $_POST['teacherid']
];

$query = $conn->prepare(
    'SELECT * FROM teacher_section_subject
    INNER JOIN section ON section.SectionId = teacher_section_subject.SectionId
    INNER JOIN subject ON subject.SubjectId = teacher_section_subject.SubjectId
    WHERE TeacherId = :TeacherId'
);

if ($query->execute($teacher_section_subject)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>