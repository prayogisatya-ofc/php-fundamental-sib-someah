<?php 

$title = "Create User";

require "./layout/header.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

if (isset($_POST['submit'])) {
    if (store_user($_POST) > 0) {
        echo "<script>
            alert('User successfully created!');
            document.location.href = 'users.php';
        </script>";
    } else {
        echo "<script>
            alert('User failed to be created!');
            document.location.href = 'users-create.php';
        </script>";
    }
}

?>

<!-- main -->
<main class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <?= $title ?>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Passowrd</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="role">Role</label>
                                <select name="role" id="role" class="form-select">
                                    <option value="">Pilih role</option>
                                    <option value="operator">Operator</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="float-end">
                                <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require "./layout/footer.php"; ?>