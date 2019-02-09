<?php
require_once '../global.php';

session_start();

$role = $_SESSION['role'];

session_destroy();

if ($role == 'ADMIN') {
    header("Location: " . base_url("view/admin/login.php"));
} else if ($role == 'STUDENT') {
    header("Location: " . base_url("view/student/login.php"));
} else if ($role == 'TEACHER') {
    header("Location: " . base_url("view/teacher/login.php"));
}

exit();

?>