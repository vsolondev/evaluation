<?php
require_once '../connection.php';

$subject = [
    ':SubjectId' => $_POST['subjectid'],
    ':SubjectName' => $_POST['subjectname'],
    ':SubjectAcronym' => $_POST['subjectacronym']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE subject SET SubjectName = :SubjectName, SubjectAcronym = :SubjectAcronym WHERE SubjectId = :SubjectId');

if ($query->execute($subject)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>