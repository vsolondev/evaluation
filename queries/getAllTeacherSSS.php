<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$query = $conn->prepare(
    'SELECT * FROM teacher_sss
    INNER JOIN section_subject_schedule ON section_subject_schedule.SectionSubjectScheduleId = teacher_sss.SectionSubjectScheduleId
    INNER JOIN section ON section.SectionId = section_subject_schedule.SectionId
    INNER JOIN subject ON subject.SubjectId = section_subject_schedule.SubjectId
    INNER JOIN schedule ON schedule.ScheduleId = section_subject_schedule.ScheduleId'
);

if ($query->execute()) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>