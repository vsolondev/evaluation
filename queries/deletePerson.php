<?php
require_once '../connection.php';

$person = [
    ':PersonId' => $_POST['personid']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('DELETE FROM person WHERE PersonId = :PersonId');

if ($query->execute($person)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>