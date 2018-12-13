<?php
require_once '../connection.php';

$subject = [
    ':SubjectName' => $_POST['subjectname'],
    ':SubjectAcronym' => $_POST['subjectacronym']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO subject (SubjectName, SubjectAcronym) VALUES (:SubjectName, :SubjectAcronym)');
if ($query->execute($subject)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>