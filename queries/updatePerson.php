<?php
require_once '../connection.php';

$person = [
    ':PersonId' => $_POST['personid'],
    ':FirstName' => $_POST['firstname'],
    ':LastName' => $_POST['lastname'],
    ':Age' => $_POST['age']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE person SET FirstName = :FirstName, LastName = :LastName, Age = :Age WHERE PersonId = :PersonId');

if ($query->execute($person)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>