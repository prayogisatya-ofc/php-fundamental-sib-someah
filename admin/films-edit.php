<?php 

$title = "Edit Film";

require "./layout/header.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$id_film = (int)$_GET['id'];

if (isset($_POST['submit'])) {
    if (update_film($_POST) > 0) {
        echo "<script>
            alert('Film successfully updated!');
            document.location.href = 'films.php';
        </script>";
    } else {
        echo "<script>
            alert('Film failed to be updated!');
            document.location.href = 'films-edit.php?id=$id_film';
        </script>";
    }
}

$film = query("SELECT * FROM films WHERE id_film = $id_film")[0];

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
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <?= $title ?>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <input type="hidden" name="id_film" value="<?= $film['id_film'] ?>">
                            <div class="mb-3">
                                <label class="form-label" for="url">URL <small>(Ambil dari YouTube)</small></label>
                                <input type="text" class="form-control" name="url" id="url" value="<?= $film['url'] ?>" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title" value="<?= $film['title'] ?>" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="slug">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug" value="<?= $film['slug'] ?>" readonly required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" required rows="5"><?= $film['description'] ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="category">Category</label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">Pilih category</option>
                                        <?php foreach(query("SELECT * FROM categories") as $category): ?>
                                            <option <?php if ($category['id_category'] == $film['category_id']) echo "selected" ?> value="<?= $category['id_category'] ?>"><?= $category['title'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="studio">Studio</label>
                                    <input type="text" class="form-control" name="studio" id="studio" value="<?= $film['studio'] ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="release_date">Release Date</label>
                                    <input type="date" class="form-control" name="release_date" id="release_date" value="<?= $film['release_date'] ?>" required>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="visibility">Visibility</label>
                                    <select name="visibility" id="visibility" class="form-control" required>
                                        <option <?php if ($film['is_private'] == 1) echo "selected" ?> value="1">Private</option>
                                        <option <?php if ($film['is_private'] == 0) echo "selected" ?> value="0">Public</option>
                                    </select>
                                </div>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="assets/js/helper.js"></script>
<script>
    $(document).ready(function() {
        $('#title').on('input', function() {
            $('#slug').val(slugify($(this).val()));
        })
    })
</script>

<?php require "./layout/footer.php"; ?>