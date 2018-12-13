<?php
require_once '../connection.php';

$section = [
    ':SectionName' => $_POST['sectionname']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('INSERT INTO section (SectionName) VALUES (:SectionName)');
if ($query->execute($section)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>