<?php

function base_url($url = '') {
    return 'http://localhost:81/evaluation/' . $url;
}

function is_student() {
    session_start();

    $role = $_SESSION['role'];

    if ( ISSET($role) == false || $role != 'STUDENT' ) {
        header("Location: " . base_url("view/error/notallowed.php")); /* Redirect browser */
        exit();
    }
}

function is_teacher() {
    session_start();

    $role = $_SESSION['role'];

    if ( ISSET($role) == false || $role != 'TEACHER' ) {
        header("Location: " . base_url("view/error/notallowed.php")); /* Redirect browser */
        exit();
    }
}

function is_admin() {
    session_start();

    $role = $_SESSION['role'];

    if ( ISSET($role) == false || $role != 'ADMIN' ) {
        header("Location: " . base_url("view/error/notallowed.php")); /* Redirect browser */
        exit();
    }
}

?>