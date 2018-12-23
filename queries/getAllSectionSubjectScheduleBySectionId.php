<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$section_subject_schedule = [
    ':SectionId' => $_POST['sectionid']
];

$query = $conn->prepare(
    'SELECT * FROM section_subject_schedule
    INNER JOIN section ON section.SectionId = section_subject_schedule.SectionId
    INNER JOIN subject ON subject.SubjectId = section_subject_schedule.SubjectId
    INNER JOIN schedule ON schedule.ScheduleId = section_subject_schedule.ScheduleId
    WHERE section_subject_schedule.SectionId = :SectionId'
);

if ($query->execute($section_subject_schedule)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>