<?php 

$title = "Categories";

require "./layout/header.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$categories = query("SELECT * FROM categories ORDER BY created_at DESC");

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
                        <div class="d-flex">
                            <a href="categories-create.php" class="btn btn-primary mb-2 me-2"><i class="bi bi-plus me-1"></i>Create</a>
                            <form action="categories-download.php" method="get">
                                <button type="submit" class="btn btn-success mb-2"><i class="bi bi-download me-2"></i>Download</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="datatable nowrap table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="1%" class="text-center">No</th>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th class="text-start">Created at</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no =1 ?>
                                    <?php foreach($categories as $category): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $category['title'] ?></td>
                                            <td><?= $category['slug'] ?></td>
                                            <td class="text-start"><?= $category['created_at'] ?></td>
                                            <td class="text-center">
                                                <a href="categories-edit.php?id=<?= $category['id_category'] ?>" class="btn btn-sm btn-success mb-1" title="Edit"><i class="bi bi-pen"></i></a>
                                                <a href="categories-delete.php?id=<?= $category['id_category'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger mb-1" title="Hapus"><i class="bi bi-trash"></i></a>
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