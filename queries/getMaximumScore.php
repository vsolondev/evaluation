<?php
require_once '../connection.php';

$returnData = [
    'success' => false,
    'maximumScore' => 0
];

$totalStudents = $_POST['totalstudents'];

$getTotalQuestionsQuery = $conn->prepare(
    'SELECT COUNT(*) as totalQuestions FROM question'
);
$getTotalQuestionsQuery->execute();
$totalQuestions = $getTotalQuestionsQuery->fetch()['totalQuestions'];

$getMaxRatingValueQuery = $conn->prepare(
    'SELECT MAX(ratingValue) as MaxRatingValue FROM rating'
);

if ($getMaxRatingValueQuery->execute()) {
    $returnData['success'] = true;
    $maximumScore = ($getMaxRatingValueQuery->fetch()['MaxRatingValue'] * $totalStudents) * $totalQuestions;
    $returnData['maximumScore'] = $maximumScore;
}

echo json_encode($returnData);
?>