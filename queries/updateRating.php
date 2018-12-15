<?php
require_once '../connection.php';

$rating = [
    ':RatingId' => $_POST['ratingid'],
    ':RatingDescription' => $_POST['ratingdescription'],
    ':RatingValue' => $_POST['ratingvalue']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE rating SET RatingDescription = :RatingDescription, RatingValue = :RatingValue WHERE RatingId = :RatingId');

if ($query->execute($rating)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>