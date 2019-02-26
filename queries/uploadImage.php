<?php
require_once '../connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$returnData = [
    'success' => false
];

$accountId = 0;

if (isset($_POST['accountid'])) {
    $accountId = $_POST['accountid'];
} else {
    $accountId = $_SESSION['accountid'];
}

// Get files
$imageName = $_FILES['file']['name'];

// Get only the extension (jpg,jpeg,gif,png) and remove image name
$extension = end(explode('.', $imageName));

// Generate new name (To prevent the same image name)
$newImageName = rand() . '.' . $extension;

// Path where the file is uploaded (check on user_images folder)
$path = $_SERVER['DOCUMENT_ROOT'] . '/evaluation/user_images/' . $newImageName;

// Move the uploaded file
if (move_uploaded_file($_FILES['file']['tmp_name'], $path)) {

    // Check If Account already uploaded image
    // If it has uploaded, just update the ImageName
    // else insert new record
    $getAccountImageParam = [
        ':AccountId' => $accountId
    ];

    $getAccountImageQuery = $conn->prepare('SELECT * FROM accountimage WHERE AccountId = :AccountId');
    $getAccountImageQuery->execute($getAccountImageParam);
    $count = $getAccountImageQuery->rowCount();


    $accountImageParam = [
        ':AccountId' => $accountId,
        ':ImageName' => $newImageName
    ];
    
    if ($count > 0) {
        // Update ImageName by AccountId
        $query = $conn->prepare('UPDATE accountimage SET ImageName = :ImageName WHERE AccountId = :AccountId');
        
        if ($query->execute($accountImageParam)) {
            $returnData['success'] = true;
        }
    } else {
        // Insert new record
        $query = $conn->prepare('INSERT INTO accountimage (AccountId, ImageName) VALUES (:AccountId, :ImageName)');
        
        if ($query->execute($accountImageParam)) {
            $returnData['success'] = true;
        }
    }

}

echo json_encode($returnData);

?>