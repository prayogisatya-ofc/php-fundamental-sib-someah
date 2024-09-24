<?php 

$title = "Detail Film";

require "./layout/header.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$id_film = (int)$_GET['id'];

$film = query("SELECT f.id_film, f.title, c.title AS category, f.studio, f.release_date, f.created_at, f.is_private, f.url, f.description FROM films f JOIN categories c ON f.category_id = c.id_category WHERE id_film = $id_film")[0];

if (!$film) {
    echo "<script>
            alert('Film not found!');
            document.location.href = 'films.php';
        </script>";
}

?>

<!-- main -->
<main class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <?= $title ?>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <iframe 
                                width="560" 
                                height="315" 
                                src="https://www.youtube.com/embed/<?= $film['url'] ?>" 
                                title="YouTube video player" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                referrerpolicy="strict-origin-when-cross-origin" 
                                allowfullscreen
                                class="mb-3 rounded">
                            </iframe>
                        </div>
                        <div class="table-responsive">
                            <table class="nowrap table table-bordered table-striped" style="width:100%">
                                <tr>
                                    <th>Title</th>
                                    <td><?= $film['title'] ?></td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td><?= $film['category'] ?></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td><?= $film['description'] ?></td>
                                </tr>
                                <tr>
                                    <th>Studio</th>
                                    <td><?= $film['studio'] ?></td>
                                </tr>
                                <tr>
                                    <th>Release Date</th>
                                    <td><?= $film['release_date'] ?></td>
                                </tr>
                                <tr>
                                    <th>Created at</th>
                                    <td><?= $film['created_at'] ?></td>
                                </tr>
                                <tr>
                                    <th>Visibility</th>
                                    <td>
                                        <span class="badge rounded-pill text-bg-<?= $film['is_private'] ? 'danger' : 'success' ?>">
                                            <?= $film['is_private'] ? 'Private' : 'Public' ?>    
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="float-end">
                            <a href="films-edit.php?id=<?= $film['id_film'] ?>" class="btn btn-success">Edit</a>
                            <a href="films.php" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require "./layout/footer.php"; ?>