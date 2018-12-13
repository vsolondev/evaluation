<?php
require_once '../connection.php';

$yearlevel = [
    ':YearLevel' => $_POST['yearlevel']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO yearlevel (YearLevel) VALUES (:YearLevel)');
if ($query->execute($yearlevel)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>