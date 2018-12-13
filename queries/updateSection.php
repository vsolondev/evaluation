<?php
require_once '../connection.php';

$section = [
    ':SectionId' => $_POST['sectionid'],
    ':SectionName' => $_POST['sectionname']
];

$returnData = [
    'success' => false
];

$query = $conn->prepare('UPDATE section SET SectionName = :SectionName WHERE SectionId = :SectionId');

if ($query->execute($section)) {
    $returnData['success'] = true;
}

echo json_encode($returnData);
?>