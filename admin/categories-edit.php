<?php 

$title = "Edit Category";

require "./layout/header.php";

if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Please login first!');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$id_category = (int)$_GET['id'];

if (isset($_POST['submit'])) {
    if (update_category($_POST) > 0) {
        echo "<script>
            alert('Category successfully updated!');
            document.location.href = 'categories.php';
        </script>";
    } else {
        echo "<script>
            alert('Category failed to be updated!');
            document.location.href = 'categories-edit.php?id=$id_category';
        </script>";
    }
}

$category = query("SELECT * FROM categories WHERE id_category = $id_category")[0];

if (!$category) {
    echo "<script>
            alert('Category not found!');
            document.location.href = 'categories.php';
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
                            <input type="hidden" name="id_category" value="<?= $category['id_category'] ?>">
                            <div class="mb-3">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?= $category['title'] ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="slug">Slug</label>
                                <input type="text" class="form-control" name="slug" id="slug" value="<?= $category['slug'] ?>" readonly>
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