<?php
require_once '../connection.php';

$admin = [
    ':AdminId' => $_POST['adminid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM admin WHERE AdminId = :AdminId');

if ($query->execute($admin)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>