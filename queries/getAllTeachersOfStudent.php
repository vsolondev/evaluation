<?php
require_once '../connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$returnData = [
    'success' => false,
    'data' => []
];

$param = [
    ':StudentId' => $_SESSION['studentid']
];

$query = $conn->prepare(
    'SELECT * FROM student_sss
    INNER JOIN section_subject_schedule ON section_subject_schedule.SectionSubjectScheduleId = student_sss.SectionSubjectScheduleId
    INNER JOIN section ON section.SectionId = section_subject_schedule.SectionId
    INNER JOIN subject ON subject.SubjectId = section_subject_schedule.SubjectId
    INNER JOIN schedule ON schedule.ScheduleId = section_subject_schedule.ScheduleId
    INNER JOIN teacher ON teacher.TeacherId = section_subject_schedule.TeacherId
    INNER JOIN teacher_account ON teacher_account.TeacherId = teacher.TeacherId
    INNER JOIN evaluation ON evaluation.TeacherId = section_subject_schedule.TeacherId AND evaluation.StudentId = :StudentId
    WHERE student_sss.StudentId = :StudentId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>