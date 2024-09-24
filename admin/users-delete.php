<?php

require "config/app.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

if ($_SESSION['role'] != 'admin') {
    echo "<script>
        alert('Access denied!');
        document.location.href = 'users.php';
    </script>";
    exit;
}

$id_user = (int)$_GET['id'];

$getDatabyId = query("SELECT * FROM users WHERE id_user = $id_user");

if (count($getDatabyId) < 1) {
    echo "<script>
        alert('User not found!');
        document.location.href = 'users.php';
    </script>";
}

if (delete_user($id_user) > 0) {
    echo "<script>
        alert('User successfully deleted!');
        document.location.href = 'users.php';
    </script>";
} else {
    echo "<script>
        alert('User failed to be deleted!');
        document.location.href = 'users.php';
    </script>";
}