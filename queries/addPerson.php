<?php
require_once '../connection.php';

$person = [
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':Age' => $_POST['age']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO person (FirstName, LastName, Age) VALUES (:FirstName, :LastName, :Age)');

if ($query->execute($person)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>