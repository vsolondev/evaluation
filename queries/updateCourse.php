<?php
require_once '../connection.php';

$course = [
    ':CourseId' => $_POST['courseid'],
    ':CourseName' => $_POST['coursename'],
    ':CourseAcronym' => $_POST['courseacronym']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE course SET CourseName = :CourseName, CourseAcronym = :CourseAcronym WHERE CourseId = :CourseId');

if ($query->execute($course)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>