<?php
require_once '../connection.php';

$question = [
    ':Question' => $_POST['question'],
    ':IsActive' => 1
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO question (Question, IsActive) VALUES (:Question, :IsActive)');
if ($query->execute($question)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>