<?php
require_once '../connection.php';

$admin = [
    ':AdminId' => $_POST['adminid'],
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':MiddleName' => $_POST['middlename']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE admin SET FirstName = :FirstName, LastName = :LastName, MiddleName = :MiddleName WHERE AdminId = :AdminId');

if ($query->execute($admin)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>