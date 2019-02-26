<?php
require_once '../connection.php';
require_once '../global.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$accountId = 0;

if (isset($_POST['accountid'])) {
    $accountId = $_POST['accountid'];
} else {
    $accountId = $_SESSION['accountid'];
}

$param = [
    ':AccountId' => $accountId
];

$returnData = [
    'success' => false,
    'image' => ''
];

$query = $conn->prepare(
    'SELECT * FROM accountimage WHERE AccountId = :AccountId'
);

if ($query->execute($param)) {
    $returnData['success'] = true;

    // Get Image path from user_image folder
    $imagePath = base_url() . '/user_images/' . $query->fetch()['ImageName'];
    $returnData['image'] = $imagePath;
}

echo json_encode($returnData);
?>