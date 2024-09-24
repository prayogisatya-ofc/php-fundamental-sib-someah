<?php 

$title = "Users";

require "./layout/header.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

if ($_SESSION['role'] == 'operator') {
    $users = query("SELECT * FROM users WHERE id_user = {$_SESSION['id']}");
} else {
    $users = query("SELECT * FROM users ORDER BY created_at DESC");
}

?>

<!-- main -->
<main class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <?= $title ?>
                    </div>
                    <div class="card-body">
                        <?php if ($_SESSION['role'] == 'admin') : ?>
                            <a href="users-create.php" class="btn btn-primary mb-2"><i class="bi bi-plus me-1"></i>Create</a>
                        <?php endif ?>
                        <div class="table-responsive">
                            <table class="datatable nowrap table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="1%" class="text-center">No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th class="text-start">Created at</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no =1 ?>
                                    <?php foreach($users as $user): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $user['username'] ?></td>
                                            <td><?= $user['email'] ?></td>
                                            <td><?= $user['role'] ?></td>
                                            <td class="text-start"><?= $user['created_at'] ?></td>
                                            <td class="text-center">
                                                <a href="users-edit.php?id=<?= $user['id_user'] ?>" class="btn btn-sm btn-success mb-1" title="Edit"><i class="bi bi-pen"></i></a>
                                                
                                                <?php if ($_SESSION['role'] == 'admin') : ?>
                                                    <a href="users-delete.php?id=<?= $user['id_user'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger mb-1" title="Hapus"><i class="bi bi-trash"></i></a>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require "./layout/footer.php"; ?>