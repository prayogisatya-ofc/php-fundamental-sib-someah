<?php

require "config/app.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$id_category = (int)$_GET['id'];

$getDatabyId = query("SELECT * FROM categories WHERE id_category = $id_category");

if (count($getDatabyId) < 1) {
    echo "<script>
        alert('Category not found!');
        document.location.href = 'categories.php';
    </script>";
}

if (delete_category($id_category) > 0) {
    echo "<script>
        alert('Category successfully deleted!');
        document.location.href = 'categories.php';
    </script>";
} else {
    echo "<script>
        alert('Category failed to be deleted!');
        document.location.href = 'categories.php';
    </script>";
}