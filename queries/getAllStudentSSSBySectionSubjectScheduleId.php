<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$param = [
    ':SectionSubjectScheduleId' => $_POST['sectionsubjectscheduleid']
];

$query = $conn->prepare(
    'SELECT * FROM student_sss
    WHERE SectionSubjectScheduleId = :SectionSubjectScheduleId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>