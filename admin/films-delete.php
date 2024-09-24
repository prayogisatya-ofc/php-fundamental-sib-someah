<?php

require "config/app.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$id_film = (int)$_GET['id'];

$getDatabyId = query("SELECT * FROM films WHERE id_film = $id_film");

if (count($getDatabyId) < 1) {
    echo "<script>
        alert('Film not found!');
        document.location.href = 'films.php';
    </script>";
}

if (delete_film($id_film) > 0) {
    echo "<script>
        alert('Film successfully deleted!');
        document.location.href = 'films.php';
    </script>";
} else {
    echo "<script>
        alert('Film failed to be deleted!');
        document.location.href = 'films.php';
    </script>";
}