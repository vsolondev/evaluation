<?php
require_once '../connection.php';

$returnData = [
    'success' => false
];

$param = [
    'Username' => $_POST['username'],
    'Password' => $_POST['password']
];

$query = $conn->prepare(
    'SELECT * FROM teacher_account
	INNER JOIN account ON account.AccountId = teacher_account.AccountId
	INNER JOIN teacher ON teacher.TeacherId = teacher_account.TeacherId
    WHERE Username = :Username AND
    Password = :Password'
);

$query->execute($param);
$count = $query->rowCount();

if ($count == 1) {
    $returnData['success'] = true;

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    session_unset();

    $data = $query->fetch();
    $_SESSION['accountid'] = $data['AccountId'];
    $_SESSION['teacherid'] = $data['TeacherId'];
    $_SESSION['role'] = 'TEACHER';
}

echo json_encode($returnData);
?>