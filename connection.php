<?php
    $conn = null;
    try {
        $conn = new PDO('mysql:host=localhost;dbname=evaluation', 'root', '');
    }
    catch(PDOException $err) {
        echo 'ERROR: Unable to connect: ' . $err->getMessage();
        die();
    }
?>