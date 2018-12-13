<?php
require_once '../connection.php';

$yearlevel = [
    ':YearLevelId' => $_POST['yearlevelid'],
    ':YearLevel' => $_POST['yearlevel']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE yearlevel SET YearLevel = :YearLevel WHERE YearLevelId = :YearLevelId');

if ($query->execute($yearlevel)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>