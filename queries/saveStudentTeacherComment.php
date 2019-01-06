<?php
require_once '../connection.php';

$data = json_decode($_POST['data']);

$returnData = [
    'success' => false
];

foreach ($data as $key => $value) {
    $param = [
        ':EvaluationId' => $value->evaluationid,
        ':GoodComment' => $value->goodcomment,
        ':BadComment' => $value->badcomment
    ];

    $query = $conn->prepare('
        UPDATE evaluation 
        SET GoodComment = :GoodComment, BadComment = :BadComment 
        WHERE EvaluationId = :EvaluationId
    ');

    if ($query->execute($param)) {
        $returnData['success'] = true;
    }
}

echo json_encode($returnData);
?>