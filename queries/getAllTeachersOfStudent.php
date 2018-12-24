<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$param = [
    ':StudentId' => $_POST['studentid']
];

$query = $conn->prepare(
    'SELECT * FROM student_sss
    INNER JOIN teacher_sss ON teacher_sss.SectionSubjectScheduleId = student_sss.SectionSubjectScheduleId
    INNER JOIN teacher ON teacher.TeacherId = teacher_sss.TeacherId
    INNER JOIN section_subject_schedule ON section_subject_schedule.SectionSubjectScheduleId = student_sss.SectionSubjectScheduleId
    INNER JOIN section ON section.SectionId = section_subject_schedule.SectionId
    INNER JOIN subject ON subject.SubjectId = section_subject_schedule.SubjectId
    INNER JOIN schedule ON schedule.ScheduleId = section_subject_schedule.ScheduleId
    WHERE student_sss.StudentId = :StudentId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>