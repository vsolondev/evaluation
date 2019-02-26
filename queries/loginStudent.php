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
    'SELECT * FROM student_account
	INNER JOIN account ON account.AccountId = student_account.AccountId
	INNER JOIN student ON student.StudentId = student_account.StudentId
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
    $_SESSION['studentid'] = $data['StudentId'];
    $_SESSION['role'] = 'STUDENT';
}

echo json_encode($returnData);
?>