<?php
require_once '../connection.php';

$param = [
    ':AdminId' => $_POST['adminid'],
    ':Image' => addSlashes( file_get_contents($_FILES['image']['tmp_name']) )
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE admin SET Image = :Image WHERE AdminId = :AdminId');

if ($query->execute($param)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>