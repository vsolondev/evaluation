<?php
require_once '../connection.php';

$param = [
    ':Username' => $_POST['username'],
    ':Pin' => $_POST['pin']
];

$returnData = [
    'success' => false,
    'password' => ''
];

$query = $conn->prepare(
    'SELECT * FROM account WHERE Username = :Username AND Pin = :Pin'
);

$query->execute($param);
$count = $query->rowCount();

if ($count > 0) {
    $returnData['success'] = true;
    $returnData['password'] = $query->fetch()['Password'];
}

echo json_encode($returnData);
?>