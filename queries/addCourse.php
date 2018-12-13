<?php
require_once '../connection.php';

$course = [
    ':CourseName' => $_POST['coursename'],
    ':CourseAcronym' => $_POST['courseacronym']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO course (CourseName, CourseAcronym) VALUES (:CourseName, :CourseAcronym)');
if ($query->execute($course)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>