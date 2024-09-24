<?php 

$title = "Films";

require "./layout/header.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$films = query("SELECT f.id_film, f.title, c.title AS category, f.studio, f.is_private, f.created_at FROM films f JOIN categories c ON f.category_id = c.id_category ORDER BY created_at DESC");

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
                            <a href="films-create.php" class="btn btn-primary mb-2 me-2"><i class="bi bi-plus me-1"></i>Create</a>
                            <form action="films-download.php" method="get">
                                <button type="submit" class="btn btn-success mb-2"><i class="bi bi-download me-2"></i>Download</button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="datatable nowrap table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="1%" class="text-center">No</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Studio</th>
                                        <th>Visibility</th>
                                        <th>Created at</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no =1 ?>
                                    <?php foreach($films as $film): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $film['title'] ?></td>
                                            <td><?= $film['category'] ?></td>
                                            <td><?= $film['studio'] ?></td>
                                            <td>
                                                <span class="badge rounded-pill text-bg-<?= $film['is_private'] ? 'danger' : 'success' ?>">
                                                    <?= $film['is_private'] ? 'Private' : 'Public' ?>    
                                                </span>
                                            </td>
                                            <td><?= $film['created_at'] ?></td>
                                            <td class="text-center">
                                                <a href="films-detail.php?id=<?= $film['id_film'] ?>" class="btn btn-sm btn-secondary mb-1" title="Edit"><i class="bi bi-eye"></i></a>
                                                <a href="films-edit.php?id=<?= $film['id_film'] ?>" class="btn btn-sm btn-success mb-1" title="Edit"><i class="bi bi-pen"></i></a>
                                                <a href="films-delete.php?id=<?= $film['id_film'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger mb-1" title="Hapus"><i class="bi bi-trash"></i></a>
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