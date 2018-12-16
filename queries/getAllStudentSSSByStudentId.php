<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$student_sss = [
    ':StudentId' => $_POST['studentid']
];

$query = $conn->prepare(
    'SELECT * FROM student_sss
    INNER JOIN section_subject_schedule ON section_subject_schedule.SectionSubjectScheduleId = student_sss.SectionSubjectScheduleId
    INNER JOIN section ON section.SectionId = section_subject_schedule.SectionId
    INNER JOIN subject ON subject.SubjectId = section_subject_schedule.SubjectId
    WHERE StudentId = :StudentId'
);

if ($query->execute($student_sss)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>