<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'data' => []
];

$query = $conn->prepare(
    'SELECT * FROM student
    INNER JOIN yearlevel ON student.YearLevelId = yearlevel.YearLevelId
    INNER JOIN department ON student.DepartmentId = department.DepartmentId
    INNER JOIN course ON student.CourseId = course.CourseId'
);

if ($query->execute()) {
    $returnData['success'] = true;
    $returnData['data'] = $query->fetchAll();
}

echo json_encode($returnData);
?>