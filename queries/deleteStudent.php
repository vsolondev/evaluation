<?php
require_once '../connection.php';

$student = [
    ':StudentId' => $_POST['studentid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM student WHERE StudentId = :StudentId');

if ($query->execute($student)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>