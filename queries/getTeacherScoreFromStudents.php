<?php
require_once '../connection.php';

$studentSSSData = json_decode($_POST['studentsssdata']);
$teacherId = $_POST['teacherid'];

$returnData = [
    'success' => false,
    'teacherScore' => 0
];

foreach ($studentSSSData as $key => $value) {
    $getEvaluationParam = [
        ':StudentId' => $value->StudentId,
        ':TeacherId' => $teacherId
    ];

    $getEvaluationQuery = $conn->prepare('
        SELECT * FROM evaluation
        WHERE StudentId = :StudentId
        AND TeacherId = :TeacherId
    ');

    $getEvaluationQuery->execute($getEvaluationParam);
    $evaluationId = $getEvaluationQuery->fetch()['EvaluationId'];

    if ($evaluationId != null) {
        $getScoreParam = [
            ':EvaluationId' => $evaluationId
        ];
    
        $getScoreQuery = $conn->prepare('
            SELECT SUM(rating.RatingValue) as TotalStudentRating FROM rating
            INNER JOIN student_teacher_rating ON student_teacher_rating.RatingId = rating.RatingId
            WHERE student_teacher_rating.EvaluationId = :EvaluationId
        ');
    
        $getScoreQuery->execute($getScoreParam);
        $totalStudentRating = $getScoreQuery->fetch()['TotalStudentRating'];

        $returnData['teacherScore'] += $totalStudentRating;
    }
}

echo json_encode($returnData);
?>