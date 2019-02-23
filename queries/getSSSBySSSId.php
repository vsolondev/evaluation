<?php 
require_once '../connection.php';

$param = [
    ':SectionSubjectScheduleId' => $_POST['sssid']
];

$returnData = [
    'success' => false,
    'data' => []
];

$query = $conn->prepare(
    'SELECT * FROM section_subject_schedule
    INNER JOIN section ON section.SectionId = section_subject_schedule.SectionId
    INNER JOIN subject ON subject.SubjectId = section_subject_schedule.SubjectId
    INNER JOIN schedule ON schedule.ScheduleId = section_subject_schedule.ScheduleId
    INNER JOIN teacher ON teacher.TeacherId = section_subject_schedule.TeacherId
    WHERE section_subject_schedule.SectionSubjectScheduleId = :SectionSubjectScheduleId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetch();
}

echo json_encode($returnData);

?>