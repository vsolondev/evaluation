<?php
require_once '../connection.php';

$rating = [
    ':RatingDescription' => $_POST['ratingdescription'],
    ':RatingValue' => $_POST['ratingvalue'],
    ':IsActive' => 1
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO rating (RatingDescription, RatingValue, IsActive) VALUES (:RatingDescription, :RatingValue, :IsActive)');
if ($query->execute($rating)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>