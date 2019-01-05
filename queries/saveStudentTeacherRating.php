<?php
require_once '../connection.php';

$data = json_decode($_POST['data']);

$returnData = [
    'success' => false
];

foreach ($data as $key => $value) {
    $getStudentTeacherRatingParam = [
        ':EvaluationId' => $value->evaluationid,
        ':QuestionId' => $value->questionid
    ];

    $getStudentTeacherRatingQuery = $conn->prepare('
        SELECT * FROM student_teacher_rating
        WHERE EvaluationId = :EvaluationId
        AND QuestionId = :QuestionId
    ');

    $getStudentTeacherRatingQuery->execute($getStudentTeacherRatingParam);
    $getStudentTeacherRatingCount = $getStudentTeacherRatingQuery->rowCount();

    if ($getStudentTeacherRatingCount > 0) {
        $updateStudentTeacherRatingParam = [
            ':EvaluationId' => $value->evaluationid,
            ':QuestionId' => $value->questionid,
            ':RatingId' => $value->ratingid
        ];

        $updateStudentTeacherRatingQuery = $conn->prepare('
            UPDATE student_teacher_rating SET RatingId = :RatingId 
            WHERE EvaluationId = :EvaluationId
            AND QuestionId = :QuestionId
        ');

        if ($updateStudentTeacherRatingQuery->execute($updateStudentTeacherRatingParam)) {
            $returnData['success'] = true;
        }
    } else {
        $addStudentTeacherRatingParam = [
            ':EvaluationId' => $value->evaluationid,
            ':QuestionId' => $value->questionid,
            ':RatingId' => $value->ratingid
        ];

        $addStudentTeacherRatingQuery = $conn->prepare('
            INSERT INTO student_teacher_rating (EvaluationId, QuestionId, RatingId) VALUES (:EvaluationId, :QuestionId, :RatingId)
        ');

        if ($addStudentTeacherRatingQuery->execute($addStudentTeacherRatingParam)) {
            $returnData['success'] = true;
        }
    }
}

echo json_encode($returnData);
?>