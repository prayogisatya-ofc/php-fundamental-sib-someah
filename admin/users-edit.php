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

$id_user = (int)$_GET['id'];

if ($id_user != $_SESSION['id'] && $_SESSION['role'] != 'admin') {
    echo "<script>
        alert('Access denied!');
        document.location.href = 'users.php';
    </script>";
    exit;
}

if (isset($_POST['submit'])) {
    if (update_user($_POST) > 0) {
        echo "<script>
            alert('User successfully updated!');
            document.location.href = 'users.php';
        </script>";
    } else {
        echo "<script>
            alert('User failed to be updated!');
            document.location.href = 'users-edit.php?id=$id_user';
        </script>";
    }
}

$user = query("SELECT * FROM users WHERE id_user = $id_user")[0];

if (!$user) {
    echo "<script>
            alert('User not found!');
            document.location.href = 'users.php';
        </script>";
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
                            <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" value="<?= $user['username'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Passowrd</label>
                                <input type="password" class="form-control" name="password" id="password">
                                <small class="form-text">Kosongkan jika tidak ingin diganti</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?= $user['email'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="role">Role</label>
                                <select name="role" id="role" class="form-select" <?= $_SESSION['role'] != 'admin' ? 'disabled' : '' ?> required>
                                    <option value="">Pilih role</option>
                                    <option <?= $user['role'] == 'operator' ? 'selected' : '' ?> value="operator">Operator</option>
                                    <option <?= $user['role'] == 'admin' ? 'selected' : '' ?> value="admin">Admin</option>
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