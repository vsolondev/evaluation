<?php
require_once '../connection.php';
session_start();

$returnData = [
    'success' => false,
    'isAlreadyEvaluated' => false,
    'questionId' => 0
];

$getAllTeachersParam = [
    ':StudentId' => $_SESSION['studentid']
];

$getAllTeachersQuery = $conn->prepare(
    'SELECT * FROM student_sss
    INNER JOIN section_subject_schedule ON section_subject_schedule.SectionSubjectScheduleId = student_sss.SectionSubjectScheduleId
    INNER JOIN teacher ON teacher.TeacherId = section_subject_schedule.TeacherId
    WHERE student_sss.StudentId = :StudentId'
);

$getAllTeachersQuery->execute($getAllTeachersParam);
$teachers = $getAllTeachersQuery->fetchAll();

$getActiveScheduleQuery = $conn->prepare(
    'SELECT * FROM evaluation_schedule WHERE IsActive = 1'
);
$getActiveScheduleQuery->execute();
$evaluation_schedule = $getActiveScheduleQuery->fetch();

foreach ($teachers as $key => $value) {
    $evaluationParam = [
        ':StudentId' => $_SESSION['studentid'],
        ':TeacherId' => $value['TeacherId'],
        ':EvaluationScheduleId' => $evaluation_schedule['EvaluationScheduleId']
    ];

    $getEvaluationQuery = $conn->prepare(
        'SELECT * FROM evaluation 
        WHERE StudentId = :StudentId AND TeacherId = :TeacherId AND EvaluationScheduleId = :EvaluationScheduleId'
    );
    $getEvaluationQuery->execute($evaluationParam);
    $getEvaluationCount = $getEvaluationQuery->rowCount();

    if ($getEvaluationCount > 0) {
        $returnData['isAlreadyEvaluated'] = true;
        $returnData['success'] = true;
        break;
    } else {
        $returnData['isAlreadyEvaluated'] = false;

        $addEvaluationQuery = $conn->prepare(
            'INSERT INTO evaluation (StudentId, TeacherId, EvaluationScheduleId) VALUES (:StudentId, :TeacherId, :EvaluationScheduleId)'
        );

        if ($addEvaluationQuery->execute($evaluationParam)) {
            $returnData['success'] = true;
        }
    }
}

if ($returnData['success'] == true) {
    $getFirstQuestionQuery = $conn->prepare(
        'SELECT * FROM `question` ORDER BY QuestionId ASC LIMIT 1'
    );

    $getFirstQuestionQuery->execute();
    $returnData['questionId'] = $getFirstQuestionQuery->fetch()['QuestionId'];
}

echo json_encode($returnData);
?>